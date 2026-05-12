<?php
error_reporting(E_ERROR | E_PARSE);

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {
    include 'pagination_producto.php';

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 30;
    $adjacents = 4;
    $offset = ($page - 1) * $per_page;

    include '../../bd/conexionLocal.php';

    $idHotel        = isset($_REQUEST["idHotel"]) ? $_REQUEST["idHotel"] : "";
    $codigoBarra    = isset($_REQUEST["codigoBarra"]) ? trim($_REQUEST["codigoBarra"]) : "";
    $idTipoProducto = isset($_REQUEST["idTipoProducto"]) ? trim($_REQUEST["idTipoProducto"]) : "";
    $nombreProducto = isset($_REQUEST["nombreProducto"]) ? trim($_REQUEST["nombreProducto"]) : "";
    $desde          = isset($_REQUEST["desde"]) ? trim($_REQUEST["desde"]) : "";
    $hasta          = isset($_REQUEST["hasta"]) ? trim($_REQUEST["hasta"]) : "";

    $fecha1 = '3000-01-01';

    $filtros = array();

    if ($idTipoProducto != "") {
        $filtros[] = "tipoproducto.idTipoProducto LIKE '%" . mysqli_real_escape_string($con, $idTipoProducto) . "%'";
    }

    if ($nombreProducto != "") {
        $filtros[] = "producto.nombreProducto LIKE '%" . mysqli_real_escape_string($con, $nombreProducto) . "%'";
    }

    if ($codigoBarra != "") {
        $filtros[] = "producto.codigoBarra LIKE '%" . mysqli_real_escape_string($con, $codigoBarra) . "%'";
    }

    if ($desde != "" && $hasta != "") {
        $filtros[] = "producto.fechaIngreso BETWEEN '" . mysqli_real_escape_string($con, $desde) . "' AND '" . mysqli_real_escape_string($con, $hasta) . "'";
    } elseif ($desde != "" && $hasta == "") {
        $filtros[] = "producto.fechaIngreso BETWEEN '" . mysqli_real_escape_string($con, $desde) . "' AND '" . $fecha1 . "'";
    }

    $where = "";
    if (!empty($filtros)) {
        $where = " WHERE " . implode(" AND ", $filtros);
    }

    $count_query1 = mysqli_query($con, "
        SELECT COUNT(*) AS numrows1
        FROM producto
        INNER JOIN tipoproducto 
            ON producto.idTipoProducto = tipoproducto.idTipoProducto
        $where and producto.estado = 1
    ");

    $numrows1 = 0;
    if ($row = mysqli_fetch_array($count_query1)) {
        $numrows1 = $row['numrows1'];
    }

    $total_pages = ceil($numrows1 / $per_page);
    $reload = 'index.php';

    $query = mysqli_query($con, "
        SELECT 
            producto.idProducto,
            producto.nombreProducto,
            producto.precioProducto,
            producto.codigoBarra,
            producto.existenciaProducto,
            producto.fechaIngreso,
            producto.idTipoProducto,
            producto.imagenProducto,
            tipoproducto.nombreTipoProducto
        FROM producto
        INNER JOIN tipoproducto 
            ON producto.idTipoProducto = tipoproducto.idTipoProducto
        $where and producto.estado = 1
        ORDER BY producto.idProducto DESC
        LIMIT $offset, $per_page
    ");

    if (mysqli_num_rows($query) > 0) {
?>
<style>
    .productos-wrapper {
        margin-top: 20px;
        margin-bottom: 25px;
    }

    .productos-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .productos-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        padding: 20px 18px;
        text-align: center;
    }

    .productos-header h3 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
    }

    .productos-header p {
        margin: 8px 0 0 0;
        font-size: 14px;
        opacity: .95;
    }

    .productos-body {
        background: #f8fafc;
        padding: 20px;
    }

    .resumen-box {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 18px;
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        color: #344054;
    }

    .tabla-box {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 14px;
        overflow: hidden;
    }

    .tabla-box .table {
        margin-bottom: 0;
    }

    .tabla-box thead tr {
        background: #0d6efd;
        color: #fff;
    }

    .tabla-box thead th {
        border-bottom: none !important;
        vertical-align: middle !important;
        text-align: center;
    }

    .tabla-box tbody td {
        vertical-align: middle !important;
    }

    .tabla-box tbody tr:hover {
        background: #f4f8ff;
    }

    .producto-img-mini {
        width: 58px;
        height: 58px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #dee2e6;
        background: #fff;
    }

    .nombre-producto {
        font-weight: 700;
        color: #1d2939;
    }

    .tipo-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        background: #e8f1ff;
        color: #0d6efd;
        font-size: 12px;
        font-weight: 700;
    }

    .stock-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .stock-ok {
        background: #e9f9ee;
        color: #198754;
    }

    .stock-low {
        background: #fdecec;
        color: #dc3545;
    }

    .acciones-btns {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .acciones-btns .btn {
        border-radius: 10px;
        font-weight: 600;
    }

    .paginacion-box {
        padding: 18px 15px;
        text-align: center;
        background: #fff;
        border-top: 1px solid #eef2f6;
    }

    .mobile-cards {
        display: none;
    }

    .producto-mobile-card {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 12px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.04);
    }

    .producto-mobile-top {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 10px;
    }

    .producto-mobile-title {
        font-size: 16px;
        font-weight: 700;
        color: #1d2939;
        margin-bottom: 4px;
    }

    .producto-mobile-line {
        font-size: 14px;
        color: #475467;
        margin-bottom: 6px;
    }

    .producto-mobile-line strong {
        color: #0d6efd;
    }

    .sin-datos {
        background: #fff;
        border: 1px dashed #d0d5dd;
        border-radius: 14px;
        padding: 25px;
        text-align: center;
        color: #667085;
        font-size: 16px;
    }

    @media (max-width: 767px) {
        .productos-wrapper {
            margin-top: 10px;
        }

        .productos-header h3 {
            font-size: 22px;
        }

        .productos-body {
            padding: 14px;
        }

        .desktop-table {
            display: none;
        }

        .mobile-cards {
            display: block;
        }
    }
</style>

<div class="container-fluid productos-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-12">
            <div class="productos-card">

                <div class="productos-header">
                    <h3><i class="bi bi-box-seam"></i> Listado de Productos</h3>
                    <p>Consulta, edita o elimina los productos registrados</p>
                </div>

                <div class="productos-body">

                    <div class="resumen-box">
                        Total de registros encontrados: <strong><?php echo $numrows1; ?></strong>
                    </div>

                    <!-- TABLA DESKTOP -->
                    <div class="tabla-box desktop-table">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 90px;">Imagen</th>
                                        <th style="width: 100px;">Tipo Producto</th>
                                        <th style="width: 80px;">Código</th>
                                        <th style="width: 250px;">Nombre Producto</th>
                                        <th style="width: 110px;">Precio</th>
                                        <th style="width: 110px;">Existencia</th>
                                        <th style="width: 170px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_array($query)) { 
                                        $imagen = (!empty($row['imagenProducto']))
                                            ? 'img/productos/' . $row['imagenProducto']
                                            : 'img/no-image.png';

                                        $stockClass = ((int)$row['existenciaProducto'] > 0) ? 'stock-ok' : 'stock-low';
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <img 
                                                    src="<?php echo $imagen; ?>" 
                                                    class="producto-img-mini"
                                                    onerror="this.onerror=null;this.src='img/no-image.png';"
                                                    alt="Producto"
                                                >
                                            </td>
                                            <td class="text-center">
                                                <span class="tipo-badge">
                                                    <?php echo utf8_encode($row['nombreTipoProducto']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php echo utf8_encode($row['codigoBarra']); ?>
                                            </td>
                                            <td>
                                                <span class="nombre-producto">
                                                    <?php echo utf8_encode($row['nombreProducto']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                $<?php echo number_format($row['precioProducto'], 0, ',', '.'); ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="stock-badge <?php echo $stockClass; ?>">
                                                    <?php echo utf8_encode($row['existenciaProducto']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="acciones-btns">
                                                    <a href="?c=producto&a=Crud3&idProducto=<?php echo $row['idProducto']; ?>" 
                                                       class="btn btn-info btn-sm">
                                                        <i class="bi bi-pencil"></i> Editar
                                                    </a>
                                                    <a href="?c=producto&a=Eliminar&idProducto=<?php echo $row['idProducto']; ?>"
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('¿Seguro de eliminar este registro?');">
                                                        <i class="bi bi-trash"></i> Eliminar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="paginacion-box">
                            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </div>
                    </div>

                    <!-- TARJETAS MOBILE -->
                    <div class="mobile-cards">
                        <?php
                        mysqli_data_seek($query, 0);
                        while($row = mysqli_fetch_array($query)) {
                            $imagen = (!empty($row['imagenProducto']))
                                ? 'img/productos/' . $row['imagenProducto']
                                : 'img/no-image.png';

                            $stockClass = ((int)$row['existenciaProducto'] > 0) ? 'stock-ok' : 'stock-low';
                        ?>
                            <div class="producto-mobile-card">
                                <div class="producto-mobile-top">
                                    <img 
                                        src="<?php echo $imagen; ?>" 
                                        class="producto-img-mini"
                                        onerror="this.onerror=null;this.src='img/no-image.png';"
                                        alt="Producto"
                                    >

                                    <div>
                                        <div class="producto-mobile-title">
                                            <?php echo utf8_encode($row['nombreProducto']); ?>
                                        </div>
                                        <div class="producto-mobile-line">
                                            <span class="tipo-badge">
                                                <?php echo utf8_encode($row['nombreTipoProducto']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="producto-mobile-line">
                                    <strong>Código:</strong>
                                    <?php echo utf8_encode($row['codigoBarra']); ?>
                                </div>

                                <div class="producto-mobile-line">
                                    <strong>Precio:</strong>
                                    $<?php echo number_format($row['precioProducto'], 0, ',', '.'); ?>
                                </div>

                                <div class="producto-mobile-line">
                                    <strong>Existencia:</strong>
                                    <span class="stock-badge <?php echo $stockClass; ?>">
                                        <?php echo utf8_encode($row['existenciaProducto']); ?>
                                    </span>
                                </div>

                                <div class="acciones-btns" style="margin-top:10px;">
                                    <a href="?c=producto&a=Crud3&idProducto=<?php echo $row['idProducto']; ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <a href="?c=producto&a=Eliminar&idProducto=<?php echo $row['idProducto']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Seguro de eliminar este registro?');">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="paginacion-box" style="margin-top: 10px; border-radius: 14px;">
                            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
    } else {
?>
    <div class="container-fluid productos-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="sin-datos">
                    <i class="bi bi-exclamation-circle" style="font-size: 28px;"></i><br><br>
                    No hay datos para mostrar.
                </div>
            </div>
        </div>
    </div>
<?php
    }
}
?>