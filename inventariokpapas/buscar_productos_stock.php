<?php

header('Content-Type: application/json; charset=utf-8');

/*
===========================================================
USAR LA MISMA BASE DE DATOS DEL RESTO DEL INVENTARIO
===========================================================
*/

require_once 'bd/conexionLocal.php';


$busqueda = isset($_POST['busqueda'])
    ? trim($_POST['busqueda'])
    : '';


if ($busqueda === '') {

    echo json_encode([
        'success' => false,
        'message' => 'Debe ingresar un producto para buscar.',
        'productos' => []
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


$busquedaLike = '%' . $busqueda . '%';


/*
===========================================================
BUSCAR PRODUCTOS

Incluimos caja para saber cuántas unidades representa
cada caja.
===========================================================
*/

$sql = "SELECT
            idProducto,
            codigoBarra,
            nombreProducto,
            existenciaProducto,
            imagenProducto,
            caja

        FROM producto

        WHERE (
            nombreProducto LIKE ?
            OR codigoBarra LIKE ?
        )

        AND estado = 1

        ORDER BY nombreProducto ASC

        LIMIT 20";


$stmt = $conn->prepare($sql);


if (!$stmt) {

    echo json_encode([
        'success' => false,
        'message' => 'Error preparando consulta: ' . $conn->error,
        'productos' => []
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


$stmt->bind_param(
    "ss",
    $busquedaLike,
    $busquedaLike
);


if (!$stmt->execute()) {

    echo json_encode([
        'success' => false,
        'message' => 'Error ejecutando consulta: ' . $stmt->error,
        'productos' => []
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


$resultado = $stmt->get_result();


$productos = [];


while ($row = $resultado->fetch_assoc()) {


    /*
    ========================================================
    NORMALIZAR CAJA

    Si es producto normal:
    caja = 1

    Si es producto por caja:
    caja = cantidad de unidades
    ========================================================
    */

    $caja = isset($row['caja'])
        ? (int)$row['caja']
        : 1;


    if ($caja <= 0) {
        $caja = 1;
    }


    $productos[] = [

        'idProducto' =>
            $row['idProducto'],

        'codigoBarra' =>
            $row['codigoBarra'],

        'nombreProducto' =>
            $row['nombreProducto'],

        'existenciaProducto' =>
            $row['existenciaProducto'],

        'imagenProducto' =>
            $row['imagenProducto'],

        'caja' =>
            $caja
    ];
}


/*
===========================================================
RESPUESTA
===========================================================
*/

echo json_encode([

    'success' => true,

    'total' => count($productos),

    'productos' => $productos

], JSON_UNESCAPED_UNICODE);


$stmt->close();

$conn->close();

?>