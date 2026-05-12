<?php

    require_once 'vendor/autoload.php';
    include('mysql.php');
    $css = file_get_contents('style.css');
    $mes = $_GET['mes'];
    $idempleado = $_GET['idTrabajador'];//18;

       $sql = "SELECT RIGHT(LAST_DAY('". $mes ."'),2) dias;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $num_days = $row['dias'];

    $dias_html = '';
    $datos_user_html = '';
    $sql_empleado = '';
    $vertical_sum = array();
    $total_sum = 0;
    for ($i=0; $i < $num_days; $i++) { 
        $vertical_sum[$i] = 0;
    }

    if($idempleado > 0) $sql_empleado = ' AND e.idTrabajador = ' . $idempleado;

    $sql = "SELECT CONCAT(t.nombreTrabajador,' ', t.apellidoTrabajador1) AS name, h.nombreHotel,
    t.labor, e.idTrabajador
    FROM trabajador t INNER JOIN hotel h ON t.idHotel = h.idHotel
    INNER JOIN entradat e ON t.idTrabajador = e.idTrabajador
    WHERE e.fecha BETWEEN DATE_ADD(DATE_ADD(LAST_DAY('". $mes ."'), INTERVAL 1 DAY),INTERVAL -1 MONTH) AND LAST_DAY('". $mes ."') ". $sql_empleado ."
    GROUP BY e.idTrabajador
    ORDER BY e.idTrabajador, e.fecha ASC;";

    $tds = '';
    $con = 1;
    $arr = [];
    $rowflag = false;
    $rowbgcolor = "";

    if( $result = mysqli_query($conn, $sql))
    {   
        while($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $labor = $row['labor'];
            $nombreHotel = $row['nombreHotel'];
            $idTrabajador = $row['idTrabajador'];
            $tds = '';
            $rowbgcolor = ($rowflag)? "":' class="b-gray" ';
            $rowflag = !$rowflag;
            $datos_user_html .= '
                <tr '.$rowbgcolor.'>
                    <td class="t-center">'.$con.'</td> 
                    <td class="t-left">'.$name.'</td>
                    <td class="t-left">'.utf8_decode($labor).'</td>
                    <td class="t-center">'.utf8_decode($nombreHotel).'</td>';

            $sql2 = "SELECT RIGHT(e.fecha,2) * 1 AS fechac, RIGHT(e.fechaEntradaT,2) * 1 AS fechaEntradaT, e.fechaSalida
                        FROM entradat e WHERE e.idTrabajador = ". $idTrabajador ." AND e.fecha BETWEEN DATE_ADD(DATE_ADD(LAST_DAY('". $mes ."'), INTERVAL 1 DAY),INTERVAL -1 MONTH) AND LAST_DAY('". $mes ."') ". $sql_empleado ."
                        ORDER BY e.idTrabajador, e.fecha ASC ;";
            $days_count = 0;          
            $auxiliar_cont = 0;  
            if($result2 = mysqli_query($conn, $sql2))
            {
                $jaux = 1;
                while($row2 = mysqli_fetch_assoc($result2)) {
                    for($j = $jaux; $j <= $num_days; $j++,$jaux++){                    
                        if($row2['fechac'] == $j){                        
                            if(intval($row2['fechaEntradaT']) != 0){
                                $tds .= '<td class="t-center"><img src="img/cheque.png" width="10px"></td>';       
                                $jaux++;    
                                $days_count++;          
                                $vertical_sum[($j-1)] += 1;        
                                break;
                            }
                            else{ 
                                $tds .= '<td class="t-center"></td>';
                                $jaux++;
                                break;
                            }
                        }else{
                            $tds .= '<td class="t-center"></td>';
                        }
                    }
                }
                for($j = $jaux; $j<=$num_days; $j++,$jaux++){                    
                    $tds .= '<td class="t-center"></td>';
                }
            }

            $tds .= '<td class="t-center">'.$days_count.'</td>';
            $total_sum += $days_count;
            $datos_user_html .= $tds . '</tr>';
            $con++;    
        }
    }
    
    $datos_user_html .= '<tr>';
    $datos_user_html .= '<td class="t-center"></td><td class="t-center"></td><td class="t-center"></td><td class="t-center"></td>';
    for ($i=0; $i < $num_days; $i++) { 
        $datos_user_html .= '<td class="t-center">'.$vertical_sum[$i].'</td>';
    }
    $datos_user_html .= '<td class="t-center">'.$total_sum.'</td>';
    $datos_user_html .= '</tr>';

    $new_date = substr($mes, 0, -2); 
    $last_letter = '';
    $dias_name = '';
    for($i=1;$i<=$num_days;$i++) {

        if($i < 10)
            $last_letter = '0' . $i;
        else
            $last_letter = $i;

        $sql = "SELECT CONCAT(ELT(WEEKDAY('". $new_date . $last_letter ."') + 1, 'L', 'M', 'MI', 'J', 'V', 'S', 'D')) AS inicial";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $inicial = $row['inicial'];

        $dias_name .= '<th class="t-center">'.$inicial.'</th>';
        $dias_html .= '<th class="t-center">'.$i.'</th>';
    }
    $dias_name .= '<th class="t-center"></th>';
    $dias_html .= '<th class="t-center">TOTAL</th>';

    $sql = "SELECT CONCAT(ELT(MONTH('". $mes ."'), 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE')) AS MesName;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $MesName = $row['MesName'];

    $contratos = '
    <body>
        <h1>Registro de Entradas/Salidas</h1>
        <h3>ASISTENCIAS DE '. $MesName .'</h3>
        <table cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    '.$dias_name.'
                </tr>
                <tr>
                    <th>#</th>
                    <th>TRABAJADOR</th>
                    <th>LABOR</th>
                    <th>HOTEL</th>
                    '.$dias_html.'
                </tr>
            </thead>
            <tbody>
            '.$datos_user_html.'
            </tbody>
        </table>
    </body>';

    mysqli_close($conn);
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
    $contratos = mb_convert_encoding($contratos, 'UTF-8', 'UTF-8');
    $mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->writeHtml($contratos, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output();


?>