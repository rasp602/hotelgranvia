<?php
/*
* Script: Conexión a base de datos de MySQL con PHP
* Autor: Marco Robles
* Team: Códigos de Programación
*/


/* Creando una nueva conexión a la base de datos. */
//$conn = new mysqli("190.101.222.6", "hotel", "chile2023$", "hoteleria");
$conn = new mysqli("31.97.87.58:3306", "root", "Rodrigo2410$", "hoteleria");

/* Comprobando si hay un error de conexión. */
if ($conn->connect_error) {
    die('Error de conexion ' . $conn->connect_error);
}
