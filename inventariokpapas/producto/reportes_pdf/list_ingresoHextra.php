<?php

require_once 'vendor/autoload.php';
include('mysql.php');
$css = file_get_contents('style.css');


$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$idHotel = $_REQUEST["idHotel"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1 = Date('3000-01-01');
$fecha = Date('Y-m-d');

$color_licencia = '#0033ff';
$color_descanso = '#ff0026';
/* $fecha = date('Y-m-d');
$nombreTrabajador = "";
$idHotel = 3;
$desde = '2024-02-01';
$hasta = '2024-02-27';
$fecha1 = Date('3000-01-01'); */

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
     
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
         trabajador.estado,

        trabajador.idHotel,
        trabajador.labor,
       
        trabajador.jornada,
   
        hotel.nombreHotel,
            sum(horasExtras) AS Extras,
            sum(horasTrabajadas) AS horasTrabajadasTotal    
        FROM entradat
        INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
        INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel  $where    GROUP by hotel.idHotel,trabajador.idTrabajador ");

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

    $color_condicion = "#000";
    $color_vacaciones = '#0d00ff';
    $sql = "SELECT COALESCE((SELECT tipo_evento FROM eventoscalendar WHERE idTrabajador = ". $fila['idTrabajador'] ." AND '". $fecha_original ."' BETWEEN fecha_inicio AND fecha_fin LIMIT 1),'Operativo') AS condicion ";
    
    
    $query4 = mysqli_query($conn, $sql);
    $result4 = mysqli_fetch_array($query4);
    $condicion =  $result4['condicion'];

    if ($fila['horaEntrada'] == "-") {

        if($condicion == 'Descanso'){
            $color_condicion = $color_descanso;
        }
        if($condicion == 'Licencia'){
            $color_condicion = $color_licencia;
        }
        if ($condicion == 'Vacaciones') {
            $color_condicion = $color_vacaciones;
        }
        if ($condicion == "") {
                                           
            echo "";

        }  

    }


     if ($fila['jornada'] == "1"):
        $jornada = "8:00-16:00";
     endif;
     if ($fila['jornada'] == "2"):
         $jornada = "8:00-17:00" ;
     endif ;
     if ($fila['jornada'] == "3"):
         $jornada = "14:00-22:00" ;
     endif ;
     if ($fila['jornada'] == "4"):
         $jornada = "00:00-8:00" ;
     endif ;
     if ($fila['jornada'] == "5"):
         $jornada = "15:00-23:00" ;
     endif ;
     if ($fila['jornada'] == "6"):
         $jornada = "8:00-18:00" ;
     endif ;
     if ($fila['jornada'] == "7"):
         $jornada = "8:00-22:00" ;
     endif ;
     if ($fila['jornada'] == "8"):
         $jornada = "22:00-08:00" ;
     endif ;
     if ($fila['jornada'] == "9"):
         $jornada = "06:00-18:00" ;
     endif ;
     if ($fila['jornada'] == "10"):
         $jornada = "7x7" ;
     endif ;
     if ($fila['jornada'] == "11"):
         $jornada = "2:00-10:00" ;
     endif ;
     if ($fila['jornada'] == "12"):
         $jornada = "08:00-20:00" ;
     endif ;
     if ($fila['jornada'] == "13"):
         $jornada = "10:00-22:00" ;
     endif ;
     if ($fila['jornada'] == "14"):
         $jornada = "16:00-1:00" ;
     endif ;
     if ($fila['jornada'] == "15"):
         $jornada = "17:00-2:00" ;
     endif ;
     if ($fila['jornada'] == "16"):
         $jornada = "15:00-1:00" ;
     endif ;
     if ($fila['jornada'] == "17"):
         $jornada = "10:00-2:00 (L)" ;
     endif ;
    
    $rows_table .= '
        <tr>
            <td class="t-center">' . $i . '</td>
            <td class="t-center">' . $fila['nombreTrabajador'] . ' ' . $fila['apellidoTrabajador1'] . '</td>            
            <td class="t-center">' . $fila['labor'] . '</td>
            <td class="t-center">' . $fila['nombreHotel'] . '</td>
  
            <td class="t-center">' . $jornada. '</td>

            <td class="t-center">' . $fila['horasTrabajadasTotal'] . '</td>
            <td class="t-center">' . $fila['Extras'] . '</td>
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

$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= '$idHotel'  AND trabajador.estado = 'A'");



$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadores .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabajadores1 .= $fila2['trabajadores'];
}
////////////////////TRABAJADORES H1////////////////////
$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= 1  AND trabajador.estado = 'A'");

$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadoresH1 .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabaH1 .= $fila2['trabajadores'];
}
////////////////////////////////////////////////////////////
//////////////////////TRABAJADORES  H2//////////////////////////////////////
$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= 2  AND trabajador.estado = 'A'");

$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadoresH2 .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabaH2.= $fila2['trabajadores'];
}
////////////////////////////////////////////////////////////
//////////////////////TRABAJADORES  H3//////////////////////////////////////
$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= 3  AND trabajador.estado = 'A'");

$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadoresH3 .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabaH3.= $fila2['trabajadores'];
}
////////////////////////////////////////////////////////////
//////////////////////TRABAJADORES  H4//////////////////////////////////////
$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= 4 AND trabajador.estado = 'A'");

$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadoresH4 .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabaH4.= $fila2['trabajadores'];
}

////////////////////////////////////////////////////////////
//////////////////////TRABAJADORES  H5//////////////////////////////////////
$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= 5 AND trabajador.estado = 'A'");

$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadoresH5 .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabaH5.= $fila2['trabajadores'];
}
////////////////////////////////////////////////////////////
//////////////////////TRABAJADORES  H6//////////////////////////////////////
$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= 6 AND trabajador.estado = 'A'");

$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadoresH6 .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabaH6.= $fila2['trabajadores'];
}
////////////////////////////////////////////////////////////
//////////////////////TRABAJADORES  H7//////////////////////////////////////
$query5 = mysqli_query($conn, "SELECT 

trabajador.idTrabajador,
trabajador.idHotel,
hotel.idHotel,
hotel.nombreHotel,
COUNT(trabajador.idTrabajador) as trabajadores
FROM trabajador
INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
where  hotel.idHotel= 7 AND trabajador.estado = 'A'");

$numfilas2 = mysqli_num_rows($query5);

for ($i = 1; $i <= $numfilas2; $i++) {
    $fila2 = mysqli_fetch_array($query5);
    $trabajadoresH7 .= '<td class="t-center">'. $fila2['trabajadores'] .'</td>';
    $trabaH7.= $fila2['trabajadores'];
}
////////////////////////////////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = $idHotel and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansos .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descansos1 .=$fila4['descansos'];

    if($idHotel == "1")
        {
            $hotel .= '<td class="t-center">H1</td>';  
        }
    if($idHotel == "2")
        {
            $hotel .= '<td class="t-center">H2</td>';  
        }
    if($idHotel == "3")
        {
            $hotel .= '<td class="t-center">H3</td>';  
        }
    if($idHotel == "4")
        {
            $hotel .= '<td class="t-center">H4</td>';  
        }
    if($idHotel == "5")
        {
            $hotel .= '<td class="t-center">H5</td>';  
        }
    if($idHotel == "6")
        {
            $hotel .= '<td class="t-center">H6</td>';  
        }
    if($idHotel == "7")
        {
            $hotel .= '<td class="t-center">H7</td>';  
        }
}

////////////////////// DESCANSOS H1 ///////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 1 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansosH1 .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descaH1 .=$fila4['descansos'];
}
//////////////////////////////////////////////////////////////////////////////////
////////////////////// DESCANSOS H2 ///////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 2 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansosH2 .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descaH2 .=$fila4['descansos'];
}
//////////////////////////////////////////////////////////////////////////////////

////////////////////// DESCANSOS H3 ///////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 3 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansosH3 .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descaH3 .=$fila4['descansos'];
}
//////////////////////////////////////////////////////////////////////////////////
////////////////////// DESCANSOS H4 ///////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 4 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansosH4 .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descaH4 .=$fila4['descansos'];
}
//////////////////////////////////////////////////////////////////////////////////
////////////////////// DESCANSOS H5 ///////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 5 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansosH5 .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descaH5 .=$fila4['descansos'];
}
//////////////////////////////////////////////////////////////////////////////////

////////////////////// DESCANSOS H6 ///////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 6 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansosH6 .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descaH6 .=$fila4['descansos'];
}
//////////////////////////////////////////////////////////////////////////////////

////////////////////// DESCANSOS H7 ///////////////////////////////////
$query7 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS descansos
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 7 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Descanso'");
$numfilas4 = mysqli_num_rows($query7);

for ($i = 1; $i <= $numfilas4; $i++) {
    $fila4 = mysqli_fetch_array($query7);
    $descansosH7 .= '<td class="t-center">'. $fila4['descansos'] .'</td>';
    $descaH7 .=$fila4['descansos'];
}
//////////////////////////////////////////////////////////////////////////////////

$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = $idHotel and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licencias .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licencias1 .=$fila5['licencias'];
}


///////////////////////////Licencias H1////////////////////////////
$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 1 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licenciasH1 .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licenH1 .=$fila5['licencias'];
}
///////////////////////////////////////////////////////////////////////////

///////////////////////////Licencias H2////////////////////////////
$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 2 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licenciasH2 .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licenH2 .=$fila5['licencias'];
}
///////////////////////////////////////////////////////////////////////////

///////////////////////////Licencias H3////////////////////////////
$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 3 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licenciasH3 .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licenH3 .=$fila5['licencias'];
}
///////////////////////////////////////////////////////////////////////////

///////////////////////////Licencias H4////////////////////////////
$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 4 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licenciasH4 .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licenH4 .=$fila5['licencias'];
}
///////////////////////////////////////////////////////////////////////////

///////////////////////////Licencias H5////////////////////////////
$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 5 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licenciasH5 .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licenH5 .=$fila5['licencias'];
}
///////////////////////////////////////////////////////////////////////////
///////////////////////////Licencias H6////////////////////////////
$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 6 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licenciasH6 .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licenH6 .=$fila5['licencias'];
}
///////////////////////////////////////////////////////////////////////////

///////////////////////////Licencias H7////////////////////////////
$query9 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS licencias
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 7 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Licencia'");
$numfilas5 = mysqli_num_rows($query9);

for ($i = 1; $i <= $numfilas5; $i++) {
    $fila5 = mysqli_fetch_array($query9);
    $licenciasH7 .= '<td class="t-center">'. $fila5['licencias'] .'</td>';
    $licenH7 .=$fila5['licencias'];
}
///////////////////////////////////////////////////////////////////////////
$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = $idHotel and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacaciones .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaciones1 .=$fila7['Vacaciones'];
}
///////////////////////VACACIONES H1////////////////////////

$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 1 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacacionesH1 .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaH1 .=$fila7['Vacaciones'];
}

////////////////////////////////////////////////////////////////


///////////////////////VACACIONES H2////////////////////////

$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 2 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacacionesH2 .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaH2 .=$fila7['Vacaciones'];
}

////////////////////////////////////////////////////////////////

///////////////////////VACACIONES H3////////////////////////

$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 3 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacacionesH3 .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaH3 .=$fila7['Vacaciones'];
}

////////////////////////////////////////////////////////////////


///////////////////////VACACIONES H4////////////////////////

$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 4 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacacionesH4 .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaH4 .=$fila7['Vacaciones'];
}

////////////////////////////////////////////////////////////////

///////////////////////VACACIONES H5////////////////////////

$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 5 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacacionesH5 .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaH5 .=$fila7['Vacaciones'];
}

////////////////////////////////////////////////////////////////

///////////////////////VACACIONES H6////////////////////////

$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 6 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacacionesH6 .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaH6 .=$fila7['Vacaciones'];
}

////////////////////////////////////////////////////////////////

///////////////////////VACACIONES H7////////////////////////

$query11 = mysqli_query($conn, "SELECT 
trabajador.idTrabajador,
trabajador.nombreTrabajador,
trabajador.apellidoTrabajador1,
trabajador.idHotel,
eventoscalendar.tipo_evento,
eventoscalendar.idTrabajador,
eventoscalendar.fecha_inicio,
eventoscalendar.fecha_fin,
COUNT(eventoscalendar.idTrabajador) AS Vacaciones
FROM eventoscalendar 
INNER JOIN trabajador ON eventoscalendar.idTrabajador =trabajador.idTrabajador
where trabajador.idHotel = 7 and '$fecha_original' BETWEEN eventoscalendar.fecha_inicio AND eventoscalendar.fecha_fin and eventoscalendar.tipo_evento = 'Vacaciones'");
$numfilas7 = mysqli_num_rows($query11);

for ($i = 1; $i <= $numfilas7; $i++) {
    $fila7 = mysqli_fetch_array($query11);
    $vacacionesH7 .= '<td class="t-center">'. $fila7['Vacaciones'] .'</td>';
    $vacaH7 .=$fila7['Vacaciones'];
}

////////////////////////////////////////////////////////////////
// Definimos dos variables


$operativos = $trabajadores1-$descansos1-$vacaciones1-$licencias1 ;

$operativosH1 = $trabaH1-$descaH1-$vacaH1-$licenH1 ;
$operativosH2 = $trabaH2-$descaH2-$vacaH2-$licenH2 ;
$operativosH3 = $trabaH3-$descaH3-$vacaH3-$licenH3 ;
$operativosH4 = $trabaH4-$descaH4-$vacaH4-$licenH4 ;
$operativosH5 = $trabaH5-$descaH5-$vacaH5-$licenH5 ;
$operativosH6 = $trabaH6-$descaH6-$vacaH6-$licenH6 ;
$operativosH7 = $trabaH7-$descaH7-$vacaH7-$licenH7 ;

$totalOperativos = $operativosH1+$operativosH2+$operativosH3+$operativosH4+$operativosH5+$operativosH6+$operativosH7;
$totalTrabajadores = $trabaH1+$trabaH2+$trabaH3+$trabaH4+$trabaH5+$trabaH6+$trabaH7;
$totalDescansos = $descaH1+$descaH2+$descaH3+$descaH4+$descaH5+$descaH6+$descaH7;
$totalVacaciones = $vacaH1+$vacaH2+$vacaH3+$vacaH4+$vacaH5+$vacaH6+$vacaH7;
$totalLicencias = $licenH1+$licenH2+$licenH3+$licenH4+$licenH5+$licenH6+$licenH7;

if ($idHotel != "" )
{
$contratos = '
    <body>
        <div style="text-align: left; position: absolute; margin-top: -50px;">
            <img src="img/logo.png" style="width: 100px; height: auto; ">
        </div>    
        <h3 style="text-align: center">Registro de Entradas/Salidas</h3>
        <p style="text-align: right;">Desde : '.$desde .'Hoy: '. date("d-m-Y") .'</p>
        <table cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TRABAJADOR</th>
                    <th>LABOR</th>
                    <th>HOTEL</th>
                 
                    <th>JORNADA</th>
      
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
        <br><br>
        <table style="width: 45%;" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
            <th>HOTEL</th>
            <th>TOTAL DE TRABAJADORES</th>
                <th>TRABAJADORES OPERATIVOS</th>
                <th>TRABAJADORES CON DESCANSO</th>
                <th>TRABAJADORES CON LICENCIA</th>  
                <th>TRABAJADORES CON VACACIONES</th>                
            </tr>
        </thead>
        <tbody>
            <tr>
            '. $hotel .'
            '. $trabajadores  .'  
            <td class="t-center">'. $operativos  .'</td> 
                '. $descansos .'
                '. $licencias .'
                '. $vacaciones .'                 
            </tr>               
        </tbody>
    </table> 

    <br>
';
 
}
if ($idHotel == "" )
{
$contratos = '
    <body>
        <div style="text-align: left; position: absolute; margin-top: -50px;">
            <img src="img/logo.png" style="width: 100px; height: auto; ">
        </div>    
        <h3 style="text-align: center">Registro de Entradas/Salidas</h3>
                <p style="text-align: right;">Rango de fechas Desde : '.$desde .' Hasta : '.$hasta.'</p>
            <p style="text-align: right;">Hoy: '. date("d-m-Y") .'</p>
        <table cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TRABAJADOR</th>
                    <th>LABOR</th>
                    <th>HOTEL</th>
                 
                    <th>JORNADA</th>
                     <th>H. TRABAJADAS</th>
                    <th>H. EXTRAS</th>
                </tr>
            </thead>
            <tbody>
                ' . $rows_table . '
            </tbody>
        </table>     
        <br>
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
        <br>
        <table style="width: 45%;" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th>HOTEL</th>
                <th>TOTAL DE TRABAJADORES</th>
                <th>TRABAJADORES OPERATIVOS</th>
                <th>TRABAJADORES CON DESCANSO</th>
                <th>TRABAJADORES CON LICENCIA</th>  
                <th>TRABAJADORES CON VACACIONES</th>                
            </tr>
        </thead>
        <tbody>
            <tr>
           <td class="t-center">H1</td>
            <td class="t-center">'. $trabaH1  .'</td> 
            <td class="t-center">'.$operativosH1.'</td> 
                '. $descansosH1 .'
                '. $licenciasH1 .'
                '. $vacacionesH1 .'                 
            </tr>   
            <tr>
           <td class="t-center">H2</td>
            <td class="t-center">'. $trabaH2  .'</td> 
            <td class="t-center">'.$operativosH2.'</td>
                '. $descansosH2 .'
                '. $licenciasH2 .'
                '. $vacacionesH2 .'                 
            </tr> 
            <tr>
           <td class="t-center">H3</td>
            <td class="t-center">'. $trabaH3  .'</td> 
            <td class="t-center">'.$operativosH3.'</td>
                '. $descansosH3 .'
                '. $licenciasH3 .'
                '. $vacacionesH3 .'                 
            </tr> 
            <tr>
           <td class="t-center">H4</td>
            <td class="t-center">'. $trabaH4  .'</td> 
            <td class="t-center">'.$operativosH4.'</td>
                '. $descansosH4 .'
                '. $licenciasH4 .'
                '. $vacacionesH4.'                 
            </tr> 
            <tr>
            <td class="t-center">H5</td>
            <td class="t-center">'. $trabaH5  .'</td> 
            <td class="t-center">'.$operativosH5.'</td>
                '. $descansosH5 .'
                '. $licenciasH5.'
                '. $vacacionesH5 .'                 
            </tr> 
            
            
            <tr>
            <tr>
            <td class="t-center">H6</td>
            <td class="t-center">'. $trabaH6  .'</td> 
            <td class="t-center">'.$operativosH6.'</td>
                '. $descansosH6 .'
                '. $licenciasH6.'
                '. $vacacionesH6 .'                 
            </tr> 
            <tr>
            <tr>
            <td class="t-center">H7</td>
            <td class="t-center">'. $trabaH7  .'</td> 
            <td class="t-center">'.$operativosH7.'</td>
                '. $descansosH7 .'
                '. $licenciasH7.'
                '. $vacacionesH7 .'                 
            </tr> 
            <tr>
            <td class="t-center">TOTAL</td>
            <td class="t-center">'. $totalTrabajadores  .'</td> 
            <td class="t-center">'. $totalOperativos  .'</td> 
            <td class="t-center">'. $totalDescansos  .'</td> 
            <td class="t-center">'. $totalLicencias  .'</td> 
            <td class="t-center"></td>                  
            </tr> 
            
            
        </tbody>
    </table> 

    <br>
';
 
}

'</body>';

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);

$mpdf->Image('img/logo.png', 0, 0, 210, 297, 'png', '', true, false);
$contratos = mb_convert_encoding($contratos, 'UTF-8', 'UTF-8');
$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->writeHtml($contratos, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();


?>