<?php
require_once 'bd/conexionLocal.php';

header('Content-Type: application/json; charset=utf-8');

if (isset($_POST['codigoBarra'])) {
    $codigoBarra = trim($_POST['codigoBarra']);
    error_log("Código de barras recibido: " . $codigoBarra);

    if (empty($codigoBarra)) {
        echo json_encode([
            'message' => "Código de barras del producto no proporcionado.",
            'success' => false
        ]);
        exit;
    }

    // Consulta para obtener los datos del producto por el código de barras
    $sql = "SELECT idProducto, nombreProducto, existenciaProducto, imagenProducto 
            FROM producto 
            WHERE codigoBarra = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            'message' => "Error en la preparación de la consulta: " . $conn->error,
            'success' => false
        ]);
        exit;
    }

    $stmt->bind_param("s", $codigoBarra);

    if (!$stmt->execute()) {
        echo json_encode([
            'message' => "Error en la ejecución de la consulta: " . $stmt->error,
            'success' => false
        ]);
        exit;
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        $details = [
            'idProducto'       => $product['idProducto'],
            'codigoBarra'      => $codigoBarra,
            'nombre'           => $product['nombreProducto'],
            'existenciaActual' => $product['existenciaProducto'],
            'imagenProducto'   => $product['imagenProducto']
        ];

        echo json_encode([
            'message' => "Producto encontrado.",
            'success' => true,
            'details' => $details
        ], JSON_UNESCAPED_UNICODE);

    } else {
        error_log("Producto no encontrado.");
        echo json_encode([
            'message' => "Producto no encontrado. Código de barras: " . $codigoBarra,
            'success' => false
        ], JSON_UNESCAPED_UNICODE);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'message' => "Código de barras del producto no proporcionado.",
        'success' => false
    ], JSON_UNESCAPED_UNICODE);
}
?>