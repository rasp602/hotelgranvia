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
                    if($tipo_comida == 'Almuerzo'){
                        $count_comida = 9;
                        $balm = true;
                        $total_alm += $row3['total'];
                    }                                      
                    else if($tipo_comida == 'Desayuno'){
                        $count_comida = 10;
                        $bdes = true;  
                        $total_des += $row3['total'];
                    }                    
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
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . ($count_comida + $cont), $row3['total']);
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
                if($bcena == false){
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (12 + $cont), 0);
                    $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (12 + $cont))->applyFromArray( $bg_red );
                }
                if($balm2 == false){
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (11 + $cont), 0);
                    $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (11 + $cont))->applyFromArray( $bg_red );
                }
                if($bcol == false){
                    $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (14 + $cont), 0);
                    $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (14 + $cont))->applyFromArray( $bg_red );
                }
            }else{
                
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (9 + $cont), 0);
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (10 + $cont), 0);
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (11 + $cont), 0);
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (12 + $cont), 0);
                $objPHPExcel->getActiveSheet()->setCellValue($letras_excel[$i] . (14 + $cont), 0);
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (9 + $cont))->applyFromArray( $bg_red );
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (10 + $cont))->applyFromArray( $bg_red );
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (11 + $cont))->applyFromArray( $bg_red );
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (12 + $cont))->applyFromArray( $bg_red );
                $objPHPExcel->getActiveSheet()->getStyle($letras_excel[$i] . (14 + $cont))->applyFromArray( $bg_red );

            } 
        }
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
        }
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (9 + $cont), $total_alm);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (10 + $cont), $total_des);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (11 + $cont), $total_alm2);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (12 + $cont), $total_cen);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (13 + $cont), $total_ext);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . (14 + $cont), $total_col);
        
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (9 + $cont), $valorAlm);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (10 + $cont), $valorDes);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (11 + $cont), $valorAlm);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (12 + $cont), $valorCen);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (13 + $cont), $valorExt);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . (14 + $cont), 0);

        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (9 + $cont), $valorAlm * $total_alm);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . (10 + $cont), $valorDes * $total_des);
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

        //return;
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
   }
   else
   {
        $objPHPExcel = PHPExcel_IOFactory::load("excel/reporte4.xlsx"); 
        $sheet = $objPHPExcel->getActiveSheet();  
        $dia1 = substr($dia_ini, 8, 10); 
        $dia2 = substr($dia_fin, 8, 10); 
    
        $columns = [];
        for ($i = ord('A'); $i <= ord('Z'); $i++) {
            $columns[] = chr($i);
        }
        for ($i = ord('A'); $i <= ord('D'); $i++) {
            for ($j = ord('A'); $j <= ord('Z'); $j++) {
                $columns[] = chr($i) . chr($j);
            }
        }        

        $sql = 'SELECT TIMESTAMPDIFF(DAY, "'. $dia_ini .'", "'. $dia_fin .'") AS num_days, nombreEmpresa FROM empresa WHERE idEmpresa =' . $idEmpresa;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $num_days = $row['num_days'];

        if($num_days > 31){
            echo 'El parametro de fechas no puede ser mayor a 31 dias';
            return;
        }

        $letras_indice = 6;
        for($i=0;$i<=$num_days;$i++) {
            $sql = "SELECT DATE_ADD('". $dia_ini ."', INTERVAL $i DAY) AS new_day;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $inicial = $row['new_day'];
            $dias_arr [] = $inicial;
            $letras_indice++;
            $par1 = $letras_indice;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($columns[$letras_indice]);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$letras_indice] . 2, 'Alojamiento');
            $letras_indice++;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($columns[$letras_indice]);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$letras_indice] . 2, 'Desayuno');
            $letras_indice++;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($columns[$letras_indice]);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$letras_indice] . 2, 'Almuerzo');
            $letras_indice++;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($columns[$letras_indice]);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$letras_indice] . 2, 'Cena');
            $par2 = $letras_indice;            
            $par_merg = ($columns[$par1] . 1) . ':' . ($columns[$par2] . 1);
            $objPHPExcel->getActiveSheet()->mergeCells($par_merg);
            
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$par1] . 1, $inicial);   
            
            $par_merg = ($columns[$par1] . 8) . ':' . ($columns[$par2] . 8);
            $objPHPExcel->getActiveSheet()->mergeCells($par_merg);
            $par_merg = ($columns[$par1] . 9) . ':' . ($columns[$par2] . 9);
            $objPHPExcel->getActiveSheet()->mergeCells($par_merg);
        } 

        $total_d = 0;
        $total_s = 0;
        $cont_s = 7;
        $cont_d = 7;
        for($i = 0; $i < (count($dias_arr)); $i++) {
            $sql = "SELECT tipohabitacion, COUNT(*) AS total
            FROM hospedaje WHERE desde = '". $dias_arr[$i] ."'
            GROUP BY tipohabitacion";     
            $bs = false;              
            $bd = false;
            
         
            $result = mysqli_query($conn, $sql);   
            $numero_filas = mysqli_num_rows($result);  
            
            if($numero_filas > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    
                    $tipohabitacion = $row['tipohabitacion']; 
                    if($tipohabitacion == 'D'){    
                        $bd = true;
                        $total_d += $row['total'];
                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_d] . 8, $row['total']);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_d] . 8)->applyFromArray( $bg_white );
                        $cont_d += 4;                        
                    }                                      
                    else if($tipohabitacion == 'S'){
                        
                        $bs = true;  
                        $total_s += $row['total'];
                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_s] . 9, $row['total']);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_s] . 9)->applyFromArray( $bg_white );
                        $cont_s += 4;
                    }                                                 
                }
                if($bd == false){
                    $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_d] . 8, 0);
                    $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_d] . 8)->applyFromArray( $bg_red );
                    $cont_d += 4;
                }
                if($bs == false){
                    $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_s] . 9, 0);
                    $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_s] . 9)->applyFromArray( $bg_red );
                    $cont_s += 4;
                }
                
            }else{
                
                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_d] . 8, 0);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_d] . 8)->applyFromArray( $bg_red );
                $cont_d += 4;                                                

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_s] . 9, 0);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_s] . 9)->applyFromArray( $bg_red );
                $cont_s += 4;
            } 
        }
        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_d] . 8, $total_d);        
        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_s] . 9, $total_s);
        
        //return;

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
        $count_total = 0;
        $cont = 3;
        
        $total_aloj = 0;
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
                $objPHPExcel->getActiveSheet()->setCellValue('B'. $cont, $nHabitacion);
                $objPHPExcel->getActiveSheet()->setCellValue('C'. $cont, $apellidoPersona1);
                $objPHPExcel->getActiveSheet()->setCellValue('D'. $cont, $apellidoPersona2);
                $objPHPExcel->getActiveSheet()->setCellValue('E'. $cont, $nombresPersona);
                $objPHPExcel->getActiveSheet()->setCellValue('F'. $cont, $rutPersona);                    
                $fechas_aux = [];
                $letras_indice = 7;
                $sql2 = "SELECT FechaR FROM resumenhospedaje
                WHERE idHospedaje = ". $row['idHospedaje'] ." AND Act = 1
                ORDER BY FechaR ASC;";      
                $total_aloj = 0;          
                if($result2 = mysqli_query($conn, $sql2))
                {
                    while($row2 = mysqli_fetch_assoc($result2)) {
                        $fechas_aux[] = $row2['FechaR'];                     
                    }
                    for($i = 0; $i < count($dias_arr); $i++) {
                        $found = array_search($dias_arr[$i], $fechas_aux );                    
                        
                        if($found !== false){
                            $total_aloj += 1;
                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$letras_indice] . $cont, 1);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$letras_indice] . $cont)->applyFromArray( $bg_white );                       
                            //$suma_vertical[$i] += 1;
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$letras_indice] . $cont, 0);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$letras_indice] . $cont)->applyFromArray( $bg_red );
                            
                        }
                        $letras_indice += 4; 
                    }
                } 

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$letras_indice] . $cont, $total_aloj);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$letras_indice] . $cont)->applyFromArray( $bg_white );

                $cont++;                      
                $sheet->insertNewRowBefore($cont);
            }        
        }

        $objPHPExcel->getActiveSheet()->removeRow($cont);

        $total_alm = 0;
        $total_des = 0;
        $total_cen = 0;
        

        $cont = 3;
        $sql = '
            SELECT ho.idPersona FROM hospedaje ho
            INNER JOIN persona p ON ho.idPersona = p.idPersona
            INNER JOIN hotel h ON ho.idHotel = h.idHotel
            INNER JOIN habitacion ha ON ho.idHabitacion = ha.idHabitacion
            WHERE p.idEmpresa = '. $idEmpresa .'
            ORDER BY ho.idPersona
        ';
        if($result = mysqli_query($conn, $sql))
        {  
            while($row = mysqli_fetch_assoc($result)) 
            {
                $cont_des = 8;
                $cont_alm = 9;
                $cont_cen = 10;

                $total_alm = 0;
                $total_des = 0;
                $total_cen = 0;

                for($i = 0; $i < count($dias_arr); $i++) {

                    $sql3 = "SELECT e.idEmpresa, c.tipoComida, COUNT(*) AS total, c.fechaComida
                    FROM comida c INNER JOIN persona p ON c.idPersona = p.idPersona
                    INNER JOIN empresa e ON p.idEmpresa = e.idEmpresa
                    WHERE e.idEmpresa = ". $idEmpresa ." AND c.fechaComida = '". $dias_arr[$i] ."' AND c.idPersona = '". $row['idPersona'] ."'
                    GROUP BY e.idEmpresa, c.tipoComida, c.fechaComida";    
                               
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
                            if($tipo_comida == 'Almuerzo'){
                                $balm = true;
                                $total_alm += $row3['total'];
                                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, $row3['total']);
                                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_white );
                                $cont_alm += 4;
                            }                                      
                            else if($tipo_comida == 'Desayuno'){
                                
                                $bdes = true;  
                                $total_des += $row3['total'];
                                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, $row3['total']);
                                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_white );
                                $cont_des += 4;
                            }                    
                            else if($tipo_comida == 'Cena'){                                
                                $bcena = true;  
                                $total_cen += $row3['total'];
                                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, $row3['total']);
                                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_white );
                                $cont_cen += 4;
                            }                                                 
                        }
                        if($balm == false){
                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, 0);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_red );
                            $cont_alm += 4;
                        }
                        if($bdes == false){
                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, 0);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_red );
                            $cont_des += 4;
                        }
                        if($bcena == false){
                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, 0);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_red );
                            $cont_cen += 4;
                        }
                    }else{
                        //echo 'No hay Datos --- ' . $cont_alm . ' ' . $cont_des . ' ' . $cont_cen .'<br>';  
                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_red );
                        $cont_alm += 4;                                                

                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_red );
                        $cont_des += 4;

                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_red );
                        $cont_cen += 4;
                    } 
                }

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, $total_alm);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_white );

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, $total_des);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_white );

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, $total_cen);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_white );
                $cont++;
            }
        }
 
        $sql = '
            SELECT ho.idPersona FROM hospedaje ho
            INNER JOIN persona p ON ho.idPersona = p.idPersona
            INNER JOIN hotel h ON ho.idHotel = h.idHotel
            INNER JOIN habitacion ha ON ho.idHabitacion = ha.idHabitacion
            WHERE p.idEmpresa = '. $idEmpresa .'
            ORDER BY ho.idPersona
        ';
        if($result = mysqli_query($conn, $sql))
        {  
            while($row = mysqli_fetch_assoc($result)) 
            {
                $cont_alm = 9;
                $cont_des = 8;
                $cont_alm = 9;
                $cont_cen = 10;
                $cont_alo = 7;
                $total_ext = 0;
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
                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, $row3['total']);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_white );
                            $cont_alm += 4;

                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alo] . $cont, 0);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alo] . $cont)->applyFromArray( $bg_red );
                            $cont_alo += 4;                                      

                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, 0);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_red );
                            $cont_des += 4;

                            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, 0);
                            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_red );
                            $cont_cen += 4;

                        }
                    }else{
                        
                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alo] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alo] . $cont)->applyFromArray( $bg_red );
                        $cont_alo += 4;

                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_red );
                        $cont_alm += 4;                                                

                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_red );
                        $cont_des += 4;

                        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, 0);
                        $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_red );
                        $cont_cen += 4;
                    } 
                }

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, $total_ext);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_white );

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alo] . $cont, 0);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alo] . $cont)->applyFromArray( $bg_white );                                    

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, 0);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_white );

                $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, 0);
                $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_white );                            
            }
        }

        $cont_alm = 9;
        $cont_des = 8;
        $cont_cen = 10;
        $cont_alo = 7;
        $cont++;
        PHPExcel_Calculation::getInstance($objPHPExcel)->disableCalculationCache();
        for($i = 0; $i < (count($dias_arr) + 1); $i++) {
            $sum1 = '=SUM('.($columns[$cont_alm] . 3) . ':' . ($columns[$cont_alm] . ($cont - 1)) .')';
            $val_sum1 = PHPExcel_Calculation::getInstance($objPHPExcel)->calculateFormula($sum1, NULL,NULL);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm] . $cont, $val_sum1);
            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alm] . $cont)->applyFromArray( $bg_white );
            $cont_alm += 4;            

            $sum2 = '=SUM('.($columns[$cont_alo] . 3) . ':' . ($columns[$cont_alo] . ($cont - 1)) .')';
            $val_sum2 = PHPExcel_Calculation::getInstance($objPHPExcel)->calculateFormula($sum2, NULL,NULL);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alo] . $cont, $val_sum2);
            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_alo] . $cont)->applyFromArray( $bg_white );
            $cont_alo += 4;                                      

            $sum3 = '=SUM('.($columns[$cont_des] . 3) . ':' . ($columns[$cont_des] . ($cont - 1)) .')';
            $val_sum3 = PHPExcel_Calculation::getInstance($objPHPExcel)->calculateFormula($sum3, NULL,NULL);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_des] . $cont, $val_sum3);
            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_des] . $cont)->applyFromArray( $bg_white );
            $cont_des += 4;

            $sum4 = '=SUM('.($columns[$cont_cen] . 3) . ':' . ($columns[$cont_cen] . ($cont - 1)) .')';
            $val_sum4 = PHPExcel_Calculation::getInstance($objPHPExcel)->calculateFormula($sum4, NULL,NULL);
            $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_cen] . $cont, $val_sum4);
            $objPHPExcel->getActiveSheet()->getStyle($columns[$cont_cen] . $cont)->applyFromArray( $bg_white );
            $cont_cen += 4;            
        }
                
        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm - 4] . ($cont + 6), $val_sum2);
        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm - 4] . ($cont + 7), $val_sum3);
        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm - 4] . ($cont + 8), $val_sum1);
        $objPHPExcel->getActiveSheet()->setCellValue($columns[$cont_alm - 4] . ($cont + 9), $val_sum4);
 
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