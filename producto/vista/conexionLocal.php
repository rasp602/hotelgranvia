<?php 
   $mysqli = new mysqli("190.101.222.6", "hotel", "chile2023$", "hoteleria");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    $con=@mysqli_connect('190.101.222.6', 'hotel', 'chile2023$', 'hoteleria');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }  
?>