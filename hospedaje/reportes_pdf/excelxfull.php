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
    if($idEmpresa != 1)
    {
        $objPHPExcel = PHPExcel_IOFactory::load("excel/reporte2full.xlsx"); 
        $sheet = $objPHPExcel->getActiveSheet();  

        $sql = "SELECT CONCAT(ELT(MONTH('". $dia_ini ."'), 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE')) AS MesName;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $mes1 = $row['MesName'];

        $sql = "SELECT contratoEmpresa, contratoEmpresa1, valorDesayuno, valorAlmuerzo, valorCena, valorExtra FROM empresa WHERE idEmpresa = " .  $idEmpresa;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $valorDes = $row['valorDesayuno'];
        $valorAlm = $row['valorAlmuerzo'];
        $valorCen = $row['valorCena'];
        $valorExt = $row['valorExtra'];
        
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
        $sheet->setCellValue('AL15', $fecha_label);    

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
            $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$letras_indice] . 15, $inicial);

            $letras_indice++;
        } 
        $suma_vertical = [];
        for ($i=0; $i < count($dias_arr); $i++) { 
            $suma_vertical[$i] = 0;
        }
    
        $sql = "
            SELECT DISTINCT ho.idHospedaje, h.nombreHotel, p.apellidoPersona1, p.apellidoPersona2, 
                p.nombresPersona, p.rutPersona, ha.nHabitacion, ho.idPersona, ho.tipoHabitacion
            FROM hospedaje ho
            INNER JOIN persona p ON ho.idPersona = p.idPersona
            INNER JOIN hotel h ON ho.idHotel = h.idHotel
            INNER JOIN habitacion ha ON ho.idHabitacion = ha.idHabitacion
            INNER JOIN resumenhospedaje rh ON rh.idHospedaje = ho.idHospedaje
            WHERE p.idEmpresa = $idEmpresa
            AND rh.Act = 1
            AND rh.FechaR BETWEEN '$dia_ini' AND '$dia_fin'
            ORDER BY h.nombreHotel,ha.nHabitacion
        ";

        $fechas_aux = [];

        $count = 0;
        $count_total = 0;
        $cont = 8;
        $ContratoEmpresa = 28000;
        $neto = 0;
        
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
                    $ContratoEmpresa = 32000;
                else if($row['tipoHabitacion'] == 'S')
                    $ContratoEmpresa = 28000;
                
            $objPHPExcel->getActiveSheet()->setCellValue('A'. $cont, $nombreHotel);
            $objPHPExcel->getActiveSheet()->setCellValue('B'. $cont, $nHabitacion);
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $cont, $apellidoPersona1);
            $objPHPExcel->getActiveSheet()->setCellValue('D'. $cont, $apellidoPersona2);
            $objPHPExcel->getActiveSheet()->setCellValue('E'. $cont, $nombresPersona);
            $objPHPExcel->getActiveSheet()->setCellValue('F'. $cont, $rutPersona);                   

                $tds = '';
                $fechas_aux = [];
                $count = 0;
                $count_comida = 0;
    
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

        $total_alm = 0;
        $total_des = 0;
        $total_alm2 = 0;
        $total_cen = 0;
        $total_ext = 0;
        $total_col = 0;
       for($i = 0; $i < count($dias_arr); $i++) {

            $sql3 = "SELECT e.idEmpresa, c.tipoComida, COUNT(*) AS total, c.fechaComida
            FROM comida c INNER JOIN persona p ON c.idPersona = p.idPersona
            INNER JOIN empresa e ON p.idEmpresa = e.idEmpresa
            WHERE e.idEmpresa = ". $idEmpresa ." AND c.fechaComida = '". $dias_arr[$i] ."'
            GROUP BY e.idEmpresa, c.tipoComida, c.fechaComida;";                  
            $result3 = mysqli_query($conn, $sql3);   
    
            $numero_filas = mysqli_num_rows($result3); 
            $balm = false;              
            $bdes = false;              
            $bcena = false;              
            $balm2 = false;              
            $bcol = false;              
            
            if($numero_filas > 0){
                while($row3 = mysqli_fetch_assoc($result3)) {
                    $tipo_comida = $row3['tipoComida']; 
                                    
                if($tipo_comida == 'Desayuno'){
                $count_comida = 10;
                $bdes = true;  
                // Ahora el total de desayunos no viene de la tabla comida, sino de hospedajes
                $total_des += $suma_vertical[$i];
                }                    

/*
                    else if($tipo_comida == 'Cena'){
                        $count_comida = 12;
                        $bcena = true;  
                        $total_cen += $row3['total'];
                    }                    
                    else if($tipo_comida == 'ALMUERZOSC-19'){
                        $count_comida = 11;
                        $balm2 = true;  
                        $total_alm2 += $row3['total'];
                    }                    
                    else if($tipo_comida == 'COLACIONES-FRIAS'){
                        $count_comida = 14;
                        $bcol = true;  
                        $total_col += $row3['total'];
                    }   
*/


                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . ($count_comida + $cont), $suma_vertical[$i]);


                    /*
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . ($count_comida + $cont), $row3['total']);*/
                    $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . ($count_comida + $cont))->applyFromArray( $bg_white );

                }
                if($balm == false){
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (9 + $cont), 0);
                    $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (9 + $cont))->applyFromArray( $bg_red );
                }
                if($bdes == false){
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (10 + $cont), 0);
                    $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (10 + $cont))->applyFromArray( $bg_red );
                }
               
            }else{
                
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (9 + $cont), 0);
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (10 + $cont), 0);
              
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (9 + $cont))->applyFromArray( $bg_red );
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (10 + $cont))->applyFromArray( $bg_red );
     

            } 
        }
           /* 
        $total_col = 0;
        for($i = 0; $i < count($dias_arr); $i++) {

            $sql3 = "SELECT tipoComida, COUNT(*) AS total
            FROM comidaextra
            WHERE idEmpresa = ". $idEmpresa ." AND fechaComida = '". $dias_arr[$i] ."'
            GROUP BY idEmpresa, tipoComida, fechaComida;";                  
            $result3 = mysqli_query($conn, $sql3);   
            $numero_filas = mysqli_num_rows($result3);            
            
            if($numero_filas > 0){
                while($row3 = mysqli_fetch_assoc($result3)) {                                
                    $total_ext += $row3['total'];
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (13 + $cont), $row3['total']);
                    $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (13 + $cont))->applyFromArray( $bg_white );

                }
            }else{
                
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (13 + $cont), 0);
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (13 + $cont))->applyFromArray( $bg_red );

            } 
        }*/

          
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (9 + $cont), $total_alm);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (10 + $cont), $total_des);
          /*
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (11 + $cont), $total_alm2);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (12 + $cont), $total_cen);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (13 + $cont), $total_ext);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (14 + $cont), $total_col);
        

        */


        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (9 + $cont), $valorAlm);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (10 + $cont), $valorDes);

        /*
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (11 + $cont), $valorAlm);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (12 + $cont), $valorCen);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (13 + $cont), $valorExt);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (14 + $cont), 0);
*/

        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (9 + $cont), $valorAlm * $total_alm);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (10 + $cont), $valorDes * $total_des);

        /*
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (11 + $cont), $valorAlm * $total_alm2);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (12 + $cont), $valorCen * $total_cen);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (13 + $cont), $valorExt * $total_ext);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (14 + $cont), 0);

        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (16 + $cont), $neto);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (17 + $cont), $valorAlm * $total_alm);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (18 + $cont), $valorDes * $total_des);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (19 + $cont), $valorAlm * $total_alm2);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (20 + $cont), $valorCen * $total_cen);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (21 + $cont), $valorExt * $total_ext);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (22 + $cont), 0);

        $total_abs = $neto + ($valorAlm * $total_alm) + ($valorDes * $total_des) + ($valorAlm * $total_alm2) + ($valorCen * $total_cen) + ($valorExt * $total_ext);
        $total_iva = $total_abs * $iva;
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (24 + $cont), $total_abs);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (25 + $cont), $total_iva);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (26 + $cont), $total_abs + $total_iva);
*/
        //return;
        //$cont++; 
        $objPHPExcel->getActiveSheet()->removeRow($cont);
        for ($i=0; $i < count($dias_arr); $i++) { 
            $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . $cont, $suma_vertical[$i]);
        }
        
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . $cont, $count_total);
        $objPHPExcel->getActiveSheet()->setCellValue('G1', $nombreEmpresa);

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
   }
  
?>