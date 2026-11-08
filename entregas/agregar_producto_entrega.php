<?php
include_once "funciones.php";
header('Content-Type: application/json');

session_start();

if (empty($_SESSION['usuario'])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Sesión no válida"
    ]);
    exit;
}

$_SESSION['lista'] = isset($_SESSION['lista']) ? $_SESSION['lista'] : [];

if (!isset($_POST["codigo"])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Producto no recibido"
    ]);
    exit;
}

$idProducto = intval($_POST["codigo"]);
$producto = obtenerProductoPorId($idProducto);

if (!$producto) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Producto no encontrado"
    ]);
    exit;
}

if ((int)$producto->existenciaProducto < 1) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No hay existencia disponible"
    ]);
    exit;
}

$encontrado = false;

foreach ($_SESSION['lista'] as &$item) {
    if ((int)$item->idProducto === $idProducto) {
        $encontrado = true;

        if ((int)$item->cantidad >= (int)$producto->existenciaProducto) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "No puedes agregar más de la existencia disponible"
            ]);
            exit;
        }

        $item->cantidad = (int)$item->cantidad + 1;

        echo json_encode([
            "ok" => true,
            "mensaje" => "Cantidad aumentada en la entrega"
        ]);
        exit;
    }
}
unset($item);

$producto->cantidad = 1;
$_SESSION['lista'][] = $producto;

echo json_encode([
    "ok" => true,
    "mensaje" => "Producto agregado a la entrega"
]);