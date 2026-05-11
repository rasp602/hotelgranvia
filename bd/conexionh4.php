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



        $mysqli = new mysqli("190.44.59.220", "rasph4", "Rodri2410$", "hoteleria");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    $con4=@mysqli_connect('190.44.59.220', 'rasph4', 'Rodri2410$', 'hoteleria');

    if(!$con4){
        die("imposible conectar1: ".mysqli_error($con4));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }  
?>