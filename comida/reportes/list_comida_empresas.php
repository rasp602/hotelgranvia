<?php
error_reporting(E_ERROR | E_PARSE); // Oculta errores y warnings

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    include 'pagination_comidas.php'; // archivo de paginación

    // Variables de paginación
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 20;
    $adjacents = 4;
    $offset = ($page - 1) * $per_page;

    // Recuperar variables
    $idHotel = $_REQUEST["idHotel"];
    $idHabitacion = $_REQUEST["idHabitacion"];
    $tipoComida = $_REQUEST["tipoComida"];
    $idPersona = $_REQUEST["idPersona"];
    $idEmpresa = $_REQUEST["idEmpresa"];
    $desde = $_REQUEST["desde"];
    $hasta = $_REQUEST["hasta"];

    // ✅ Validar primero que se haya enviado un hotel válido
    if (!$idHotel || !in_array($idHotel, ['1', '2', '3', '4', '25'])) {
        echo "<div class='container'><br><div class='alert alert-danger'>Debe seleccionar un hotel válido antes de continuar.</div></div>";
        exit;
    }

    // ✅ Incluir la conexión según el hotel
    switch ($idHotel) {
        case '1':
        case '25': // Usa misma conexión que 1
            include '../../bd/conexionLocal.php';
            break;
        case '2':
            include '../../bd/conexionLocalh2.php';
            break;
        case '3':
            include '../../bd/conexionLocalh3.php';
            break;
        case '4':
            include '../../bd/conexionLocalh4.php';
            break;
    }

    // Inicializar filtros
    $where = "WHERE 1=1"; // condición siempre verdadera para facilitar el encadenamiento

    // Aplicar filtros
    if (!empty($idPersona)) {
        $nombre = "";
        $apellido = "";
        if (strpos($idPersona, ' ') !== false) {
            list($nombre, $apellido) = explode(" ", $idPersona, 2);
            $where .= " AND persona.nombresPersona LIKE '%$nombre%' AND persona.apellidoPersona1 LIKE '%$apellido%'";
        } else {
            $where .= " AND persona.nombresPersona LIKE '%$idPersona%'";
        }
    }

    if (!empty($idHabitacion)) {
        $where .= " AND hospedaje.idHabitacion = '$idHabitacion'";
    }

    if (!empty($idEmpresa)) {
        $where .= " AND empresa.idEmpresa = '$idEmpresa'";
    }

    if (!empty($tipoComida)) {
        $where .= " AND comida.tipoComida LIKE '%$tipoComida%'";
    }

    if (!empty($desde) && !empty($hasta)) {
        $where .= " AND comida.fechaComida BETWEEN '$desde' AND '$hasta'";
    } elseif (!empty($desde)) {
        $where .= " AND comida.fechaComida >= '$desde'";
    } elseif (!empty($hasta)) {
        $where .= " AND comida.fechaComida <= '$hasta'";
    }

    // Siempre se incluye el hotel ya que es obligatorio
    $where .= " AND hospedaje.idHotel = '$idHotel'";

    // Obtener total de registros
    $count_query1 = mysqli_query($con, "SELECT COUNT(*) AS numrows1
        FROM comida 
        INNER JOIN persona ON comida.idPersona = persona.idPersona
        INNER JOIN empresa ON persona.idEmpresa = empresa.idEmpresa
        INNER JOIN hospedaje ON comida.idHospedaje = hospedaje.idHospedaje        
        INNER JOIN hotel ON hospedaje.idHotel = hotel.idHotel
        $where");

    $numrows1 = 0;
    if ($row = mysqli_fetch_array($count_query1)) {
        $numrows1 = $row['numrows1'];
    }

    $total_pages = ceil($numrows1 / $per_page);
    $reload = 'index.php';

    // Consulta principal
    $query = mysqli_query($con, "SELECT 
        comida.idComida, comida.idPersona, comida.tipoComida, comida.fechaComida, comida.horaComida, comida.idHospedaje,
        persona.idPersona, persona.rutPersona, persona.nombresPersona, persona.apellidoPersona1, persona.apellidoPersona2, persona.qrPersona, persona.idEmpresa,
        empresa.idEmpresa, empresa.nombreEmpresa,
        hospedaje.idHospedaje, hospedaje.idHabitacion, hospedaje.idPersona, hospedaje.idHotel,
        hotel.idHotel, hotel.nombreHotel,
        habitacion.idHabitacion, habitacion.nHabitacion, habitacion.idHotel
        FROM comida 
        INNER JOIN persona ON comida.idPersona = persona.idPersona
        INNER JOIN empresa ON persona.idEmpresa = empresa.idEmpresa
        INNER JOIN hospedaje ON comida.idHospedaje = hospedaje.idHospedaje        
        INNER JOIN hotel ON hospedaje.idHotel = hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion = habitacion.idHabitacion
        $where
        ORDER BY comida.idComida, comida.tipoComida, comida.horaComida 
        LIMIT $offset, $per_page");

    if (mysqli_num_rows($query) > 0) {
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
                        <thead>
                            <tr class="bg-primary">
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Persona</th>
                                <th>Hotel</th>
                                <th>Habitación</th>
                                <th>Empresa</th>
                                <th>Tipo Comida</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_array($query)) { ?>
                            <tr>
                                <td><?php echo utf8_encode($row['fechaComida']); ?></td>
                                <td><?php echo utf8_encode($row['horaComida']); ?></td>
                                <td><?php echo utf8_encode($row['nombresPersona'] . " " . $row['apellidoPersona1']); ?></td>
                                <td><?php echo utf8_encode($row['nombreHotel']); ?></td>
                                <td><?php echo utf8_encode($row['nHabitacion']); ?></td>
                                <td><?php echo utf8_encode($row['nombreEmpresa']); ?></td>
                                <td><?php echo utf8_encode($row['tipoComida']); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php echo "<div align='center'><b>Total de Registros encontrados:</b> $numrows1</div>"; ?>
            </div>
        </div>

        <div class="table-pagination pull" align="center">
            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?><br><br>
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
