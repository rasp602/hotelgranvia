<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en PHP.
    include '../../bd/conexionLocal.php'; // Incluir el archivo de conexión

    $action = $_REQUEST['action'] ?? '';
    if ($action == 'ajax') {
        include 'pagination_ordenes.php'; // Incluir el archivo de paginación

        // Variables de paginación
        $page = $_REQUEST['page'] ?? 1;
        $per_page = 20; // Cantidad de registros por página
        $adjacents = 4; // Brecha entre páginas adyacentes
        $offset = ($page - 1) * $per_page;

// Parámetros de filtro
// Parámetros de filtro
// Parámetros de filtro

$tipoPedido = $_REQUEST["tipoPedido"] ?? '';
$desde = $_REQUEST["desde"] ?? '';
$hasta = $_REQUEST["hasta"] ?? '';

// Ajuste de fechas si solo se selecciona "hasta"
if (!empty($hasta) && empty($desde)) {
    $desde = $hasta;
}

// Construcción del WHERE dinámico
$whereClauses = [];

if (!empty($tipoPedido)) {
    $whereClauses[] = "ventas_pedidos.tipoPedido LIKE '%$tipoPedido%'";
}
if (!empty($desde) && !empty($hasta)) {
    $whereClauses[] = "DATE(ventas_pedidos.fecha) BETWEEN '$desde' AND '$hasta'";
} elseif (!empty($desde)) {
    $whereClauses[] = "DATE(ventas_pedidos.fecha) >= '$desde'";
} elseif (!empty($hasta)) {
    $whereClauses[] = "DATE(ventas_pedidos.fecha) <= '$hasta'";
}

// Unión de las cláusulas WHERE
$where = '';
if (!empty($whereClauses)) {
    $where = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Consulta para contar el total de registros
$count_query1 = mysqli_query($con, "SELECT count(*) AS numrows1 FROM ventas_pedidos $where");
$numrows1 = mysqli_fetch_array($count_query1)['numrows1'] ?? 0;
$total_pages = ceil($numrows1 / $per_page);
$reload = 'index.php';

// Consulta principal para recuperar los datos
$query = mysqli_query($con, "
    SELECT 
        ventas_pedidos.idPedido, ventas_pedidos.fecha, ventas_pedidos.idUsuario,ventas_pedidos.tipoPedido,       
        tblusuario.nombre, tblusuario.apellido,ventas_pedidos.hora
    FROM ventas_pedidos
    INNER JOIN tblusuario ON ventas_pedidos.idUsuario = tblusuario.idUsuario
    $where
    ORDER BY ventas_pedidos.idPedido DESC
    LIMIT $offset, $per_page
");



        // Mostrar los resultados
        if (mysqli_num_rows($query) > 0) {
?>
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="table-responsive shadow-sm">
                <table class="table table-sm table-striped table-bordered table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">N° Orden</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                            
                            <th scope="col">Usuario</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($query)) { 
                            list($fecha, $hora) = explode(' ', $row['fecha']); ?>
                            <tr>
                                <td><?php echo utf8_encode($row['idPedido']); ?></td>
                                <td><?php echo utf8_encode($fecha); ?></td>
                                <td><?php echo utf8_encode($row['hora']); ?></td>
                             
                                <td><?php echo utf8_encode($row['nombre'] . ' ' . $row['apellido']); ?></td>
                                <td>
                                    <a href="?c=producto&a=VerPedido&idPedido=<?php echo $row['idPedido']; ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                    <a href="?c=producto&a=EliminarPedido&idPedido=<?php echo $row['idPedido']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Está seguro de que desea eliminar este registro?');">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="text-center my-3">
                    <strong>Total de Registros encontrados:</strong> <?php echo $numrows1; ?>
                </div>
                <div class="d-flex justify-content-center">
                    <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php } else { ?>
    <div class="container mt-4">
        <div class="alert alert-danger text-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Aviso!</strong> No hay datos para mostrar.
        </div>
    </div>
<?php
        }
    }
?>
