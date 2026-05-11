<?php error_reporting(E_ERROR | E_PARSE); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<?php
include '../../bd/conexion.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {

    include 'pagination_tipoA.php';

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 20;
    $adjacents = 4;
    $offset = ($page - 1) * $per_page;

    $rutTrabajador = isset($_REQUEST["rutTrabajador"]) ? mysqli_real_escape_string($con, $_REQUEST["rutTrabajador"]) : "";
    $nombreTrabajador = isset($_REQUEST["nombreTrabajador"]) ? mysqli_real_escape_string($con, $_REQUEST["nombreTrabajador"]) : "";
    $genero = isset($_REQUEST["genero"]) ? mysqli_real_escape_string($con, $_REQUEST["genero"]) : "";
    $estado = isset($_REQUEST["estado"]) ? mysqli_real_escape_string($con, $_REQUEST["estado"]) : "";
    $desde = isset($_REQUEST["desde"]) ? mysqli_real_escape_string($con, $_REQUEST["desde"]) : "";
    $hasta = isset($_REQUEST["hasta"]) ? mysqli_real_escape_string($con, $_REQUEST["hasta"]) : "";
    $idHotel = isset($_REQUEST["idHotel"]) ? mysqli_real_escape_string($con, $_REQUEST["idHotel"]) : "";

    $conditions = array();

    if ($rutTrabajador != "") {
        $conditions[] = "trabajador.rutTrabajador LIKE '%$rutTrabajador%'";
    }

    if ($nombreTrabajador != "") {
        $conditions[] = "(trabajador.nombreTrabajador LIKE '%$nombreTrabajador%' 
                        OR trabajador.apellidoTrabajador1 LIKE '%$nombreTrabajador%' 
                        OR trabajador.apellidoTrabajador2 LIKE '%$nombreTrabajador%' 
                        OR trabajador.rutTrabajador LIKE '%$nombreTrabajador%')";
    }

    if ($idHotel != "") {
        $conditions[] = "hotel.idHotel = '$idHotel'";
    }

    if ($estado != "") {
        $conditions[] = "trabajador.estado = '$estado'";
    }

    if ($genero != "") {
        $conditions[] = "trabajador.genero = '$genero'";
    }

    if ($desde != "" && $hasta == "") {
        $conditions[] = "trabajador.fechaIngreso >= '$desde'";
    }

    if ($desde != "" && $hasta != "") {
        $conditions[] = "trabajador.fechaIngreso BETWEEN '$desde' AND '$hasta'";
    }

    $where = "";

    if (count($conditions) > 0) {
        $where = "WHERE " . implode(" AND ", $conditions);
    }

    $count_query1 = mysqli_query($con, "SELECT COUNT(*) AS numrows1
        FROM trabajador
        INNER JOIN hotel ON trabajador.idHotel = hotel.idHotel
        $where
    ");

    if ($row = mysqli_fetch_array($count_query1)) {
        $numrows1 = $row['numrows1'];
    } else {
        $numrows1 = 0;
    }

    $total_pages = ceil($numrows1 / $per_page);
    $reload = 'index.php';

    $query = mysqli_query($con, "SELECT 
            trabajador.idTrabajador,
            trabajador.rutTrabajador,
            trabajador.nombreTrabajador,
            trabajador.apellidoTrabajador1,
            trabajador.apellidoTrabajador2,
            trabajador.genero,
            trabajador.fechaCreado,
            trabajador.horaCreado,
            trabajador.fotoTrabajador,
            trabajador.qrTrabajador,
            trabajador.idHotel,
            trabajador.estado,
            trabajador.fechaIngreso,
            trabajador.jornada,
            trabajador.labor,
            trabajador.diasTrabajo,
            trabajador.sueldo,
            hotel.nombreHotel,

            IFNULL((
                SELECT 
                    (CASE WHEN fichaPersonal IS NOT NULL AND fichaPersonal != '' THEN 1 ELSE 0 END) +
                    (CASE WHEN curriculum IS NOT NULL AND curriculum != '' THEN 1 ELSE 0 END) +
                    (CASE WHEN carnet IS NOT NULL AND carnet != '' THEN 1 ELSE 0 END) +
                    (CASE WHEN certificadoAfp IS NOT NULL AND certificadoAfp != '' THEN 1 ELSE 0 END) +
                    (CASE WHEN fonasa IS NOT NULL AND fonasa != '' THEN 1 ELSE 0 END) +
                    (CASE WHEN ultimoFiniquito IS NOT NULL AND ultimoFiniquito != '' THEN 1 ELSE 0 END)
                FROM documentos_trabajador 
                WHERE documentos_trabajador.idTrabajador = trabajador.idTrabajador
                LIMIT 1
            ), 0) AS cantDocs

        FROM trabajador 
        INNER JOIN hotel ON trabajador.idHotel = hotel.idHotel
        $where 
        ORDER BY hotel.idHotel, trabajador.labor 
        LIMIT $offset, $per_page
    ");

    if (mysqli_num_rows($query) > 0) {
?>

<div class="container-fluid">
    <div class="row">
        <div class="table-responsive">

            <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
                <thead>
                    <tr class="bg-primary">
                        <th class="contenidoTabla">R.u.t</th>
                        <th class="contenidoTabla">Nombre</th>
                        <th class="contenidoTabla">Apellido P</th>
                        <th class="contenidoTabla">Apellido M</th>
                        <th class="contenidoTabla">Fecha Ingreso</th>
                        <th class="contenidoTabla">Jornada</th>
                        <th class="contenidoTabla">Labor</th>
                        <th class="contenidoTabla">Hotel</th>
                        <th class="contenidoTabla">Nuevo Qr</th>
                        <th class="contenidoTabla">Estado</th>
                        <th class="contenidoTabla">C.Qr</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($row = mysqli_fetch_array($query)) {

                    $newDate = date("d-m-Y", strtotime($row['fechaIngreso']));
                    $cantDocs = intval($row['cantDocs']);
                    $totalDocs = 6;

                    if ($cantDocs == 6) {
                        $colorDocs = "success";
                    } elseif ($cantDocs > 0) {
                        $colorDocs = "warning";
                    } else {
                        $colorDocs = "danger";
                    }
                ?>

                    <tr>
                        <td class="contenidoTabla"><?php echo utf8_encode($row['rutTrabajador']); ?></td>
                        <td class="contenidoTabla"><?php echo utf8_encode($row['nombreTrabajador']); ?></td>
                        <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoTrabajador1']); ?></td>
                        <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoTrabajador2']); ?></td>
                        <td class="contenidoTabla"><?php echo utf8_encode($newDate); ?></td>

                        <td class="contenidoTabla">
                            <?php
                            if ($row['jornada'] == "1") echo "8:00-16:00";
                            if ($row['jornada'] == "2") echo "8:00-17:00";
                            if ($row['jornada'] == "3") echo "14:00-22:00";
                            if ($row['jornada'] == "4") echo "00:00-8:00";
                            if ($row['jornada'] == "5") echo "15:00-23:00";
                            if ($row['jornada'] == "6") echo "8:00-18:00";
                            if ($row['jornada'] == "7") echo "8:00-22:00";
                            if ($row['jornada'] == "8") echo "22:00-08:00";
                            if ($row['jornada'] == "9") echo "06:00-18:00";
                            if ($row['jornada'] == "10") echo "7x7";
                            if ($row['jornada'] == "11") echo "2:00-10:00";
                            if ($row['jornada'] == "12") echo "08:00-20:00";
                            if ($row['jornada'] == "13") echo "10:00-22:00";
                            if ($row['jornada'] == "14") echo "16:00-1:00";
                            if ($row['jornada'] == "15") echo "17:00-2:00";
                            if ($row['jornada'] == "16") echo "15:00-1:00";
                            if ($row['jornada'] == "17") echo "10:00-2:00 (L)";
                            ?>
                        </td>

                        <td class="contenidoTabla"><?php echo utf8_encode($row['labor']); ?></td>
                        <td class="contenidoTabla"><?php echo utf8_encode($row['nombreHotel']); ?></td>
                        <td class="contenidoTabla"><?php echo utf8_encode($row['qrTrabajador']); ?></td>
                        <td class="contenidoTabla"><?php echo utf8_encode($row['estado']); ?></td>

                        <td class="contenidoTabla">
                            <a href="?c=trabajador&a=crud2&idTrabajador=<?php echo $row['idTrabajador']; ?>">
                                <i class="fa fa-qrcode"></i>
                            </a>
                        </td>

                        <td class="contenidoTabla">

                            <a href="?c=trabajador&a=Descanso&idTrabajador=<?php echo $row['idTrabajador']; ?>">
                                <img src="img/descanso.png" width="30px" height="30px">
                            </a>



                            <a href="?c=trabajador&a=Crud1&idTrabajador=<?php echo $row['idTrabajador']; ?>">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');"
                               href="?c=trabajador&a=Eliminar&idTrabajador=<?php echo $row['idTrabajador']; ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                            
                            <a href="?c=trabajador&a=Documentos&idTrabajador=<?php echo $row['idTrabajador']; ?>"
                               title="Documentos cargados: <?php echo $cantDocs; ?> de <?php echo $totalDocs; ?>"
                               class="btn btn-<?php echo $colorDocs; ?> btn-xs">
                                <i class="fa fa-folder-open"></i>
                                Docs <?php echo $cantDocs; ?>/<?php echo $totalDocs; ?>
                            </a>

                        </td>
                    </tr>

                <?php } ?>
                </tbody>
            </table>

        </div>

        <?php
        echo "<div align='center'><b>Total de Registros encontrados :</b>&nbsp;" . $numrows1 . "</div>";
        ?>
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
        <h4>Aviso!!!</h4> No hay datos para mostrar..!!!!!
    </div>
</div>

<?php
    }
}
?>

</body>
</html>