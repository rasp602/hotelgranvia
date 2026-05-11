<?php
session_start();
$cliente = $_POST['idCliente'];
$_SESSION['clienteVenta'] = $cliente;
header("location: g_orden.php");
?>