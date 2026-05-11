<?php
session_start();
$_SESSION['clienteVenta'] = "";
header("location: g_orden.php");
?>