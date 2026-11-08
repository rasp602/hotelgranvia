<?php 
   $mysqli = new mysqli("149.62.37.52", "u410124118_ramadas2023", "Rodri2410$", "u410124118_ventas_php");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    $con=@mysqli_connect('149.62.37.52', 'u410124118_ramadas2023', 'Rodri2410$', 'u410124118_ventas_php');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }  
?>