<?php
    include('mysql.php');
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Style\Color;
    use PhpOffice\PhpSpreadsheet\Style\Conditional;
    use PhpOffice\PhpSpreadsheet\Style\Font;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
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

    $sheet->setCellValue('C6', 'ASISTENCIAS DE '. $MesName);

    $sql = "SELECT RIGHT(LAST_DAY('". $mes ."'),2) dias;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $num_days = $row['dias'];

    $new_date = substr($mes, 0, -2); 
    $last_letter = '';
    $dias_name = '';

    $letras_excel = ['F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
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

        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$letras_indice] . 7, $inicial);
        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$letras_indice] . 8, $i);
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

    $cont = 9;   
    $con = 1;
    $letras_indice2 = 0;
    $vertical_sum = array();
    $total_sum = 0;
    for ($i=0; $i < $num_days; $i++) { 
        $vertical_sum[$i] = 0;
    }

    $cont_rows = 9;
    if( $result = mysqli_query($conn, $sql))
    {  
        $colorFlag = true;
        while($row = mysqli_fetch_assoc($result))
        {   
            $cont_rows++;
            $days_count = 0;
            $name = $row['name'];
            $labor = $row['labor'];
            $nombreHotel = $row['nombreHotel'];
            $idTrabajador = $row['idTrabajador'];
            $objPHPExcel->getActiveSheet()->setCellValue('B'. $cont, $con);
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $cont, $name);
            $objPHPExcel->getActiveSheet()->setCellValue('D'. $cont, $labor);
            $objPHPExcel->getActiveSheet()->setCellValue('E'. $cont, $nombreHotel);
            

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
                                $days_count++;      
                                $vertical_sum[($j-1)] += 1;  
                                break;
                            }
                            else{ 
                                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$jaux - 1] . $cont, ' ');  
                                $letras_indice2++;   
                                $jaux++;
                                break;
                            }
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$jaux - 1] . $cont, ' ');
                        }
            
                    }
                }
                $total_sum += $days_count;
            }

            if($colorFlag)    
                $objPHPExcel
                    ->getActiveSheet()
                    ->getStyle("C$cont:$letras_excel[$letras_indice]$cont") 
                    ->getFill()
                    ->getStartColor()
                    ->setARGB('DDDDDD');
            else
                $objPHPExcel
                ->getActiveSheet()
                ->getStyle("C$cont:$letras_excel[$letras_indice]$cont") 
                ->getFill()
                ->getStartColor()
                ->setARGB('FFFFFF');
            $colorFlag = !$colorFlag;
            $objPHPExcel->getActiveSheet()->setCellValue( "AK".$cont , $days_count );
            $cont++;
            $con++;
            $sheet->insertNewRowBefore($cont);
            //$sheet->setCellValue('A'. $cont, 'Updated');
        }
    }
 
    for ($i=0; $i < count($vertical_sum); $i++) { 
        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . $cont_rows, $vertical_sum[$i]);
    }
    $objPHPExcel->getActiveSheet()->setCellValue( "AK". $cont_rows, $total_sum );

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





