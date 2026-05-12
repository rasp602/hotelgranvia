<?php
error_reporting(E_ERROR | E_PARSE);
include '../../bd/conexionLocal.php';

$action = $_REQUEST['action'] ?? '';

if ($action == 'ajax') {

    include 'pagination_ordenes.php';

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $per_page = 20;
    $adjacents = 4;
    $offset = ($page - 1) * $per_page;

    // Filtros
    $idHotel     = isset($_REQUEST["idHotel"]) ? mysqli_real_escape_string($con, $_REQUEST["idHotel"]) : '';
    $tipoEntrega = isset($_REQUEST["tipoEntrega"]) ? mysqli_real_escape_string($con, $_REQUEST["tipoEntrega"]) : '';
    $desde       = isset($_REQUEST["desde"]) ? mysqli_real_escape_string($con, $_REQUEST["desde"]) : '';
    $hasta       = isset($_REQUEST["hasta"]) ? mysqli_real_escape_string($con, $_REQUEST["hasta"]) : '';

    if (!empty($hasta) && empty($desde)) {
        $desde = $hasta;
    }

    $whereClauses = [];

    if (!empty($idHotel)) {
        $whereClauses[] = "ventas.idHotel = '$idHotel'";
    }

    if (!empty($tipoEntrega)) {
        $whereClauses[] = "ventas.tipoEntrega LIKE '%$tipoEntrega%'";
    }

    if (!empty($desde) && !empty($hasta)) {
        $whereClauses[] = "DATE(ventas.fecha) BETWEEN '$desde' AND '$hasta'";
    } elseif (!empty($desde)) {
        $whereClauses[] = "DATE(ventas.fecha) >= '$desde'";
    } elseif (!empty($hasta)) {
        $whereClauses[] = "DATE(ventas.fecha) <= '$hasta'";
    }

    $where = '';
    if (!empty($whereClauses)) {
        $where = "WHERE " . implode(" AND ", $whereClauses);
    }

    // Contar registros
    $count_query = mysqli_query($con, "
        SELECT COUNT(*) AS numrows
        FROM ventas
        INNER JOIN hotel ON ventas.idHotel = hotel.idHotel
        INNER JOIN tblusuario ON ventas.idUsuario = tblusuario.idUsuario
        $where
    ");

    $row_count = mysqli_fetch_assoc($count_query);
    $numrows = $row_count['numrows'] ?? 0;
    $total_pages = ceil($numrows / $per_page);
    $reload = 'index.php';

    // Consulta principal con cantidad de productos por orden
    $query = mysqli_query($con, "
        SELECT 
            ventas.id,
            ventas.fecha,
            ventas.estado,
            ventas.idUsuario,
            ventas.idHotel,
            ventas.tipoEntrega,
            hotel.nombreHotel,
            tblusuario.nombre,
            tblusuario.apellido,
            COALESCE(SUM(productos_ventas.cantidad), 0) AS total_productos
        FROM ventas
        INNER JOIN hotel 
            ON ventas.idHotel = hotel.idHotel
        INNER JOIN tblusuario 
            ON ventas.idUsuario = tblusuario.idUsuario
        LEFT JOIN productos_ventas 
            ON ventas.id = productos_ventas.idVenta
        $where
        GROUP BY 
            ventas.id,
            ventas.fecha,
            ventas.estado,
            ventas.idUsuario,
            ventas.idHotel,
            ventas.tipoEntrega,
            hotel.nombreHotel,
            tblusuario.nombre,
            tblusuario.apellido
        ORDER BY ventas.id DESC
        LIMIT $offset, $per_page
    ");

    if (mysqli_num_rows($query) > 0) {
?>
<style>
    .contenedor-ordenes {
        margin-top: 15px;
    }

    .tabla-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0,0,0,0.10);
        border: 1px solid #e9ecef;
    }

    .tabla-header {
        background: linear-gradient(135deg, #33a532, #238b2d);
        color: #fff;
        padding: 14px 18px;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .tabla-header .titulo {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
    }

    .tabla-header .total-registros {
        font-size: 13px;
        background: rgba(255,255,255,0.18);
        padding: 6px 12px;
        border-radius: 20px;
    }

    .tabla-ordenes {
        margin-bottom: 0;
    }

    .tabla-ordenes thead tr {
        background: #2f9e44;
        color: #fff;
    }

    .tabla-ordenes thead th {
        border: none !important;
        padding: 11px 8px;
        font-size: 13px;
        text-align: center;
        vertical-align: middle;
    }

    .tabla-ordenes tbody td {
        padding: 10px 8px;
        font-size: 13px;
        vertical-align: middle !important;
        text-align: center;
    }

    .tabla-ordenes tbody tr {
        transition: all 0.2s ease-in-out;
    }

    .tabla-ordenes tbody tr:hover {
        background: #f4fbf4;
    }

    .numero-orden {
        font-weight: bold;
        color: #198754;
    }

    .nombre-usuario {
        font-weight: 600;
        color: #212529;
    }

    .badge-estado {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        min-width: 95px;
    }

    .badge-pendiente {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffe69c;
    }

    .badge-entregado {
        background: #d1e7dd;
        color: #0f5132;
        border: 1px solid #badbcc;
    }

    .btn-accion {
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        margin: 2px;
    }

    .badge-productos {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e8f5e9;
        color: #1b5e20;
        border: 1px solid #c8e6c9;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 700;
        margin-left: 4px;
        vertical-align: middle;
    }

    .badge-productos i {
        font-size: 13px;
    }

    .acciones-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 4px;
    }

    .paginacion-box {
        padding: 15px 10px 18px 10px;
        background: #fff;
    }

    .sin-datos-box {
        margin-top: 20px;
    }
</style>

<div class="container-fluid contenedor-ordenes">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="tabla-card">
                
                <div class="tabla-header">
                    <div class="titulo">
                        <i class="bi bi-truck"></i> Listado de Órdenes
                    </div>
                    <div class="total-registros">
                        Total: <?php echo $numrows; ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover tabla-ordenes">
                        <thead>
                            <tr>
                                <th>N° Orden</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Hotel</th>
                                <th>Estado</th>
                                <th style="min-width: 260px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($query)) { 
                                $partesFecha = explode(' ', $row['fecha']);
                                $fecha = isset($partesFecha[0]) ? $partesFecha[0] : '';
                                $hora  = isset($partesFecha[1]) ? $partesFecha[1] : '';
                                $estado = isset($row['estado']) ? (int)$row['estado'] : 0;
                                $totalProductos = isset($row['total_productos']) ? (int)$row['total_productos'] : 0;
                            ?>
                            <tr>
                                <td>
                                    <span class="numero-orden">#<?php echo $row['id']; ?></span>
                                </td>

                                <td><?php echo date("d-m-Y", strtotime($fecha)); ?></td>

                                <td><?php echo $hora; ?></td>

                                <td><?php echo utf8_encode($row['nombreHotel']); ?></td>

                                <td>
                                    <?php if ($estado === 1) { ?>
                                        <span class="badge-estado badge-entregado">
                                            <i class="bi bi-check-circle"></i> Entregado
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge-estado badge-pendiente">
                                            <i class="bi bi-clock-history"></i> Pendiente
                                        </span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <div class="acciones-wrap">
                                        <a href="?c=producto&a=VerOrden&id=<?php echo $row['id']; ?>" 
                                           class="btn btn-primary btn-sm btn-accion"
                                           title="Ver orden">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>

                                        <span class="badge-productos" title="Cantidad total de productos en la orden">
                                            <i class="bi bi-box-seam"></i>
                                            <?php echo $totalProductos; ?>
                                        </span>

                                        <?php if ($estado === 0) { ?>
                                            <a href="?c=producto&a=MarcarEntregado&id=<?php echo $row['id']; ?>" 
                                               class="btn btn-success btn-sm btn-accion"
                                               title="Marcar como entregado"
                                               onclick="return confirm('¿Desea marcar esta orden como entregada?');">
                                                <i class="bi bi-check2-circle"></i>
                                            </a>
                                        <?php } ?>

                                        <a href="?c=producto&a=EliminarOrden&id=<?php echo $row['id']; ?>" 
                                           class="btn btn-danger btn-sm btn-accion"
                                           title="Eliminar orden"
                                           onclick="return confirm('¿Está seguro de que desea eliminar este registro?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="paginacion-box text-center">
                    <div style="margin-bottom:10px;">
                        <strong>Total de registros encontrados:</strong> <?php echo $numrows; ?>
                    </div>
                    <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
    } else {
?>
<div class="container sin-datos-box">
    <div class="alert alert-danger text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Aviso:</strong> No hay datos para mostrar.
    </div>
</div>
<?php
    }
}
?>