<?php
session_start();
include_once "funciones.php";
require('bd/conexionLocal.php');

if (!isset($_SESSION['lista']) || !is_array($_SESSION['lista'])) {
    $_SESSION['lista'] = [];
}

if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
    $_SESSION['mensaje_preparado'] = [
        'tipo' => 'warning',
        'texto' => 'Debe seleccionar un producto.'
    ];
    header("Location: venderPreparado.php#bloque-productos");
    exit;
}

$idProductoPreparado = (int) $_POST['codigo'];

/*
    Busca el producto en BD.
    Ajusta el nombre de la tabla/campos si en tu sistema no se llama exactamente así.
*/
$sql = "SELECT * FROM producto_prepa WHERE idProductoPreparado = ?";
$stmt = $con->prepare($sql);

if (!$stmt) {
    $_SESSION['mensaje_preparado'] = [
        'tipo' => 'danger',
        'texto' => 'Error al preparar la consulta del producto.'
    ];
    header("Location: venderPreparado.php#bloque-productos");
    exit;
}

$stmt->bind_param("i", $idProductoPreparado);

if (!$stmt->execute()) {
    $_SESSION['mensaje_preparado'] = [
        'tipo' => 'danger',
        'texto' => 'Error al consultar el producto.'
    ];
    header("Location: venderPreparado.php#bloque-productos");
    exit;
}

$resultado = $stmt->get_result();

if ($resultado->num_rows <= 0) {
    $_SESSION['mensaje_preparado'] = [
        'tipo' => 'warning',
        'texto' => 'El producto no fue encontrado.'
    ];
    header("Location: venderPreparado.php#bloque-productos");
    exit;
}

$producto = $resultado->fetch_object();

/*
    Si no trae cantidad, la inicializamos
*/
if (!isset($producto->cantidad)) {
    $producto->cantidad = 1;
}

$existencia = isset($producto->existenciaProducto) ? (int)$producto->existenciaProducto : 0;

if ($existencia <= 0) {
    $_SESSION['mensaje_preparado'] = [
        'tipo' => 'warning',
        'texto' => 'No hay stock disponible para este producto.'
    ];
    header("Location: venderPreparado.php#bloque-productos");
    exit;
}

/*
    Revisar si ya existe en la lista
*/
$encontrado = false;

foreach ($_SESSION['lista'] as $indice => $item) {
    if ((int)$item->idProductoPreparado === (int)$producto->idProductoPreparado) {
        $cantidadActual = isset($_SESSION['lista'][$indice]->cantidad)
            ? (int)$_SESSION['lista'][$indice]->cantidad
            : 1;

        if ($cantidadActual < $existencia) {
            $_SESSION['lista'][$indice]->cantidad = $cantidadActual + 1;

            $_SESSION['mensaje_preparado'] = [
                'tipo' => 'success',
                'texto' => 'Producto agregado, se aumentó la cantidad.'
            ];
        } else {
            $_SESSION['mensaje_preparado'] = [
                'tipo' => 'warning',
                'texto' => 'Ya alcanzaste el stock disponible de este producto.'
            ];
        }

        $encontrado = true;
        break;
    }
}

/*
    Si no existe en la lista, se agrega nuevo
*/
if (!$encontrado) {
    $producto->cantidad = 1;
    $_SESSION['lista'][] = $producto;

    $_SESSION['mensaje_preparado'] = [
        'tipo' => 'success',
        'texto' => 'Producto agregado correctamente.'
    ];
}

session_write_close();
header("Location: venderPreparado.php#bloque-productos");
exit;
?>