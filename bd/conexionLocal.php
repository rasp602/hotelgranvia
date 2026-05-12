<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$port = 3306;
$user = "root";
$pass = "Rodrigo2410$";
$db   = "hoteleria";

/* Conexión principal mysqli */
$con = new mysqli($host, $user, $pass, $db, $port);

if ($con->connect_error) {
    die("Error de conexión BD: " . $con->connect_error);
}

$con->set_charset("utf8");

/* Alias para códigos antiguos */
$conn = $con;
$mysqli = $con;

?>