<?php
session_start();
$id = $_GET['idProductoPreparado'];
$productos = $_SESSION['lista'];

foreach ($productos as $key => $producto) {
	if($producto->idProductoPreparado == $id){
		unset($productos[$key]);
	}
}

$_SESSION['lista'] = $productos;
header("location: venderPreparado.php");
?>