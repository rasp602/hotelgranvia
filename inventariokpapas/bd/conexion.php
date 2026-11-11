<?php 


    $mysqli = new mysqli("10.0.3.1:3306", "kpapas", "chile2023$", "kpapas");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    $con=@mysqli_connect('10.0.3.1:3306', 'kpapas', 'chile2023$', 'kpapas');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    } 

    
?>