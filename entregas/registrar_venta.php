<?php
session_start();
include_once "funciones.php";

if (empty($_SESSION['usuario'])) {
    $_SESSION['mensaje_venta'] = [
        'tipo' => 'warning',
        'texto' => 'Tu sesión no está activa. Debes iniciar sesión nuevamente.'
    ];
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['clienteVenta']) || empty($_SESSION['clienteVenta'])) {
    $_SESSION['mensaje_venta'] = [
        'tipo' => 'warning',
        'texto' => 'Debes seleccionar un lugar de entrega antes de terminar la orden.'
    ];
    header("Location: vender.php");
    exit;
}

if (!isset($_SESSION['lista']) || empty($_SESSION['lista'])) {
    $_SESSION['mensaje_venta'] = [
        'tipo' => 'warning',
        'texto' => 'No hay productos en la orden de entrega.'
    ];
    header("Location: vender.php");
    exit;
}

date_default_timezone_set("America/Santiago");


function obtenerUsuarioSesion($usuarioSesion) {

    // 🔥 CASO 1: viene como objeto
    if (is_object($usuarioSesion)) {
        if (isset($usuarioSesion->idUsuario) && (int)$usuarioSesion->idUsuario > 0) {
            return $usuarioSesion;
        }

        if (isset($usuarioSesion->usuario)) {
            return obtenerUsuarioPorNombre($usuarioSesion->usuario);
        }

        if (isset($usuarioSesion->nombre)) {
            return obtenerUsuarioPorNombre($usuarioSesion->nombre);
        }
    }

    // 🔥 CASO 2: viene como array
    if (is_array($usuarioSesion)) {
        if (isset($usuarioSesion['idUsuario']) && (int)$usuarioSesion['idUsuario'] > 0) {
            return (object)$usuarioSesion;
        }

        if (isset($usuarioSesion['usuario'])) {
            return obtenerUsuarioPorNombre($usuarioSesion['usuario']);
        }

        if (isset($usuarioSesion['nombre'])) {
            return obtenerUsuarioPorNombre($usuarioSesion['nombre']);
        }
    }

    // 🔥🔥🔥 CASO 3: viene como string (TU CASO)
    if (is_string($usuarioSesion) && !empty($usuarioSesion)) {
        return obtenerUsuarioPorNombre($usuarioSesion);
    }

    return null;
}

function obtenerPrecioProductoEntrega($producto) {
    if (isset($producto->precioProducto)) return (float)$producto->precioProducto;
    if (isset($producto->precioVenta)) return (float)$producto->precioVenta;
    if (isset($producto->precio)) return (float)$producto->precio;
    return 0;
}

$usuarioSesion = obtenerUsuarioSesion($_SESSION['usuario']);
$idUsuario = ($usuarioSesion && isset($usuarioSesion->idUsuario)) ? (int)$usuarioSesion->idUsuario : 0;

$idHotel = (int)$_SESSION['clienteVenta'];
$productos = $_SESSION['lista'];

if ($idUsuario <= 0) {
    $debugUsuario = '';

    if (is_object($_SESSION['usuario']) || is_array($_SESSION['usuario'])) {
        $debugUsuario = json_encode($_SESSION['usuario'], JSON_UNESCAPED_UNICODE);
    } else {
        $debugUsuario = (string)$_SESSION['usuario'];
    }

    $_SESSION['mensaje_venta'] = [
        'tipo' => 'error',
        'texto' => 'No se pudo identificar el usuario que registra la entrega. Sesión usuario: ' . $debugUsuario
    ];
    header("Location: vender.php");
    exit;
}

$total = 0;
$gananciaG = 0;

foreach ($productos as $producto) {
    $cantidad = isset($producto->cantidad) ? (int)$producto->cantidad : 1;
    $precio = obtenerPrecioProductoEntrega($producto);
    $compra = isset($producto->precioCompra) ? (float)$producto->precioCompra : 0;

    $total += ($cantidad * $precio);
    $gananciaG += ($cantidad * ($precio - $compra));
}

$tipoEntrega = "ENTREGA";

$resultado = registrarVenta($productos, $idUsuario, $idHotel, $total, $tipoEntrega, $gananciaG);

if ($resultado) {
    $_SESSION['lista'] = [];
    unset($_SESSION['clienteVenta']);

    $_SESSION['mensaje_venta'] = [
        'tipo' => 'success',
        'texto' => 'La orden de entrega fue registrada correctamente.'
    ];
} else {
    $_SESSION['mensaje_venta'] = [
        'tipo' => 'error',
        'texto' => 'No se pudo registrar la orden de entrega.'
    ];
}

header("Location: vender.php");
exit;
?>