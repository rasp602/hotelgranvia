<?php 
/*$mysqli = new mysqli("200.74.49.175", "hotel", "chile2023$", "hoteleria");
if ($mysqli->connect_error)
{
	die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

 	# conectare la base de datos
    $con=@mysqli_connect('200.74.49.175', 'hotel', 'chile2023$', 'hoteleria');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

*/

    /*$mysqli = new mysqli("localhost", "u410124118_rasp602", "Rodrigo2410$", "u410124118_hoteleria");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    $con=@mysqli_connect('localhost', 'u410124118_rasp602', 'Rodrigo2410$', 'u410124118_hoteleria');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }*/


/*
        $mysqli = new mysqli("190.161.173.52", "rasph3", "Rodri2410$", "hoteleria");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    $con=@mysqli_connect('190.161.173.52', 'rasph3', 'Rodri2410$', 'hoteleria');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }  */


    
// Configuración de la conexión
$host = "200.74.43.86"; // Dirección del servidor
$user = "rasph3";            // Usuario de la base de datos
$password = "Rodri2410$";       // Contraseña de la base de datos
$database = "hoteleria";   // Nombre de la base de datos

// Crear una conexión usando MySQLi (orientado a objetos)
$con=$mysqli = new mysqli($host, $user, $password, $database);

// Verificar si hay errores en la conexión
if ($mysqli->connect_error) {
    die('ERROR: No se estableció la conexión. ' . $mysqli->connect_error);
}

// Opcional: Configurar el charset (recomendado)
$mysqli->set_charset("utf8");

// Mensaje de éxito (solo para depuración)
//echo "Conexión exitosa a la base de datos.";

// Cerrar la conexión (opcional, dependiendo de tu flujo de trabajo)
// $mysqli->close();
?>
    
