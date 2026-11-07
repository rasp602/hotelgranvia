<?php
// Archivo en la raíz del sistema, junto a buscar_productos_stock.php.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function respuestaEgreso($datos) {
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

$transaccion = false;
try {
    // La misma conexión mysqli del buscador proporcionado.
    require_once __DIR__ . '/bd/conexionLocal.php';
    if (!isset($con) || !($con instanceof mysqli)) {
        throw new RuntimeException('bd/conexion.php no proporciona la conexión $con.');
    }
    mysqli_set_charset($con, 'utf8mb4');
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    if ($accion === 'buscar') {
        $busqueda = isset($_POST['busqueda']) ? trim($_POST['busqueda']) : '';
        if ($busqueda === '') {
            respuestaEgreso(array('success' => true, 'productos' => array()));
        }
        $busquedaLike = '%' . $busqueda . '%';
        $sql = "SELECT idProducto, codigoBarra, nombreProducto, existenciaProducto, imagenProducto
                FROM producto WHERE nombreProducto LIKE ? OR codigoBarra LIKE ?
                ORDER BY nombreProducto ASC LIMIT 20";
        $stmt = mysqli_prepare($con, $sql);
        if (!$stmt) { throw new RuntimeException(mysqli_error($con)); }
        mysqli_stmt_bind_param($stmt, 'ss', $busquedaLike, $busquedaLike);
        if (!mysqli_stmt_execute($stmt)) { throw new RuntimeException(mysqli_stmt_error($stmt)); }
        $resultado = mysqli_stmt_get_result($stmt);
        $productos = array();
        while ($row = mysqli_fetch_assoc($resultado)) { $productos[] = $row; }
        mysqli_stmt_close($stmt);
        respuestaEgreso(array('success' => true, 'productos' => $productos));
    }

    if ($accion === 'ultimos') {
        $sql = "SELECT i.idInventario, i.fechaRegistro, i.horaRegistro, i.cantRegistro, i.ultimoStock,
                       p.nombreProducto, p.codigoBarra, u.nombre AS nombreUsuario, u.apellido AS apellidoUsuario
                FROM inventario i
                LEFT JOIN producto p ON p.idProducto = i.idProducto
                LEFT JOIN tblusuario u ON u.idUsuario = i.idUsuario
                WHERE i.tipoRegistro = 'E' ORDER BY i.idInventario DESC LIMIT 20";
        $resultado = mysqli_query($con, $sql);
        if (!$resultado) { throw new RuntimeException(mysqli_error($con)); }
        $movimientos = array();
        while ($row = mysqli_fetch_assoc($resultado)) { $movimientos[] = $row; }
        respuestaEgreso(array('success' => true, 'movimientos' => $movimientos));
    }

    if ($accion !== 'egresar') { throw new InvalidArgumentException('Acción inválida.'); }
    // El usuario del movimiento se obtiene de sesión, nunca del input oculto.
    $usuario = isset($_SESSION['usuarioInventario']) ? $_SESSION['usuarioInventario'] : null;
    $idUsuario = is_object($usuario) && isset($usuario->idUsuario) ? (int)$usuario->idUsuario : 0;
    if ($idUsuario < 1) {
        throw new InvalidArgumentException('Debe iniciar sesión en inventario para registrar un egreso.');
    }
    $idProducto = isset($_POST['idProducto']) ? $_POST['idProducto'] : '';
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
    $opciones = array('options' => array('min_range' => 1, 'max_range' => 2147483647));
    if (filter_var($idProducto, FILTER_VALIDATE_INT, $opciones) === false ||
        filter_var($cantidad, FILTER_VALIDATE_INT, $opciones) === false) {
        throw new InvalidArgumentException('Seleccione un producto y una cantidad entera mayor que cero.');
    }
    $porCaja = isset($_POST['porCaja']) ? $_POST['porCaja'] : '0';
    if (!in_array($porCaja, array('0', '1'), true)) {
        throw new InvalidArgumentException('Tipo de egreso inválido.');
    }
    $idProducto = (int)$idProducto;
    $cantidadIngresada = (int)$cantidad;
    $unidadesPorCaja = 1;
    if ($porCaja === '1') {
        $unidadesPorCaja = isset($_POST['unidadesPorCaja']) ? $_POST['unidadesPorCaja'] : '';
        if (filter_var($unidadesPorCaja, FILTER_VALIDATE_INT, $opciones) === false) {
            throw new InvalidArgumentException('Ingrese una cantidad entera mayor que cero en unidades por caja.');
        }
        $unidadesPorCaja = (int)$unidadesPorCaja;
    }
    // Se calcula en servidor; no se recibe un total calculado por el navegador.
    // Nunca se modifica producto.caja.
    if ($cantidadIngresada > intdiv(2147483647, $unidadesPorCaja)) {
        throw new InvalidArgumentException('El total de unidades es demasiado grande.');
    }
    $cantidad = $cantidadIngresada * $unidadesPorCaja;
    if (!mysqli_begin_transaction($con)) { throw new RuntimeException(mysqli_error($con)); }
    $transaccion = true;
    $stmt = mysqli_prepare($con, 'SELECT idProducto, codigoBarra, nombreProducto, existenciaProducto, imagenProducto FROM producto WHERE idProducto = ? FOR UPDATE');
    if (!$stmt) { throw new RuntimeException(mysqli_error($con)); }
    mysqli_stmt_bind_param($stmt, 'i', $idProducto);
    if (!mysqli_stmt_execute($stmt)) { throw new RuntimeException(mysqli_stmt_error($stmt)); }
    $producto = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    if (!$producto) { throw new InvalidArgumentException('Producto no encontrado.'); }
    if ($cantidad > $producto['existenciaProducto']) {
        throw new InvalidArgumentException('Stock insuficiente. Disponible: ' . $producto['existenciaProducto'] . '.');
    }
    $stmt = mysqli_prepare($con, 'UPDATE producto SET existenciaProducto = existenciaProducto - ? WHERE idProducto = ? AND existenciaProducto >= ?');
    if (!$stmt) { throw new RuntimeException(mysqli_error($con)); }
    mysqli_stmt_bind_param($stmt, 'iii', $cantidad, $idProducto, $cantidad);
    if (!mysqli_stmt_execute($stmt) || mysqli_stmt_affected_rows($stmt) !== 1) {
        throw new RuntimeException('No se pudo descontar el stock.');
    }
    mysqli_stmt_close($stmt);
    $ultimoStock = $producto['existenciaProducto'] - $cantidad;
    $ahora = new DateTime('now', new DateTimeZone('America/Santiago'));
    $fechaRegistro = $ahora->format('Y-m-d');
    $horaRegistro = $ahora->format('H:i:s');
    $tipoRegistro = 'E';
    $stmt = mysqli_prepare($con, 'INSERT INTO inventario (fechaRegistro, horaRegistro, idProducto, cantRegistro, tipoRegistro, ultimoStock, idUsuario) VALUES (?, ?, ?, ?, ?, ?, ?)');
    if (!$stmt) { throw new RuntimeException(mysqli_error($con)); }
    mysqli_stmt_bind_param($stmt, 'ssiisdi', $fechaRegistro, $horaRegistro, $idProducto, $cantidad, $tipoRegistro, $ultimoStock, $idUsuario);
    if (!mysqli_stmt_execute($stmt)) { throw new RuntimeException(mysqli_stmt_error($stmt)); }
    mysqli_stmt_close($stmt);
    if (!mysqli_commit($con)) { throw new RuntimeException(mysqli_error($con)); }
    $transaccion = false;
    $producto['porCaja'] = $porCaja === '1';
    $producto['cantidadCajas'] = $porCaja === '1' ? $cantidadIngresada : 0;
    $producto['unidadesPorCaja'] = $unidadesPorCaja;
    $producto['cantidad'] = $cantidad;
    $producto['newExistencia'] = $ultimoStock;
    respuestaEgreso(array('success' => true, 'message' => 'Egreso registrado correctamente.', 'details' => $producto));
} catch (Exception $e) {
    if ($transaccion && isset($con)) { mysqli_rollback($con); }
    if ($e instanceof InvalidArgumentException) {
        respuestaEgreso(array('success' => false, 'message' => $e->getMessage()));
    }
    error_log('Egreso por descripción: ' . $e->getMessage());
    respuestaEgreso(array('success' => false, 'message' => 'Error de base de datos. Revise bd/conexion.php y el registro de errores de PHP.'));
}
