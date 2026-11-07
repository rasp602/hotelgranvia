<?php
require_once 'bd/conexionLocal.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['codigoBarra'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Código de barras del producto no proporcionado.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$productBarcode = trim($_POST['codigoBarra']);
error_log("Código de barras recibido: " . $productBarcode);

if ($productBarcode === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Código de barras del producto no proporcionado.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($_POST['cantidad']) || trim($_POST['cantidad']) === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Cantidad del producto no proporcionada.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$usuarioRegistro = isset($_POST['usuarioRegistro']) ? trim($_POST['usuarioRegistro']) : '';

if ($usuarioRegistro === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario del registro no proporcionado.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!is_numeric($usuarioRegistro) || $usuarioRegistro <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario del registro inválido.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$usuarioRegistro = (int)$usuarioRegistro;

$cantidad = trim($_POST['cantidad']);
error_log("Cantidad recibida: " . $cantidad);
error_log("Usuario recibido: " . $usuarioRegistro);

if (!is_numeric($cantidad) || $cantidad <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Cantidad inválida.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$cantidad = (int)$cantidad;

$stmt = null;
$updateStmt = null;
$insertStmt = null;

try {
    $sql = "SELECT idProducto, nombreProducto, existenciaProducto, imagenProducto 
            FROM producto 
            WHERE codigoBarra = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $productBarcode);

    if (!$stmt->execute()) {
        throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Producto no encontrado. Código de barras: ' . $productBarcode
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $product = $result->fetch_assoc();

    $idProducto      = (int)$product['idProducto'];
    $nombreProducto  = $product['nombreProducto'];
    $oldExistencia   = (int)$product['existenciaProducto'];
    $imagenProducto  = $product['imagenProducto'];
    $newExistencia   = $oldExistencia + $cantidad;

    error_log("Producto encontrado: " . print_r($product, true));

    $updateSql = "UPDATE producto 
                  SET existenciaProducto = ? 
                  WHERE idProducto = ?";
    $updateStmt = $conn->prepare($updateSql);

    if (!$updateStmt) {
        throw new Exception("Error en la preparación de la actualización: " . $conn->error);
    }

    $updateStmt->bind_param("ii", $newExistencia, $idProducto);

    if (!$updateStmt->execute()) {
        throw new Exception("Error en la ejecución de la actualización: " . $updateStmt->error);
    }

    $insertSql = "INSERT INTO inventario (
                    idInventario,
                    fechaRegistro,
                    horaRegistro,
                    idProducto,
                    cantRegistro,
                    tipoRegistro,
                    ultimoStock,
                    idUsuario
                  ) 
                  VALUES (
                    NULL,
                    CURDATE(),
                    CURTIME(),
                    ?,
                    ?,
                    'I',
                    ?,
                    ?
                  )";

    $insertStmt = $conn->prepare($insertSql);

    if (!$insertStmt) {
        throw new Exception("Error en la preparación de la inserción: " . $conn->error);
    }

    $insertStmt->bind_param(
        "iiii",
        $idProducto,
        $cantidad,
        $newExistencia,
        $usuarioRegistro
    );

    if (!$insertStmt->execute()) {
        throw new Exception("Error en la ejecución de la inserción: " . $insertStmt->error);
    }

    $details = [
        'idProducto'      => $idProducto,
        'codigoBarra'     => $productBarcode,
        'nombre'          => $nombreProducto,
        'oldExistencia'   => $oldExistencia,
        'cantidad'        => $cantidad,
        'newExistencia'   => $newExistencia,
        'imagenProducto'  => $imagenProducto,
        'idUsuario'       => $usuarioRegistro
    ];

    echo json_encode([
        'success' => true,
        'message' => '✔️ Existencia del producto actualizada correctamente.',
        'details' => $details
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    error_log($e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
} finally {
    if ($stmt) {
        $stmt->close();
    }

    if ($updateStmt) {
        $updateStmt->close();
    }

    if ($insertStmt) {
        $insertStmt->close();
    }

    $conn->close();
}
?>