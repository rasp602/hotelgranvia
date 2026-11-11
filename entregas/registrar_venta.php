<?php

session_start();

$redirigir = static function (string $destino, string $tipo, string $texto): void {
    $_SESSION['mensaje_venta'] = [
        'tipo' => $tipo,
        'texto' => $texto,
    ];

    header('Location: ' . $destino, true, 303);
    exit;
};

if (empty($_SESSION['usuario'])) {
    $redirigir(
        'login.php',
        'warning',
        'Tu sesión no está activa. Debes iniciar sesión nuevamente.'
    );
}

$idHotel = filter_var(
    $_SESSION['clienteVenta'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

if ($idHotel === false) {
    $redirigir(
        'vender.php',
        'warning',
        'Debes seleccionar un lugar de entrega antes de terminar la orden.'
    );
}

$productos = $_SESSION['lista'] ?? [];

if (!is_array($productos) || $productos === []) {
    $redirigir(
        'vender.php',
        'warning',
        'No hay productos en la orden de entrega.'
    );
}

date_default_timezone_set('America/Santiago');

$etapa = 'cargar funciones';
$guardadoIniciado = false;

try {
    require_once __DIR__ . '/funciones.php';

    $etapa = 'identificar usuario de sesión';
    $sesion = $_SESSION['usuario'];

    $usuario = is_object($sesion)
        ? get_object_vars($sesion)
        : (is_array($sesion) ? $sesion : []);

    $idUsuario = (int) ($usuario['idUsuario'] ?? 0);

    if ($idUsuario <= 0) {
        $nombreUsuario = is_string($sesion)
            ? trim($sesion)
            : trim((string) ($usuario['usuario'] ?? ''));

        if ($nombreUsuario === '') {
            $nombreUsuario = trim((string) ($usuario['nombre'] ?? ''));
        }

        if ($nombreUsuario !== '') {
            if (!function_exists('obtenerUsuarioPorNombre')) {
                throw new RuntimeException(
                    'funciones.php no define obtenerUsuarioPorNombre().'
                );
            }

            $encontrado = obtenerUsuarioPorNombre($nombreUsuario);

            if (is_object($encontrado)) {
                $idUsuario = (int) ($encontrado->idUsuario ?? 0);
            } elseif (is_array($encontrado)) {
                $idUsuario = (int) ($encontrado['idUsuario'] ?? 0);
            }
        }
    }

    if ($idUsuario <= 0) {
        $redirigir(
            'vender.php',
            'error',
            'No se pudo identificar al usuario de la entrega. Vuelve a iniciar sesión.'
        );
    }

    $etapa = 'calcular total de la orden';
    $total = 0.0;
    $gananciaG = 0.0;

    foreach ($productos as $producto) {
        $datos = is_object($producto) ? get_object_vars($producto) : $producto;

        if (!is_array($datos)) {
            throw new UnexpectedValueException('La orden contiene un producto inválido.');
        }

        $cantidad = filter_var(
            $datos['cantidad'] ?? 1,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 0]]
        );

        if ($cantidad === false) {
            throw new UnexpectedValueException('La orden contiene una cantidad inválida.');
        }

        $precio = (float) (
            $datos['precioProducto']
            ?? $datos['precioVenta']
            ?? $datos['precio']
            ?? 0
        );

        $compra = (float) ($datos['precioCompra'] ?? 0);

        $total += $cantidad * $precio;
        $gananciaG += $cantidad * ($precio - $compra);
    }

    $etapa = 'registrar orden';
    if (!function_exists('registrarVenta')) {
        throw new RuntimeException('funciones.php no define registrarVenta().');
    }

    $guardadoIniciado = true;
    $resultado = registrarVenta(
        $productos,
        $idUsuario,
        $idHotel,
        $total,
        'EN',
        $gananciaG
    );

    if (!$resultado) {
        throw new RuntimeException('registrarVenta() devolvió un resultado falso o vacío.');
    }

    $_SESSION['lista'] = [];
    unset($_SESSION['clienteVenta']);

    $redirigir(
        'vender.php',
        'success',
        'La orden de entrega fue registrada correctamente.'
    );

} catch (Throwable $e) {
    error_log(sprintf(
        '[registrar_venta] Etapa: %s | %s: %s | %s:%d',
        $etapa,
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    ));

    $mensaje = $guardadoIniciado
        ? 'No se pudo confirmar la entrega. Revisa el historial antes de volver a guardarla.'
        : 'No se pudo preparar la entrega. La orden se conservó.';

    $redirigir('vender.php', 'error', $mensaje);
}