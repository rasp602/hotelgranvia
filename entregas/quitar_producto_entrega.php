<?php
include_once "funciones.php";
session_start();

if (empty($_SESSION['usuario'])) {
    exit;
}

if (!isset($_SESSION['lista'])) {
    $_SESSION['lista'] = [];
}

if (!isset($_POST['productoId'], $_POST['nuevaCantidad'])) {
    exit;
}

$productoId = intval($_POST['productoId']);
$nuevaCantidad = intval($_POST['nuevaCantidad']);

if ($nuevaCantidad < 1) {
    $nuevaCantidad = 1;
}

$productoBD = obtenerProductoPorId($productoId);
if (!$productoBD) {
    exit;
}

$stockMaximo = (int)$productoBD->existenciaProducto;

if ($nuevaCantidad > $stockMaximo) {
    $nuevaCantidad = $stockMaximo;
}

foreach ($_SESSION['lista'] as &$producto) {
    if ((int)$producto->idProducto === $productoId) {
        $producto->cantidad = $nuevaCantidad;
        break;
    }
}
unset($producto);

echo "ok";