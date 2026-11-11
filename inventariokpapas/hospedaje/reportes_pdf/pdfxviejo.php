<?php
include('../../bd/mysql.php');

$dia_ini = $_GET['dia_ini'];
$dia_fin = $_GET['dia_fin'];
$idEmpresa = $_GET['idEmpresa'];

$iva = 0.19;

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

for($i=0;$i<=$num_days;$i++) {
    $sql = "SELECT DATE_ADD('". $dia_ini ."', INTERVAL $i DAY) AS new_day;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $inicial = $row['new_day'];
    $dias_arr [] = $inicial;

    $dias_name .= '<td style="text-rotate: 90; padding: 3px" class="fecha" rowspan="2">'. $inicial .'</td>';
}

$suma_vertical = [];
for ($i=0; $i < count($dias_arr); $i++) { 
    $suma_vertical[$i] = 0;
}

$header = '
<tr>
    <td colspan="6" ></td>
    '. $dias_name .'
    <td class="bg-yellow" colspan="3" align="center" >'. $fecha_label .'</td>                
</tr>
<tr >
    <th>TURNO</th>
    <th class="bg-gray">APELLIDO PATERNO</th>
    <th class="bg-gray">APELLIDO MATERNO</th>
    <th class="bg-gray">NOMBRES</th>
    <th class="bg-gray">RUT</th>
    <th class="bg-gray">HAB</th>

    <th class="bg-gray">D. OCUP</th>
    <th class="bg-gray">V. OCUP</th>
    <th class="bg-gray">T. OCUP.</th>                 
</tr>            
';

$sql = '
    SELECT ho.idHospedaje, h.nombreHotel, p.apellidoPersona1, p.apellidoPersona2, p.nombresPersona,
    p.rutPersona, ha.nHabitacion, ho.idPersona, ho.tipoHabitacion FROM hospedaje ho
    INNER JOIN persona p ON ho.idPersona = p.idPersona
    INNER JOIN hotel h ON ho.idHotel = h.idHotel
    INNER JOIN habitacion ha ON ho.idHabitacion = ha.idHabitacion
    WHERE p.idEmpresa = '. $idEmpresa .'
    ORDER BY ho.idPersona group by hospedaje.idHospedaje
';

$fechas_aux = [];

$count = 0;
$count_total = 0;
$ContratoEmpresa = 28000;
$neto = 0;
if($result = mysqli_query($conn, $sql))
{  
    while($row = mysqli_fetch_assoc($result)) 
    {
        $body .= '
        <tr class="t-center">
            <td class="bg-blue">'. $row['nombreHotel'] .'</td>
            <td>'. $row['apellidoPersona1'] .'</td>
            <td>'. $row['apellidoPersona2'] .'</td>
            <td>'. $row['nombresPersona'] .'</td>
            <td>'. $row['rutPersona'] .'</td>
            <td>'. $row['nHabitacion'] .'</td>';
        $tds = '';
        $fechas_aux = [];
        $count = 0;
        if($row['tipoHabitacion'] == 'D')
            $ContratoEmpresa = 56000;
        else if($row['tipoHabitacion'] == 'S')
            $ContratoEmpresa = 28000;

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
                    $count++;
                    $suma_vertical[$i] += 1;
                }else{
                    $tds .= '<td class="bg-red fecha"></td>';
    
                } 
            }
        }
        $count_total += $count;
     
        

        $body .= '
        '. $tds .'
        <td>'. $count .'</td>
        <td>$ '.number_format($ContratoEmpresa) .'</td>
        <td>$ '.number_format((intval($ContratoEmpresa) * intval($count))) .'</td>
        </tr>
        ';
        $neto += $ContratoEmpresa;
    }        
}



$html_totales = '';

for ($i=0; $i < count($dias_arr); $i++) { 
    $html_totales .='
        <td>'. $suma_vertical[$i] .'</td>
    ';    
}

$html_totales .='
<td>'. $count_total .'</td>
';

$col_comp = count($dias_arr) + 9;

$precio_iva = $neto * $iva;


$reporte = '
<body>
    <div class="logo">        
        <h1>'. $nombreEmpresa .'</h1>
    </div>
    <h3>HOTEL GRAN VIA  ESTADO DE PAGO</h3>        
        <table cellspacing="0" cellpadding="0">
        <thead>
        '. $header .'
        </thead>
        <tbody>
        '. $body .'   
            <tr>
                <td colspan="6"></td>
                '. $html_totales .'
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="'. $col_comp .'"></td>
            </tr>
            
            <tr>
                <td class="borderless" colspan="'. ($col_comp - 2) .'"></td>
                <td>Neto</td>
                <td>$ '. number_format($neto) .'</td>
            </tr>
            <tr>
                <td class="borderless" colspan="'. ($col_comp - 2) .'"></td>
                <td>IVA</td>
                <td>$ '. number_format($precio_iva) .'</td>
                
            </tr>
            <tr>
                <td class="borderless" colspan="'. ($col_comp - 2) .'"></td>
                <td>Total</td>
                <td>$ '. number_format($neto +
                
                
                $precio_iva) .'</td>                
            </tr>
        </tbody>
        
    </table>
</body>
';


require_once 'vendor/autoload.php';
$css = file_get_contents('stylex.css');
mysqli_close($conn);
$reporte = mb_convert_encoding($reporte, 'UTF-8', 'UTF-8');
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->writeHtml($reporte, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();

?>