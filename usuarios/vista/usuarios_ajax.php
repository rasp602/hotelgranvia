<?php
include '../../bd/conexionLocal.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {

    include '../reportes/pagination_descripcion.php';

    $page       = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? (int)$_REQUEST['page'] : 1;
    $per_page   = 10;
    $adjacents  = 4;
    $offset     = ($page - 1) * $per_page;

    $buscar = isset($_REQUEST['buscar']) ? mysqli_real_escape_string($con, trim($_REQUEST['buscar'])) : '';

    $where = "";
    if ($buscar != "") {
        $where = " WHERE 
                    t.nombre   LIKE '%$buscar%' OR
                    t.apellido LIKE '%$buscar%' OR
                    t.rut      LIKE '%$buscar%' OR
                    u.usuario  LIKE '%$buscar%' OR
                    u.email    LIKE '%$buscar%'";
    }

    $count_query = mysqli_query($con, "SELECT COUNT(*) AS numrows
                                       FROM usuario u
                                       INNER JOIN tblusuario t ON t.idUsuario = u.idUsuario
                                       $where");

    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = 'index.php';

    $query = mysqli_query($con, "SELECT 
                                    u.id_user,
                                    u.email,
                                    u.password,
                                    u.nivel,
                                    u.idUsuario,
                                    u.usuario,
                                    t.rut,
                                    t.nombre,
                                    t.apellido,
                                    t.fechacrea,
                                    t.genero
                                FROM usuario u
                                INNER JOIN tblusuario t ON t.idUsuario = u.idUsuario
                                $where
                                ORDER BY t.idUsuario DESC
                                LIMIT $offset, $per_page");

    if (mysqli_num_rows($query) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle bg-white">
                <thead style="background: linear-gradient(135deg, #0d6efd, #0b5ed7); color: white;">
                    <tr>
                        <th>ID</th>
                        <th>Rut</th>
                        <th>Nombre completo</th>
                        <th>Fecha registro</th>
                        <th>Género</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Nivel</th>
                        <th width="140">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $row['idUsuario']; ?></td>
                            <td><?php echo htmlspecialchars($row['rut']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                            <td>
                                <?php
                                echo (!empty($row['fechacrea']) && $row['fechacrea'] != '0000-00-00')
                                    ? date("d-m-Y", strtotime($row['fechacrea']))
                                    : '';
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['genero']); ?></td>
                            <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php if ($row['nivel'] == 'A') { ?>
                                    <span class="badge badge-danger">Administrador</span>
                                <?php } else { ?>
                                    <span class="badge badge-primary">Usuario</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="?c=usuarios&a=Crud&idUsuario=<?php echo $row['idUsuario']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="?c=usuarios&a=Eliminar&idUsuario=<?php echo $row['idUsuario']; ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="alert alert-info mb-0">
                    <strong>Total de registros encontrados:</strong> <?php echo $numrows; ?>
                </div>
            </div>
            <div class="col-md-6 text-center text-md-right mt-2 mt-md-0">
                <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-warning text-center">
            <h5 class="mb-1"><i class="fa fa-exclamation-circle"></i> Sin resultados</h5>
            No hay usuarios para mostrar.
        </div>
        <?php
    }
}
?>