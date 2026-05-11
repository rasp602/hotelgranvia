<?php
$usuario  = "u410124118_rasp602";
$password = "Rodrigo2410$";
$servidor = "localhost";
$basededatos = "u410124118_hoteleria";
$con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
$db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");
?>

