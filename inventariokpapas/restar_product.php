<?php
  require_once 'bd/conexionLocal.php'; 
header('Content-Type: application/json');

if (isset($_POST['codigoBarra'])) {
    $codigoBarra = trim($_POST['codigoBarra']);
    error_log("Código de barras recibido: " . $codigoBarra);

    if (empty($codigoBarra)) {
        echo json_encode(['message' => "Código de barras del producto no proporcionado."]);
        exit;
    }

    $sql = "SELECT idProducto, nombreProducto, existenciaProducto FROM producto WHERE codigoBarra = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['message' => "Error en la preparación de la consulta: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("s", $codigoBarra);
    if (!$stmt->execute()) {
        echo json_encode(['message' => "Error en la ejecución de la consulta: " . $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $idProducto = $product['idProducto'];
        $oldExistencia = $product['existenciaProducto'];
        $nombreProducto = $product['nombreProducto'];
        
        error_log("Producto encontrado: " . print_r($product, true));

        $updateSql = "UPDATE producto SET existenciaProducto = existenciaProducto - 1 WHERE idProducto = ?";
        $updateStmt = $conn->prepare($updateSql);
        if (!$updateStmt) {
            echo json_encode(['message' => "Error en la preparación de la actualización: " . $conn->error]);
            exit;
        }

        $updateStmt->bind_param("i", $idProducto);
        if ($updateStmt->execute()) {
            $newExistencia = $oldExistencia - 1;

            $insertSql = "INSERT INTO inventario (idInventario, fechaRegistro, horaRegistro, idProducto, cantRegistro, tipoRegistro,ultimoStock) 
                          VALUES (NULL, NOW(), CURTIME(), ?, 1, 'E','$newExistencia')";
            $insertStmt = $conn->prepare($insertSql);
            if (!$insertStmt) {
                echo json_encode(['message' => "Error en la preparación de la inserción: " . $conn->error]);
                exit;
            }

            $insertStmt->bind_param("i", $idProducto);
            if ($insertStmt->execute()) {
                $details = [
                    'codigoBarra' => $codigoBarra,
                    'nombre' => $nombreProducto,
                    'oldExistencia' => $oldExistencia,
                    'newExistencia' => $newExistencia
                ];
                echo json_encode([
                    'message' => "✔️ Existencia del producto actualizada correctamente...",
                    'details' => $details
                ]);
                
            } else {
                error_log("Error en la ejecución de la inserción: " . $insertStmt->error);
                echo json_encode(['message' => "Error en la ejecución de la inserción: " . $insertStmt->error]);
            }
        } else {
            error_log("Error en la ejecución de la actualización: " . $updateStmt->error);
            echo json_encode(['message' => "Error en la ejecución de la actualización: " . $updateStmt->error]);
        }
    } else {
        error_log("Producto no encontrado.");
        echo json_encode(['message' => "Producto no encontrado. Código de barras: " . $codigoBarra]);
    }

    $stmt->close();
    $updateStmt->close();
    $insertStmt->close();
    $conn->close();
} else {
    echo json_encode(['message' => "Código de barras del producto no proporcionado."]);
}
?>
