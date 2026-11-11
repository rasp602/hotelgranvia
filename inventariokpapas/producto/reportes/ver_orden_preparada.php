<?php
error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en PHP.
include '../../bd/conexionLocal.php'; // Incluir el archivo de conexión

$action = $_REQUEST['action'] ?? '';
if ($action == 'ajax') {
    include 'pagination_comidaExtra.php'; // Incluir el archivo de paginación

    // Variables de paginación
    $page = $_REQUEST['page'] ?? 1;
    $per_page = 10; // Cantidad de registros por página
    $adjacents = 4; // Brecha entre páginas adyacentes
    $offset = ($page - 1) * $per_page;

    // Parámetros de filtro
    $id = $_REQUEST["id"];

    // Consulta para contar el total de registros
    $count_query1 = mysqli_query($con, "SELECT count(*) AS numrows1 FROM ventas where id = '$id'");
    $numrows1 = mysqli_fetch_array($count_query1)['numrows1'] ?? 0;
    $total_pages = ceil($numrows1 / $per_page);
    $reload = 'index.php';

    // Consulta principal para recuperar los datos
    $query = mysqli_query($con, "
       SELECT productos_ventas.id, productos_ventas.cantidad, productos_ventas.precio, productos_ventas.idProducto, productos_ventas.idVenta,
       producto.idProducto, producto.nombreProducto, producto.codigoBarra, producto.idTipoProducto,
       tipoproducto.idTipoProducto, tipoproducto.nombreTipoProducto,
       ventas.id, ventas.fecha, ventas.total, ventas.idUsuario, ventas.idHotel, ventas.tipoEntrega, ventas.gananciaG,
       tblusuario.idUsuario, tblusuario.nombre, tblusuario.apellido
       FROM `productos_ventas`
       INNER JOIN producto ON productos_ventas.idProducto = producto.idProducto
       INNER JOIN tipoproducto ON producto.idTipoProducto = tipoproducto.idTipoProducto
       INNER JOIN ventas ON productos_ventas.idVenta = ventas.id
       INNER JOIN tblusuario ON ventas.idUsuario = tblusuario.idUsuario
       WHERE ventas.id = $id
       LIMIT $offset, $per_page
    ");

    // Mostrar los resultados
    if (mysqli_num_rows($query) > 0) {
?>
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <!-- Encabezado de la orden -->
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h4 class="text-center"><i class="bi bi-receipt"></i> Orden de Entrega</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6><i class="bi bi-person-circle"></i> Cliente:</h6>
                                    <p><?php echo utf8_encode($row['nombre']) . " " . utf8_encode($row['apellido']); ?></p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h6><i class="bi bi-calendar-check"></i> Fecha de la Orden:</h6>
                                    <p><?php echo date("d/m/Y", strtotime($row['fecha'])); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Cantidad</th>
                                                <th>Producto</th>
                                                <th class="text-right">Precio Unitario</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            $total_order = 0;
                                            while ($row = mysqli_fetch_array($query)) {
                                                $total_product = $row['cantidad'] * $row['precio'];
                                                $total_order += $total_product;
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $counter++; ?></td>
                                                    <td class="text-center"><?php echo utf8_encode($row['cantidad']); ?></td>
                                                    <td><?php echo utf8_encode($row['nombreProducto']); ?></td>
                                                    <td class="text-right"><?php echo number_format($row['precio'], 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($total_product, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">Total Orden:</th>
                                                <th class="text-right"><?php echo number_format($total_order, 2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary"><i class="bi bi-printer"></i> Imprimir Orden</button>
                                    <button class="btn btn-secondary"><i class="bi bi-envelope"></i> Enviar por Correo</button>
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
        <div class="container mt-4">
            <div class="alert alert-danger">
                <h4><i class="bi bi-exclamation-triangle"></i> Aviso!!!</h4>
                No hay datos para mostrar..!
            </div>
        </div>
<?php
    }
}
?>
