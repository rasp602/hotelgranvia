<?php
  include('../../bd/mysql.php');
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    require_once 'excel/Classes/PHPExcel/IOFactory.php';
    require_once 'excel/Classes/PHPExcel.php';

$dia_ini = $_GET['dia_ini'];
$dia_fin = $_GET['dia_fin'];
$idEmpresa = $_GET['idEmpresa'];

    $iva = 0.19;

    $objPHPExcel = PHPExcel_IOFactory::load("excel/reporte2.xlsx"); 
    $sheet = $objPHPExcel->getActiveSheet();  

    

    $sql = "SELECT CONCAT(ELT(MONTH('". $dia_ini ."'), 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE')) AS MesName;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $mes1 = $row['MesName'];
    
    $sql = "SELECT CONCAT(ELT(MONTH('". $dia_fin ."'), 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE')) AS MesName;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $mes2 = $row['MesName'];
    
    $dia1 = substr($dia_ini, 8, 10); 
    $dia2 = substr($dia_fin, 8, 10); 

    $fecha_label = '';
    if($mes1 == $mes2)
        $fecha_label = $mes1 . ' ' . $dia1 . ' al ' . $dia2;
    else
        $fecha_label = $mes1 . ' ' . $dia1 . ' a ' . $mes2 . ' '. $dia2;

    $header = '';
    $body = '';
    $tds = '';

    $sheet->setCellValue('AL6', $fecha_label);    

    $sql = 'SELECT TIMESTAMPDIFF(DAY, "'. $dia_ini .'", "'. $dia_fin .'") AS num_days, nombreEmpresa FROM empresa WHERE idEmpresa =' . $idEmpresa;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $num_days = $row['num_days'];
    $nombreEmpresa = $row['nombreEmpresa'];

    if($num_days > 31){
        echo 'El parametro de fechas no puede ser mayor a 31 dias';
        return;
    }

    $dias_name = '';
    $dias_arr = [];

    $letras_excel = ['G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
    $letras_indice = 0;
  

    for($i=0;$i<=$num_days;$i++) {
        $sql = "SELECT DATE_ADD('". $dia_ini ."', INTERVAL $i DAY) AS new_day;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $inicial = $row['new_day'];
        $dias_arr [] = $inicial;
    
        //$dias_name .= '<td style="text-rotate: 90; padding: 3px" class="fecha" rowspan="2">'. $inicial .'</td>';
        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$letras_indice] . 6, $inicial);

        $letras_indice++;
    }
    
    $suma_vertical = [];
    for ($i=0; $i < count($dias_arr); $i++) { 
        $suma_vertical[$i] = 0;
    }
   
    $sql = '
        SELECT ho.idHospedaje, h.nombreHotel, p.apellidoPersona1, p.apellidoPersona2, p.nombresPersona,
        p.rutPersona, ha.nHabitacion, ho.idPersona, ho.tipoHabitacion FROM hospedaje ho
        INNER JOIN persona p ON ho.idPersona = p.idPersona
        INNER JOIN hotel h ON ho.idHotel = h.idHotel
        INNER JOIN habitacion ha ON ho.idHabitacion = ha.idHabitacion
        WHERE p.idEmpresa = '. $idEmpresa .'
        ORDER BY ho.idPersona
    ';

    $fechas_aux = [];

    $count = 0;
    $count_total = 0;
    $cont = 8;
    $ContratoEmpresa = 28000;
    $neto = 0;
    $bg_red = array(                  
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb'=>'f48484'),
        )
    );

    $bg_white = array(                  
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb'=>'ffffff'),
        )
    );
    
    if($result = mysqli_query($conn, $sql))
    {  
        while($row = mysqli_fetch_assoc($result)) 
        {
            $nombreHotel = $row['nombreHotel'];
            $apellidoPersona1 = $row['apellidoPersona1'];
            $apellidoPersona2 = $row['apellidoPersona2'];
            $nombresPersona = $row['nombresPersona'];
            $rutPersona = $row['rutPersona'];
            $nHabitacion = $row['nHabitacion'];

            if($row['tipoHabitacion'] == 'D')
                $ContratoEmpresa = 56000;
            else if($row['tipoHabitacion'] == 'S')
                $ContratoEmpresa = 28000;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A'. $cont, $nombreHotel);
            $objPHPExcel->getActiveSheet()->setCellValue('B'. $cont, $apellidoPersona1);
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $cont, $apellidoPersona2);
            $objPHPExcel->getActiveSheet()->setCellValue('D'. $cont, $nombresPersona);
            $objPHPExcel->getActiveSheet()->setCellValue('E'. $cont, $rutPersona);
            $objPHPExcel->getActiveSheet()->setCellValue('F'. $cont, $nHabitacion);
            
            

            $tds = '';
            $fechas_aux = [];
            $count = 0;
 
            $sql2 = "SELECT FechaR FROM resumenhospedaje
            WHERE idHospedaje = ". $row['idHospedaje'] ." AND Act = 1
            ORDER BY FechaR ASC;";
                        
            if($result2 = mysqli_query($conn, $sql2))
            {
                while($row2 = mysqli_fetch_assoc($result2)) {
                    $fechas_aux[] = $row2['FechaR']; 
                    
                }

                for($i = 0; $i < count($dias_arr); $i++) {
                    $found = array_search($dias_arr[$i], $fechas_aux );
                    if($found !== false){
                        $tds .= '<td class="fecha">1</td>'; 
                        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . $cont, 1);
                        $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . $cont)->applyFromArray( $bg_white );
                        $count++;
                        $suma_vertical[$i] += 1;
                    }else{
                        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . $cont)->applyFromArray( $bg_red );
                    } 
                }
            }
            $count_total += $count;
            $neto += $ContratoEmpresa;
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $cont, $count);
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $cont, $ContratoEmpresa);
            $objPHPExcel->getActiveSheet()->setCellValue('AN' . $cont, (intval($ContratoEmpresa) * intval($count)));
            $cont++;      
            $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . $cont)->applyFromArray( $bg_white );      
            $sheet->insertNewRowBefore($cont);
        }        
    }
    
    //$cont++; 
    $objPHPExcel->getActiveSheet()->removeRow($cont);
    for ($i=0; $i < count($dias_arr); $i++) { 
        $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . $cont, $suma_vertical[$i]);
    }
    
    $objPHPExcel->getActiveSheet()->setCellValue('AL' . $cont, $count_total);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', $nombreEmpresa);

    $col_comp = count($dias_arr) + 9;
   
    $precio_iva = $neto * $iva;

    $cont += 2;
    $objPHPExcel->getActiveSheet()->setCellValue('AN' . $cont, $neto);
    $cont++;
    $objPHPExcel->getActiveSheet()->setCellValue('AN' . $cont, $precio_iva);
    $cont++;
    $objPHPExcel->getActiveSheet()->setCellValue('AN' . $cont, $neto + $precio_iva);


    $now = new DateTime();
    $filename = "Reporte de estado de pago ". $now->format('Y-m-d H-i-s');
    header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
    header('Cache-Control: max-age=0');         
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $writer->setIncludeCharts(TRUE);
    $writer->save('php://output');  

    return;
   
?>





