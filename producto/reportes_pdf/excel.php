<?php
    include('mysql.php');
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    require_once 'excel/Classes/PHPExcel/IOFactory.php';
    require_once 'excel/Classes/PHPExcel.php';

    $mes = $_GET['mes'];//'2023-01-18';
    $idempleado = $_GET['idTrabajador'];//18;

    $objPHPExcel = PHPExcel_IOFactory::load("excel/reporte.xlsx"); 
    $sheet = $objPHPExcel->getActiveSheet();  

    $sql = "SELECT CONCAT(ELT(MONTH('". $mes ."'), 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE')) AS MesName;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $MesName = $row['MesName'];

    $sheet->setCellValue('D10', 'ASISTENCIAS DE '. $MesName);

    $sql = "SELECT RIGHT(LAST_DAY('". $mes ."'),2) dias;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $num_days = $row['dias'];

    $new_date = substr($mes, 0, -2); 
    $last_letter = '';
    $dias_name = '';

    $letras_excel = ['G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
    $letras_indice = 0;
  
    for($i=1;$i<=$num_days;$i++) {

        if($i < 10)
            $last_letter = '0' . $i;
        else
            $last_letter = $i;

        $sql = "SELECT CONCAT(ELT(WEEKDAY('". $new_date . $last_letter ."') + 1, 'L', 'M', 'MI', 'J', 'V', 'S', 'D')) AS inicial";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $inicial = $row['inicial'];

        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$letras_indice] . 11, $inicial);
        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$letras_indice] . 12, $i);
        $letras_indice++;

    }

    $sql_empleado = '';

    if($idempleado > 0) $sql_empleado = ' AND e.idTrabajador = ' . $idempleado;

    
    $sql = "SELECT CONCAT(t.nombreTrabajador,' ', t.apellidoTrabajador1) AS name, h.nombreHotel,
    t.labor, e.idTrabajador
    FROM trabajador t INNER JOIN hotel h ON t.idHotel = h.idHotel
    INNER JOIN entradat e ON t.idTrabajador = e.idTrabajador
    WHERE e.fecha BETWEEN DATE_ADD(DATE_ADD(LAST_DAY('". $mes ."'), INTERVAL 1 DAY),INTERVAL -1 MONTH) AND LAST_DAY('". $mes ."') ". $sql_empleado ."
    GROUP BY e.idTrabajador
    ORDER BY h.idHotel,t.labor;";

    $cont = 13;   
    $con = 1;
    $letras_indice2 = 0;
    if( $result = mysqli_query($conn, $sql))
    {  
        while($row = mysqli_fetch_assoc($result))
        {   
            $name = $row['name'];
            $labor = $row['labor'];
            $nombreHotel = $row['nombreHotel'];
            $idTrabajador = $row['idTrabajador'];
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $cont, $con);
            $objPHPExcel->getActiveSheet()->setCellValue('D'. $cont, $name);
            $objPHPExcel->getActiveSheet()->setCellValue('E'. $cont, $labor);
            $objPHPExcel->getActiveSheet()->setCellValue('F'. $cont, $nombreHotel);

            $sql2 = "SELECT RIGHT(e.fecha,2) * 1 AS fechac, RIGHT(e.fechaEntradaT,2) * 1 AS fechaEntradaT, e.fechaSalida
                    FROM entradat e WHERE e.idTrabajador = ". $idTrabajador ." AND e.fecha BETWEEN DATE_ADD(DATE_ADD(LAST_DAY('". $mes ."'), INTERVAL 1 DAY),INTERVAL -1 MONTH) AND LAST_DAY('". $mes ."') ". $sql_empleado ."
                    ORDER BY e.idTrabajador, e.fecha ASC ;";
            if($result2 = mysqli_query($conn, $sql2))
            {
                $jaux = 1;
                while($row2 = mysqli_fetch_assoc($result2)) {
                    for($j = $jaux; $j<=$num_days; $j++,$jaux++){                    
                        if($row2['fechac'] == $j){                        
                            if(intval($row2['fechaEntradaT']) != 0){
                                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$jaux - 1] . $cont, '✔');
                                $letras_indice2++;     
                                $jaux++;                     
                                break;
                            }
                            else{ 
                                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$jaux - 1] . $cont, '');  
                                $letras_indice2++;   
                                $jaux++;
                                break;
                            }
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$jaux - 1] . $cont, '');
                        }
            
                    }
                }
            }
            
            $cont++;
            $con++;
            $sheet->insertNewRowBefore($cont);
            //$sheet->setCellValue('A'. $cont, 'Updated');
        }
    }
 



    $now = new DateTime();
    $filename = "Reporte de entradas-salidas ". $now->format('Y-m-d H-i-s');
    header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
    header('Cache-Control: max-age=0');         
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $writer->setIncludeCharts(TRUE);
    $writer->save('php://output');  

    return;
?>





