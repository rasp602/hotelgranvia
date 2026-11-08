<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function responderEgresoLector(bool $ok, string $mensaje, array $detalle = []): void
{
    echo json_encode(
        ['success' => $ok, 'message' => $mensaje, 'details' => $detalle],
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    responderEgresoLector(false, 'Solicitud inválida.');
}

$usuario = $_SESSION['usuarioInventario'] ?? null;
$idUsuario = (int) ($usuario->idUsuario ?? 0);
$token = $_POST['token'] ?? null;
$tokenSesion = $_SESSION['csrfEgresoLector'] ?? '';
if ($idUsuario < 1 || $tokenSesion === '' || !is_string($token) || !hash_equals($tokenSesion, $token)) {
    responderEgresoLector(false, 'Sesión inválida. Inicia sesión y vuelve a abrir el módulo.');
}
session_write_close();

$codigo = $_POST['codigoBarra'] ?? null;
if (!is_string($codigo) || trim($codigo) === '' || strlen(trim($codigo)) > 320) {
    responderEgresoLector(false, 'Código de producto inválido.');
}
$codigo = trim($codigo);

$transaccion = false;
try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require __DIR__ . '/bd/conexion.php';
    $db = $con ?? $conn ?? null;
    if (!($db instanceof mysqli)) {
        throw new RuntimeException('No hay conexión mysqli.');
    }
    $db->set_charset('utf8mb4');
    $db->begin_transaction();
    $transaccion = true;

    $stmt = $db->prepare(
        'SELECT idProducto, codigoBarra, nombreProducto, existenciaProducto, imagenProducto
         FROM producto WHERE codigoBarra = ? FOR UPDATE'
    );
    $stmt->bind_param('s', $codigo);
    $stmt->execute();
    $producto = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$producto || (int) $producto['existenciaProducto'] < 1) {
        $db->rollback();
        responderEgresoLector(false, $producto ? 'El producto no tiene stock disponible.' : 'Producto no encontrado.');
    }

    $idProducto = (int) $producto['idProducto'];
    $stock = (int) $producto['existenciaProducto'] - 1;
    $stmt = $db->prepare(
        'UPDATE producto SET existenciaProducto = existenciaProducto - 1
         WHERE idProducto = ? AND existenciaProducto >= 1'
    );
    $stmt->bind_param('i', $idProducto);
    $stmt->execute();
    if ($stmt->affected_rows !== 1) {
        throw new RuntimeException('No se pudo descontar una unidad.');
    }
    $stmt->close();

    $ahora = new DateTimeImmutable('now', new DateTimeZone('America/Santiago'));
    $fecha = $ahora->format('Y-m-d');
    $hora = $ahora->format('H:i:s');
    $stmt = $db->prepare(
        "INSERT INTO inventario
         (fechaRegistro, horaRegistro, idProducto, cantRegistro, tipoRegistro, ultimoStock, idUsuario)
         VALUES (?, ?, ?, 1, 'E', ?, ?)"
    );
    $stmt->bind_param('ssiii', $fecha, $hora, $idProducto, $stock, $idUsuario);
    $stmt->execute();
    $stmt->close();

    $db->commit();
    $transaccion = false;
    responderEgresoLector(true, 'Se descontó una unidad.', [
        'codigoBarra' => $producto['codigoBarra'],
        'nombre' => $producto['nombreProducto'],
        'imagenProducto' => $producto['imagenProducto'],
        'newExistencia' => $stock,
    ]);
} catch (Throwable $e) {
    if ($transaccion) {
        $db->rollback();
    }
    error_log('Egreso por lector: ' . $e->getMessage());
    responderEgresoLector(false, 'No se pudo registrar la salida. Revisa el log de PHP.');
}
