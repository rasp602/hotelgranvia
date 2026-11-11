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

$codigoBarra = trim($_POST['codigoBarra']);
error_log("Código de barras recibido: " . $codigoBarra);

if ($codigoBarra === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Código de barras del producto no proporcionado.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

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

    $stmt->bind_param("s", $codigoBarra);

    if (!$stmt->execute()) {
        throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows <= 0) {
        error_log("Producto no encontrado.");
        echo json_encode([
            'success' => false,
            'message' => 'Producto no encontrado. Código de barras: ' . $codigoBarra
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $product = $result->fetch_assoc();

    $idProducto      = (int)$product['idProducto'];
    $oldExistencia   = (int)$product['existenciaProducto'];
    $nombreProducto  = $product['nombreProducto'];
    $imagenProducto  = $product['imagenProducto'];
    $newExistencia   = $oldExistencia + 1;

    error_log("Producto encontrado: " . print_r($product, true));

    // Actualizar stock
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

    // Registrar en inventario
    $insertSql = "INSERT INTO inventario (
                    idInventario,
                    fechaRegistro,
                    horaRegistro,
                    idProducto,
                    cantRegistro,
                    tipoRegistro,
                    ultimoStock
                  ) 
                  VALUES (
                    NULL,
                    CURDATE(),
                    CURTIME(),
                    ?,
                    1,
                    'I',
                    ?
                  )";

    $insertStmt = $conn->prepare($insertSql);

    if (!$insertStmt) {
        throw new Exception("Error en la preparación de la inserción: " . $conn->error);
    }

    $insertStmt->bind_param("ii", $idProducto, $newExistencia);

    if (!$insertStmt->execute()) {
        throw new Exception("Error en la ejecución de la inserción: " . $insertStmt->error);
    }

    $details = [
        'codigoBarra'    => $codigoBarra,
        'nombre'         => $nombreProducto,
        'oldExistencia'  => $oldExistencia,
        'newExistencia'  => $newExistencia,
        'imagenProducto' => $imagenProducto
    ];

    echo json_encode([
        'success' => true,
        'message' => '✔️ Existencia del producto actualizada correctamente...',
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