<?php

session_start();
$operador = null;
if (isset($_SESSION["usuarioInventario"])) {
    $operador = $_SESSION["usuarioInventario"];
} else {
    header("Location: index.php");
}
?>


<?php
            //Aqui va el menu principal segun el tipo de usuario. 
            include 'Menu_admin.php';
?>   
