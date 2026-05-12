<?php 
//$mysqli = new mysqli("190.101.222.6", "hotel", "clave", "hoteleria");
$mysqli = new mysqli("190.162.46.97", "hotel", "clave", "hoteleria");
if ($mysqli->connect_error)
{
	die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

 	# conectare la base de datos
    $con=@mysqli_connect('190.162.46.97', 'hotel', 'clave', 'hoteleria');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }


    $servername = "190.162.46.97";
    $username = "hotel";
    $password = "clave";
    $dbname = "hoteleria";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $servername = "190.162.46.97";
    $username = "hotel";
    $password = "clave";
    $dbname = "hoteleria";
    // Crear conexión


    // Crear conexión
    // Crear conexión


    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die(json_encode(['message' => "Conexión fallida: " . $conn->connect_error]));
    }

    $conn = new mysqli("190.162.46.97", "hotel", "clave", "hoteleria");

    /* Comprobando si hay un error de conexión. */
    if ($conn->connect_error) {
        die('Error de conexion ' . $conn->connect_error);
    }


?>