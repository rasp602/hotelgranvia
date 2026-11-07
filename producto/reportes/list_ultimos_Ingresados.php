<?php
if (($_REQUEST['action'] ?? '') !== 'ajax') {
    return;
}

require __DIR__ . '/../../bd/conexionLocal.php';

try {
    // Algunos archivos de conexión usan $con y otros usan $conn.
    $db = $con ?? $conn ?? null;

    if (!($db instanceof mysqli)) {
        throw new RuntimeException(
            'conexionLocal.php no proporcionó una conexión mysqli.'
        );
    }

    if (!$db->set_charset('utf8mb4')) {
        throw new RuntimeException($db->error);
    }

    $desdeTablas = "
        FROM inventario AS i
        INNER JOIN producto AS p ON p.idProducto = i.idProducto
    ";

    // El conteo no lleva columnas de detalle ni LIMIT.
    $resultadoTotal = $db->query("
        SELECT COUNT(*) AS total
        $desdeTablas
    ");

    if ($resultadoTotal === false) {
        throw new RuntimeException($db->error);
    }

    $total = (int) $resultadoTotal->fetch_assoc()['total'];

    $movimientos = $db->query("
        SELECT
            i.fechaRegistro,
            i.horaRegistro,
            p.nombreProducto,
            i.cantRegistro,
            i.tipoRegistro,
            i.ultimoStock
        $desdeTablas
        ORDER BY i.idInventario DESC
        LIMIT 20
    ");

    if ($movimientos === false) {
        throw new RuntimeException($db->error);
    }
} catch (Throwable $e) {
    error_log('Listado de inventario: ' . $e->getMessage());
    http_response_code(500);
    echo '<div class="alert alert-danger">No se pudo consultar el inventario. Revisa el log de PHP.</div>';
    return;
}

$esc = static function ($valor): string {
    return htmlspecialchars(
        (string) ($valor ?? '—'),
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
};

$tipos = ['I' => 'Ingreso', 'E' => 'Egreso'];
?>

<div class="container-fluid">
    <?php if ($movimientos->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
                <thead>
                    <tr class="bg-primary">
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Tipo de Registro</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $movimientos->fetch_assoc()): ?>
                        <tr>
                            <td><?= $esc($row['fechaRegistro']) ?></td>
                            <td><?= $esc($row['horaRegistro']) ?></td>
                            <td><?= $esc($row['nombreProducto']) ?></td>
                            <td class="text-center"><?= $esc($row['cantRegistro']) ?></td>
                            <td class="text-center">
                                <?= $esc($tipos[$row['tipoRegistro']] ?? $row['tipoRegistro']) ?>
                            </td>
                            <td class="text-center"><?= $esc($row['ultimoStock']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            Mostrando <?= $movimientos->num_rows ?> de <?= $total ?> registros.
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No hay movimientos para mostrar.</div>
    <?php endif; ?>
</div>