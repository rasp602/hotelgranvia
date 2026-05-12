<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en PHP.
    include '../../bd/conexionLocal.php'; // Incluir el archivo de conexión

    $action = $_REQUEST['action'] ?? '';
    if ($action == 'ajax') {
        include 'pagination_ordenes_preparadas.php'; // Incluir el archivo de paginación

        // Variables de paginación
        $page = $_REQUEST['page'] ?? 1;
        $per_page = 10; // Cantidad de registros por página
        $adjacents = 4; // Brecha entre páginas adyacentes
        $offset = ($page - 1) * $per_page;

        // Parámetros de filtro
        $idHotel = $_REQUEST["idHotel"] ?? '';
        $tipoEntrega = $_REQUEST["tipoEntrega"] ?? '';
        $desde = $_REQUEST["desde"] ?? '';
        $hasta = $_REQUEST["hasta"] ?? '';
        $fecha1 = '3000-01-01';

        // Construcción del WHERE dinámico
        $whereClauses = [];
        if (!empty($idHotel)) {
            $whereClauses[] = "ventas_preparada.idHotel = '$idHotel'";
        }
        if (!empty($tipoEntrega)) {
            $whereClauses[] = "ventas_preparada.tipoEntrega LIKE '%$tipoEntrega%'";
        }
        if (!empty($desde)) {
            $hasta = !empty($hasta) ? $hasta : $fecha1;
            $whereClauses[] = "ventas_preparada.fecha BETWEEN '$desde' AND '$hasta'";
        }

        // Unión de las cláusulas WHERE
        $where = '';
        if (!empty($whereClauses)) {
            $where = 'WHERE ' . implode(' AND ', $whereClauses);
        }

        // Consulta para contar el total de registros
        $count_query1 = mysqli_query($con, "SELECT count(*) AS numrows1 FROM ventas_preparada $where");
        $numrows1 = mysqli_fetch_array($count_query1)['numrows1'] ?? 0;
        $total_pages = ceil($numrows1 / $per_page);
        $reload = 'index.php';

        // Consulta principal para recuperar los datos
        $query = mysqli_query($con, "
            SELECT 
                ventas_preparada.id, ventas_preparada.fecha, ventas_preparada.idUsuario, ventas_preparada.idHotel, ventas_preparada.tipoEntrega,
                hotel.nombreHotel, 
                tblusuario.nombre, tblusuario.apellido
            FROM ventas_preparada
            INNER JOIN hotel ON ventas_preparada.idHotel = hotel.idHotel
            INNER JOIN tblusuario ON ventas_preparada.idUsuario = tblusuario.idUsuario
            $where
            ORDER BY ventas_preparada.id
            LIMIT $offset, $per_page
        ");

        // Mostrar los resultados
        if (mysqli_num_rows($query) > 0) {
?>
<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="table-responsive shadow-sm">
                <table class="table table-striped table-bordered table-hover text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>N° Orden Preparada</th>
                            <th>Fecha</th>
                            <th>Hotel</th>
                            <th>Tipo Entrega</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($query)) { ?>
                            <tr>
                                <td><?php echo utf8_encode($row['id']); ?></td>
                                <td><?php echo utf8_encode($row['fecha']); ?></td>
                                <td><?php echo utf8_encode($row['nombreHotel']); ?></td>
                                <td>
                                    <?php echo $row['tipoEntrega'] == 'P' || $row['tipoEntrega'] == 'E' 
                                        ? '<span class="badge bg-success">EMPAQUETADO</span>' 
                                        : '<span class="badge bg-danger">LONCHERA</span>'; ?>
                                </td>
                                <td><?php echo utf8_encode($row['nombre'] . ' ' . $row['apellido']); ?></td>
                                <td>
                                    <a href="?c=producto&a=VerOrdenPreparada&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                    <a href="?c=producto&a=EliminarOrdenPreparadas&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
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
            </div>
        </div>
    </div>
</div>

            <div class="table-pagination pull" align="center">
                <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
            </div>
<?php
        } else {
?>
            <div class="container"><br>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>Aviso!!!</h4> No hay datos para mostrar..!
                </div>
            </div>
<?php
        }
    }
?>
