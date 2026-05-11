<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
// Array with names

// get the q parameter from URL
$fecha = date('Y-m-d');
$mañana=date("Y-m-d",strtotime($fecha."+ 1 days")); 

//$con = mysqli_connect('localhost','root','','hoteleria');
require('bd/conexionLocalh3.php');
//$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// lookup all hints from array if $q is different from ""
date_default_timezone_set("America/Santiago");

$hora = date('H:i:s');
$fecha = date('Y-m-d');
$fechamañana = '2024-02-28';

$horaCero = "00:00:00";
$fechaDefecto = "0000-00-00";
$salidaDefecto = "00:00:00";
$horasTrabajadasDefecto = '0';
$horasExtrasDefecto = '0';
$ayer = date("Y-m-d", strtotime($fecha . "- 1 days"));  

// Variables para almacenar mensajes
$mensajes = array();
$mensajesCorreo = "";

/*VERIFICA SI ALGUNO TERMINA SU HOSPEDAJE*/
$ExisteH = mysqli_query($con, "SELECT * FROM hospedaje where hasta = '$fecha' and estado = 'A'");
$rowcount = mysqli_num_rows($ExisteH);
while ($rowExisteH = mysqli_fetch_array($ExisteH)) {
    $idHabitacion = $rowExisteH['idHabitacion'];
    $idHospedaje = $rowExisteH['idHospedaje'];

    $CapacidadH = mysqli_query($con, "SELECT * FROM habitacion where idHabitacion = '$idHabitacion'");
    $rowcount = mysqli_num_rows($CapacidadH);
    while ($row2 = mysqli_fetch_array($CapacidadH)) {
        $idHabitacion = $row2['idHabitacion'];
        $capacidadHabitacion = $row2['capacidadHabitacion'];
        $mas = '1';
        $CapacidadTotal = $capacidadHabitacion + $mas;
        $actualizarCapacidad = mysqli_query($con, "UPDATE habitacion SET capacidadHabitacion = '$CapacidadTotal' WHERE idHabitacion ='$idHabitacion'");
        
        $mensaje = "Registro Actualizado: Habitación $idHabitacion - Capacidad aumentada";
        $mensajes[] = $mensaje;
        echo '<div class="alert alert-success"><strong>Success!</strong> ' . $mensaje . '</div>';
    }
    
    $idHospedaje = $rowExisteH['idHospedaje'];
    $idCama = $rowExisteH['idCama'];
    $estado = 'I';
    $estadoCama = 'A';
    $actualizarEstado = mysqli_query($con, "UPDATE hospedaje SET estado = '$estado' WHERE idHospedaje ='$idHospedaje'");
    $actualizarCama = mysqli_query($con, "UPDATE cama SET estadoCama = '$estadoCama' WHERE idCama ='$idCama'");
    $actualizarDespedida = mysqli_query($con, "UPDATE hospedaje SET fechaDespedida='$fecha' ,horaDespedida='$hora' WHERE idHospedaje ='$idHospedaje'");  
}

/*CREA UN NUEVO RESUMEN DE HOSPEDAJE PARA LOS ACTIVOS CON FECHA DE SALIDA MAYOR A MAÑANA*/
$mañana = date("Y-m-d", strtotime($fecha . "+ 1 days"));
$Existe = mysqli_query($con, "SELECT  
    hospedaje.idHospedaje,
    hospedaje.idPersona,
    hospedaje.idHotel,
    hospedaje.idHabitacion,
    hospedaje.idCama,
    hospedaje.desde,
    hospedaje.hasta,
    hospedaje.estado,
    hospedaje.fechaDespedida,
    hospedaje.horaDespedida,
    hospedaje.tipoHabitacion,

    persona.idPersona,
    persona.nombresPersona,
    persona.apellidoPersona1,
    persona.rutPersona,

    empresa.idEmpresa,
    empresa.nombreEmpresa,
    empresa.horaSalida
    
    FROM hospedaje
    INNER JOIN persona ON hospedaje.idPersona=persona.idPersona
    INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
    where hospedaje.estado = 'A' and hospedaje.hasta > '$mañana' and hospedaje.idHotel = 1");

$registrosInsertados = array();

while ($row1 = mysqli_fetch_array($Existe)) {
    date_default_timezone_set("America/Santiago"); 
    $idHospedaje = $row1['idHospedaje'];
    $hasta = $row1['hasta'];   
    $fecha = date('Y-m-d');  
    $Act = '1';    
    
    $InsertarMañana = mysqli_query($con, "INSERT INTO `resumenhospedaje`(idHospedaje, FechaR, Act) VALUES ('$idHospedaje','$mañana','$Act')");  
    
    if ($InsertarMañana) {
        $nombrePersona = $row1['nombresPersona'];
        $apellidoPersona = $row1['apellidoPersona1'];
        $nombreEmpresa = $row1['nombreEmpresa'];
        $idHabitacion = $row1['idHabitacion'];
        
        $mensaje = "Registro insertado: $nombrePersona $apellidoPersona - Empresa: $nombreEmpresa - Habitación: $idHabitacion";
        $mensajes[] = $mensaje;
        echo '<div class="alert alert-success"><strong>Success!</strong> ' . $mensaje . '</div>';
        
        // Guardar para el correo
        $registrosInsertados[] = array(
            'nombre' => $nombrePersona,
            'apellido' => $apellidoPersona,
            'empresa' => $nombreEmpresa,
            'habitacion' => $idHabitacion
        );
    }
}

/*CREA UN NUEVO RESUMEN DE HOSPEDAJE PARA LOS QUE SE PASARON DE LA HORA DE SALIDA*/
$Existe2 = mysqli_query($con, "SELECT  
    hospedaje.idHospedaje,
    hospedaje.idPersona,
    hospedaje.idHotel,
    hospedaje.idHabitacion,
    hospedaje.idCama,
    hospedaje.desde,
    hospedaje.hasta,
    hospedaje.estado,
    hospedaje.fechaDespedida,
    hospedaje.horaDespedida,
    hospedaje.tipoHabitacion,

    persona.idPersona,
    persona.nombresPersona,
    persona.apellidoPersona1,
    persona.rutPersona,

    empresa.idEmpresa,
    empresa.nombreEmpresa,
    empresa.horaSalida
    
    FROM hospedaje
    INNER JOIN persona ON hospedaje.idPersona=persona.idPersona
    INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
    where hospedaje.estado = 'I' and hospedaje.horaDespedida > empresa.horaSalida and hospedaje.fechaDespedida = '$fecha'");

while ($row2 = mysqli_fetch_array($Existe2)) {
    date_default_timezone_set("America/Santiago"); 
    $idHospedaje2 = $row2['idHospedaje'];
    $hasta = $row2['hasta'];
    $mañana = date("Y-m-d", strtotime($fecha . "+ 1 days"));
    $fecha = date('Y-m-d');  
    $Act = '1';  

    $Insertar = mysqli_query($con, "INSERT INTO `resumenhospedaje`(idHospedaje, FechaR, Act) VALUES ('$idHospedaje2','$fecha','$Act')");
    
    if ($Insertar) {
        $nombrePersona = $row2['nombresPersona'];
        $apellidoPersona = $row2['apellidoPersona1'];
        $nombreEmpresa = $row2['nombreEmpresa'];
        $idHabitacion = $row2['idHabitacion'];
        
        $mensaje = "Registro insertado (hora excedida): $nombrePersona $apellidoPersona - Empresa: $nombreEmpresa - Habitación: $idHabitacion";
        $mensajes[] = $mensaje;
        echo '<div class="alert alert-success"><strong>Success!</strong> ' . $mensaje . '</div>';
        
        // Guardar para el correo
        $registrosInsertados[] = array(
            'nombre' => $nombrePersona,
            'apellido' => $apellidoPersona,
            'empresa' => $nombreEmpresa,
            'habitacion' => $idHabitacion,
            'tipo' => 'hora_excedida'
        );
    }
}

// Preparar mensaje para correo
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

$mañana = date("Y-m-d", strtotime($fecha . "+ 1 days")); 
$subject = "Registro de hospedaje H1 - " . $fecha;

// Construir el cuerpo del correo
$msg = "<html><body>";
$msg .= "<h2>Resumen de Registros de Hospedaje</h2>";
$msg .= "<p>El registro de hospedaje fue procesado el día " . $fecha . " a las " . $hora . "</p>";
$msg .= "<p>Fecha de referencia: " . $mañana . "</p>";

if (count($registrosInsertados) > 0) {
    $msg .= "<h3>Registros Insertados:</h3>";
    $msg .= "<ul>";
    foreach ($registrosInsertados as $registro) {
        $tipo = isset($registro['tipo']) ? " (Hora de salida excedida)" : "";
        $msg .= "<li>" . $registro['nombre'] . " " . $registro['apellido'] . " - Empresa: " . $registro['empresa'] . " - Habitación: " . $registro['habitacion'] . $tipo . "</li>";
    }
    $msg .= "</ul>";
} else {
    $msg .= "<p>No se insertaron nuevos registros hoy.</p>";
}

$msg .= "<h3>Total de operaciones realizadas: " . count($mensajes) . "</h3>";
$msg .= "</body></html>";

$from = "rasp602@gmail.com";

// El from DEBE corresponder a una cuenta de correo real creada en el servidor
$headers = "From: rasp602@gmail.com\r\n"; 
$headers .= "Reply-To: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n"; 

// Mostrar resumen final
echo '<div class="alert alert-info"><strong>Resumen:</strong> Se procesaron ' . count($mensajes) . ' operaciones en total.</div>';
echo '<div class="alert alert-info"><strong>Detalle:</strong><br>' . implode('<br>', $mensajes) . '</div>';

date_default_timezone_set("America/Santiago"); 
echo '<div class="alert alert-warning">Fecha y hora de ejecución: ' . date("l jS \of F Y H:i:s") . '</div>';

// Enviar correo
if (mail($from, $subject, $msg, $headers)) {
    echo '<div class="alert alert-success"><strong>Correo enviado</strong> correctamente a ' . $from . '</div>';
} else {
    $errorMessage = error_get_last()['msg'];
    echo '<div class="alert alert-danger"><strong>Error al enviar correo:</strong> ' . $errorMessage . '</div>';
}

?>