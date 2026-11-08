<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: vender.php");
    exit;
}

$cliente = isset($_POST['idCliente']) ? trim($_POST['idCliente']) : '';

if ($cliente === '') {
    $_SESSION['mensaje_venta'] = [
        'tipo' => 'warning',
        'texto' => 'Debes seleccionar un lugar de entrega.'
    ];
    header("Location: vender.php");
    exit;
}

$_SESSION['clienteVenta'] = $cliente;
$_SESSION['mensaje_venta'] = [
    'tipo' => 'success',
    'texto' => 'Lugar de entrega seleccionado correctamente.'
];

header("Location: vender.php");
exit;
?>