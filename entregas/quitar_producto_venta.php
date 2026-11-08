<?php
session_start();
$id = $_GET['idProducto'];
$productos = $_SESSION['lista'];

foreach ($productos as $key => $producto) {
	if($producto->idProducto == $id){
		unset($productos[$key]);
	}
}

$_SESSION['lista'] = $productos;
header("location: vender.php");
?>