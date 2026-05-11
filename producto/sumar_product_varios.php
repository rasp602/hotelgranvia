<?php
$servername = "190.101.222.6";
$username = "hotel";
$password = "chile2023$";
$dbname = "hoteleria";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['message' => "Conexión fallida: " . $conn->connect_error]));
}

header('Content-Type: application/json');

if (isset($_POST['codigoBarra'])) {
    $codigoBarra = trim($_POST['codigoBarra']);
    error_log("Código de barras recibido: " . $codigoBarra);

    if (empty($codigoBarra)) {
        echo json_encode(['message' => "Código de barras del producto no proporcionado."]);
        exit;
    }

    $cantidad = trim($_POST['cantidad']);
    error_log("Cantidad recibida: " . $cantidad);

    if (empty($cantidad)) {
        echo json_encode(['message' => "Cantidad del producto no proporcionado."]);
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
        $newExistencia = $oldExistencia + $cantidad;

        error_log("Producto encontrado: " . print_r($product, true));

        $updateSql = "UPDATE producto SET existenciaProducto = ? WHERE idProducto = ?";
        $updateStmt = $conn->prepare($updateSql);
        if (!$updateStmt) {
            echo json_encode(['message' => "Error en la preparación de la actualización: " . $conn->error]);
            exit;
        }

        $updateStmt->bind_param("ii", $newExistencia, $idProducto);
        if ($updateStmt->execute()) {
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

            // Insertar el registro en inventario sin detener el flujo si falla
            $insertSql = "INSERT INTO inventario (idInventario, fechaRegistro, horaRegistro, idProducto, cantRegistro, tipoRegistro, ultimoStock) 
                          VALUES (NULL, NOW(), CURTIME(), ?, ?, 'I', ?)";
            $insertStmt = $conn->prepare($insertSql);
            if ($insertStmt) {
                $insertStmt->bind_param("iii", $idProducto, $cantidad, $newExistencia);
                if (!$insertStmt->execute()) {
                    error_log("Error en la ejecución de la inserción: " . $insertStmt->error);
                }
                $insertStmt->close();
            } else {
                error_log("Error en la preparación de la inserción: " . $conn->error);
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
    $conn->close();
} else {
    echo json_encode(['message' => "Código de barras del producto no proporcionado."]);
}
?>
