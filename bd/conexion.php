<?php /*
$mysqli = new mysqli("190.101.222.6", "root", "", "hoteleria");
if ($mysqli->connect_error)
{
	die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

 	# conectare la base de datos
    $con=@mysqli_connect('localhost', 'root', '', 'hoteleria');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    } */

/*
$mysqli = new mysqli("200.74.49.175", "hotel", "chile2023$", "hoteleria");
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


    //$mysqli = new mysqli("190.101.222.6", "hotel", "chile2023$", "hoteleria");
    $mysqli = new mysqli("193.203.175.238", "u854084565_rasp602", "Rodri2410$", "u854084565_hoteleria");
    //$mysqli = new mysqli("152.172.39.88", "hotel", "chile2023$", "hoteleria");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    //$con=@mysqli_connect('152.172.39.88', 'hotel', 'chile2023$', 'hoteleria');
    $con=@mysqli_connect('193.203.175.238', 'u854084565_rasp602', 'Rodri2410$', 'u854084565_hoteleria');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    } 

    
?>