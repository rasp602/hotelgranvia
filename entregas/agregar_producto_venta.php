<?php
include_once "funciones.php";
session_start();

if (!isset($_SESSION['lista']) || !is_array($_SESSION['lista'])) {
    $_SESSION['lista'] = [];
}

function redirigirConMensaje($tipo, $texto) {
    $_SESSION['mensaje_venta'] = [
        'tipo' => $tipo,
        'texto' => $texto
    ];
    header("Location: vender.php");
    exit;
}

function buscarIndiceProductoEnLista($idProducto, $lista) {
    foreach ($lista as $index => $item) {
        if ((int)$item->idProducto === (int)$idProducto) {
            return $index;
        }
    }
    return -1;
}

function obtenerProductoFlexible($valorBuscado) {
    if ($valorBuscado === '' || $valorBuscado === null) {
        return null;
    }

    $producto = null;

    // 1. Intentar como código de barra exacto
    $producto = obtenerProductoPorCodigoBarraExacto($valorBuscado);
    if ($producto) {
        return $producto;
    }

    // 2. Intentar con la función general
    $producto = obtenerProductoPorCodigo($valorBuscado);
    if ($producto) {
        return $producto;
    }

    // 3. Intentar como idProducto
    if (is_numeric($valorBuscado)) {
        $producto = obtenerProductoPorId((int)$valorBuscado);
        if ($producto) {
            return $producto;
        }
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['agregar'])) {
    header("Location: vender.php");
    exit;
}

$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';

if ($codigo === '') {
    redirigirConMensaje('warning', 'Debes seleccionar un producto.');
}

if (!isset($_SESSION['clienteVenta']) || empty($_SESSION['clienteVenta'])) {
    redirigirConMensaje('warning', 'Primero debes seleccionar un lugar de entrega.');
}

$producto = obtenerProductoFlexible($codigo);

if (!$producto) {
    redirigirConMensaje('danger', 'No se encontró el producto seleccionado. Valor recibido: ' . $codigo);
}

if (!isset($producto->existenciaProducto) || (int)$producto->existenciaProducto <= 0) {
    redirigirConMensaje('warning', 'El producto no tiene existencia disponible.');
}

$indice = buscarIndiceProductoEnLista($producto->idProducto, $_SESSION['lista']);

if ($indice >= 0) {
    $cantidadActual = isset($_SESSION['lista'][$indice]->cantidad)
        ? (int)$_SESSION['lista'][$indice]->cantidad
        : 1;

    $existencia = (int)$producto->existenciaProducto;

    if ($cantidadActual >= $existencia) {
        redirigirConMensaje('warning', 'No puedes agregar más unidades. Se alcanzó la existencia disponible.');
    }

    $_SESSION['lista'][$indice]->cantidad = $cantidadActual + 1;
    redirigirConMensaje('success', 'Cantidad actualizada en la orden de entrega.');
} else {
    $producto->cantidad = 1;
    $_SESSION['lista'][] = $producto;
    redirigirConMensaje('success', 'Producto agregado a la orden de entrega.');
}
?>