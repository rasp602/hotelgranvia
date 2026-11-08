<?php
session_start();
$_SESSION['clienteVenta'] = "";
header("location: venderPreparado.php");
?>