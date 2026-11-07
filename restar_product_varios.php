<?php 
require_once 'bd/conexionLocal.php'; 
 
header('Content-Type: application/json; charset=utf-8'); 
 
if (!isset($_POST['codigoBarra']) || !isset($_POST['cantidad'])) { 
    echo json_encode([ 
        'success' => false, 
        'message' => 'Código de barras o cantidad no proporcionada.' 
    ]); 
    exit; 
} 
 
$codigoBarra = trim($_POST['codigoBarra']); 
$cantidad = (int) $_POST['cantidad']; 

// Recibir usuario que realiza el egreso
$usuarioRegistro = isset($_POST['usuarioRegistro']) 
    ? (int) $_POST['usuarioRegistro'] 
    : 0;
 
if ($codigoBarra == '') { 
    echo json_encode([ 
        'success' => false, 
        'message' => 'Código de barras del producto no proporcionado.' 
    ]); 
    exit; 
} 
 
if ($cantidad <= 0) { 
    echo json_encode([ 
        'success' => false, 
        'message' => 'La cantidad debe ser mayor a 0.' 
    ]); 
    exit; 
} 

if ($usuarioRegistro <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario del registro no proporcionado.'
    ]);
    exit;
}
 
$sql = "SELECT idProducto, nombreProducto, existenciaProducto, imagenProducto  
        FROM producto  
        WHERE codigoBarra = ?"; 
 
$stmt = $conn->prepare($sql); 
 
if (!$stmt) { 
    echo json_encode([ 
        'success' => false, 
        'message' => 'Error en la preparación de la consulta: ' . $conn->error 
    ]); 
    exit; 
} 
 
$stmt->bind_param("s", $codigoBarra); 
 
if (!$stmt->execute()) { 
    echo json_encode([ 
        'success' => false, 
        'message' => 'Error en la ejecución de la consulta: ' . $stmt->error 
    ]); 
    exit; 
} 
 
$result = $stmt->get_result(); 
 
if ($result->num_rows == 0) { 
    echo json_encode([ 
        'success' => false, 
        'message' => 'Producto no encontrado. Código de barras: ' . $codigoBarra 
    ]); 
    exit; 
} 
 
$product = $result->fetch_assoc(); 
 
$idProducto = (int) $product['idProducto']; 
$oldExistencia = (int) $product['existenciaProducto']; 
$nombreProducto = $product['nombreProducto']; 
$imagenProducto = isset($product['imagenProducto']) ? $product['imagenProducto'] : ''; 
 
if ($oldExistencia < $cantidad) { 
    echo json_encode([ 
        'success' => false, 
        'message' => 'No hay stock suficiente. Existencia actual: ' . $oldExistencia, 
        'details' => [ 
            'codigoBarra' => $codigoBarra, 
            'nombre' => $nombreProducto, 
            'oldExistencia' => $oldExistencia, 
            'newExistencia' => $oldExistencia, 
            'cantidadEgresada' => 0, 
            'imagenProducto' => $imagenProducto 
        ] 
    ]); 
    exit; 
} 
 
$newExistencia = $oldExistencia - $cantidad; 
 
$conn->begin_transaction(); 
 
try { 

    $updateSql = "UPDATE producto  
                  SET existenciaProducto = ?  
                  WHERE idProducto = ?"; 
 
    $updateStmt = $conn->prepare($updateSql); 
 
    if (!$updateStmt) { 
        throw new Exception('Error en la preparación de la actualización: ' . $conn->error); 
    } 
 
    $updateStmt->bind_param("ii", $newExistencia, $idProducto); 
 
    if (!$updateStmt->execute()) { 
        throw new Exception('Error en la ejecución de la actualización: ' . $updateStmt->error); 
    } 
 
    $insertSql = "INSERT INTO inventario  
                  (
                    idInventario,
                    fechaRegistro,
                    horaRegistro,
                    idProducto,
                    cantRegistro,
                    tipoRegistro,
                    ultimoStock,
                    idUsuario
                  )  
                  VALUES  
                  (
                    NULL,
                    NOW(),
                    CURTIME(),
                    ?,
                    ?,
                    'E',
                    ?,
                    ?
                  )"; 
 
    $insertStmt = $conn->prepare($insertSql); 
 
    if (!$insertStmt) { 
        throw new Exception('Error en la preparación de la inserción: ' . $conn->error); 
    } 
 
    $insertStmt->bind_param(
        "iiii",
        $idProducto,
        $cantidad,
        $newExistencia,
        $usuarioRegistro
    ); 
 
    if (!$insertStmt->execute()) { 
        throw new Exception('Error en la ejecución de la inserción: ' . $insertStmt->error); 
    } 
 
    $conn->commit(); 
 
    echo json_encode([ 
        'success' => true, 
        'message' => '✔️ Producto egresado correctamente. Cantidad egresada: ' . $cantidad, 
        'details' => [ 
            'codigoBarra' => $codigoBarra, 
            'nombre' => $nombreProducto, 
            'oldExistencia' => $oldExistencia, 
            'newExistencia' => $newExistencia, 
            'cantidadEgresada' => $cantidad, 
            'imagenProducto' => $imagenProducto,
            'idUsuario' => $usuarioRegistro
        ] 
    ]); 
    exit; 
 
} catch (Exception $e) { 

    $conn->rollback(); 
 
    echo json_encode([ 
        'success' => false, 
        'message' => $e->getMessage() 
    ]); 
    exit; 
} 
?>