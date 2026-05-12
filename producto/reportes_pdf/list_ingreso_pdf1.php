<?php

require_once 'vendor/autoload.php';
include('mysql.php');
$css = file_get_contents('style.css');


/* $nombreTrabajador = $_REQUEST["nombreTrabajador"];
$idHotel = $_REQUEST["idHotel"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1 = Date('3000-01-01');
$fecha = Date('Y-m-d'); */
$fecha = date('Y-m-d');
$nombreTrabajador = "CAROLINA";
$idHotel = 1;
$desde = '2024-03-01';
$hasta = '2024-03-05';
$fecha1 = Date('3000-01-01');

$where = "where trabajador.estado LIKE 'A' and entradat.Fecha BETWEEN '" . $fecha . "' AND '" . $fecha . "'";
if ($nombreTrabajador != "") {
    $where = "where trabajador.estado LIKE 'A' and trabajador.nombreTrabajador LIKE'%" . $nombreTrabajador . "%'";
}
if ($idHotel != "") {
    $where = "where trabajador.estado LIKE 'A' and trabajador.idHotel LIKE'%" . $idHotel . "%'";
}
if ($desde != "" && $hasta == "") {
    $where = "where trabajador.estado LIKE 'A' and entradat.Fecha BETWEEN '" . $desde . "' AND '" . $fecha1 . "'";
}
if ($desde != "" && $hasta != "") {
    $where = "where trabajador.estado LIKE 'A' and entradat.Fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'";
}
if ($nombreTrabajador != "" && $desde != "" && $hasta != "") {
    $where = "where trabajador.estado LIKE 'A' and trabajador.nombreTrabajador LIKE'%" . $nombreTrabajador . "%' and entradat.Fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'";
}
if ($idHotel != "" && $desde != "" && $hasta != "") {
    $where = "where trabajador.estado LIKE 'A' and trabajador.idHotel LIKE'%" . $idHotel . "%' and entradat.Fecha BETWEEN '" . $desde . "' AND '" . $hasta . "'";
}
$query3 = mysqli_query($conn, "SELECT 
        entradat.idEntradaT,
        entradat.Fecha,   
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,
        entradat.validacion,
        trabajador.idTrabajador,
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
        trabajador.fechaCreado,
        trabajador.horaCreado,
        trabajador.fotoTrabajador,
        trabajador.qrTrabajador,
        trabajador.idHotel,
        trabajador.labor,
        trabajador.condicion,
        hotel.idHotel,
        hotel.nombreHotel      
        FROM entradat
        INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
        INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel $where ORDER by hotel.idHotel,trabajador.labor,entradat.Fecha");

$numfilas = mysqli_num_rows($query3);

$rows_table = '';

for ($i = 1; $i <= $numfilas; $i++) {

    $fila = mysqli_fetch_array($query3);

    if ($fila['horaEntrada'] == "00:00:00") {
        $sinEntrada = "-";
        $fila['horaEntrada'] = $sinEntrada;
    }

    if ($fila['horaSalida'] == "00:00:00") {

        $pendiente = "-";
        $fila['horaSalida'] = $pendiente;
    }
    // Suponiendo que $fila['Fecha'] contiene la fecha en formato 'año-mes-día'
    $fecha_original = $fila['Fecha'];

    // Convertir la fecha a formato 'día mes año'
    $fecha_formateada = date('d/m/Y', strtotime($fecha_original));
    $condicion =  "Operativo";

    if ($fila['horaEntrada'] == "-") {
        $sql = "SELECT COALESCE((SELECT tipo_evento FROM eventoscalendar WHERE idTrabajador = ". $fila['idTrabajador'] ." AND '". $fecha_original ."' BETWEEN fecha_inicio AND fecha_fin LIMIT 1),'Descanso') AS condicion ";
        $query4 = mysqli_query($conn, $sql);
        $result4 = mysqli_fetch_array($query4);
        $condicion =  $result4['condicion'];
    }
    
    $rows_table .= '
        <tr>
            <td class="t-center">' . $i . '</td>
            <td class="t-center">' . $fila['nombreTrabajador'] . ' ' . $fila['apellidoTrabajador1'] . '</td>            
            <td class="t-center">' . $fila['labor'] . '</td>
            <td class="t-center">' . $fila['nombreHotel'] . '</td>
            <td class="t-center">' . $fecha_formateada . '</td>
            <td class="t-center">' . $fila['horaEntrada'] . '</td>
            <td class="t-center">' . $fila['horaSalida'] . '</td>
            <td class="t-center">' . $condicion . '</td>
            <td class="t-center">' . $fila['horasTrabajadas'] . '</td>
            <td class="t-center">' . $fila['horasExtras'] . '</td>
        </tr>
    ';
}


$query4 = mysqli_query($conn, "SELECT 
        entradat.idEntradaT,
        entradat.Fecha,
        entradat.idTrabajador,
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,
        entradat.validacion,
        trabajador.idTrabajador,
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
        trabajador.fechaCreado,
        trabajador.horaCreado,
        trabajador.fotoTrabajador,
        trabajador.qrTrabajador,
        trabajador.idHotel,
        trabajador.labor,
        hotel.idHotel,
        hotel.nombreHotel,
            sum(horasExtras) AS Extras,
            sum(horasTrabajadas) AS horasTrabajadasTotal 
        FROM entradat
        INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
        INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel $where");

$numfilas1 = mysqli_num_rows($query4);

$td_total_trab = '';
$td_total_extr = '';

for ($i = 1; $i <= $numfilas1; $i++) {
    $fila = mysqli_fetch_array($query4);
    $td_total_trab .= '<td class="t-center">'. $fila['horasTrabajadasTotal'] .'</td>';
}

$query4 = mysqli_query($conn, "SELECT 
        entradat.idEntradaT,
        entradat.Fecha,
        entradat.idTrabajador,
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,
        entradat.validacion,
        trabajador.idTrabajador,
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
        trabajador.fechaCreado,
        trabajador.horaCreado,
        trabajador.fotoTrabajador,
        trabajador.qrTrabajador,
        trabajador.idHotel,
        trabajador.labor,
        hotel.idHotel,
        hotel.nombreHotel,
            sum(horasExtras) AS Extras,
            sum(horasTrabajadas) AS horasTrabajadasTotal 
        FROM entradat
        INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
        INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel $where  and entradat.validacion='0' ");



$numfilas1 = mysqli_num_rows($query4);

for ($i = 1; $i <= $numfilas1; $i++) {
    $fila = mysqli_fetch_array($query4);
    $td_total_extr .= '<td class="t-center">'. $fila['Extras'] .'</td>';
}

$contratos = '
    <body>
        <div style="text-align: left; position: absolute; margin-top: -50px;">
            <img src="img/logo.png" style="width: 100px; height: auto; ">
        </div>    
        <h3 style="text-align: center">Registro de Entradas/Salidas</h3>
        <p style="text-align: right;">2023-03-03</p>
        <table cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TRABAJADOR</th>
                    <th>LABOR</th>
                    <th>HOTEL</th>
                    <th>FECHA</th>
                    <th>HORA ENTRADA</th>
                    <th>HORA SALIDA</th>
                    <th>CONDICIÓN</th>
                    <th>H. TRABAJADAS</th>
                    <th>H. EXTRAS</th>
                </tr>
            </thead>
            <tbody>
                ' . $rows_table . '
            </tbody>
        </table>     
        <br><br>
        <table style="width: 45%;" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>TOTAL HORAS TRABAJADAS</th>
                    <th>TOTAL HORAS EXTRAS</th>                
                </tr>
            </thead>
            <tbody>
                <tr>
                    '. $td_total_trab .'
                    '. $td_total_extr .'                 
                </tr>               
            </tbody>
        </table>   
    </body>';
    

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

$mpdf->Image('img/logo.png', 0, 0, 210, 297, 'png', '', true, false);
$contratos = mb_convert_encoding($contratos, 'UTF-8', 'UTF-8');
$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->writeHtml($contratos, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();


?>