<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/



require '../../bd/config.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['hospedaje.idHospedaje','hospedaje.idPersona', 'hospedaje.idHotel', 'hospedaje.idHabitacion', 'hospedaje.idCama', 'hospedaje.desde', 'hospedaje.hasta','hospedaje.estado','hospedaje.fechaDespedida','hospedaje.horaDespedida','hospedaje.tipohabitacion','hotel.idHotel', 'hotel.nombreHotel', 'hotel.capacidadHotel', 'hotel.direccion', 'habitacion.idHabitacion', 'habitacion.idHotel', 'habitacion.nHabitacion', 'habitacion.capacidadHabitacion', 'cama.idCama', 'cama.idHabitacion', 'cama.nCama', 'cama.estadoCama', 'persona.idPersona', 'persona.nombresPersona', 'persona.apellidoPersona1', 'persona.rutPersona', 'empresa.idEmpresa', 'empresa.nombreEmpresa', 'persona.idEmpresa'];

/* Nombre de la tabla */
$table = "hospedaje";

$id = 'idHospedaje';

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;
$idHotel = isset($_POST['idHotel']) ? $conn->real_escape_string($_POST['idHotel']) : null;
$idHabitacion = isset($_POST['idHabitacion']) ? $conn->real_escape_string($_POST['idHabitacion']) : null;
$idCama = isset($_POST['idCama']) ? $conn->real_escape_string($_POST['idCama']) : null;
$estado = isset($_POST['estado']) ? $conn->real_escape_string($_POST['estado']) : null;
$idEmpresa = isset($_POST['idEmpresa']) ? $conn->real_escape_string($_POST['idEmpresa']) : null;
$desde = isset($_POST['desde']) ? $conn->real_escape_string($_POST['desde']) : null;
$hasta = isset($_POST['hasta']) ? $conn->real_escape_string($_POST['hasta']) : null;


/* Filtrado */
$where = 'where hospedaje.estado= "A" ';

if ($campo != null ) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

if ($idHotel != null ) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= "hospedaje.idHotel" . " LIKE '%" . $idHotel . "%'";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}


if ($idHotel != null && $idHabitacion!= null) {
    $where = "WHERE (";

    
        $where .= "hospedaje.idHotel" . " = $idHotel  AND hospedaje.idHabitacion" . " = $idHabitacion  OR ";
    
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

if ($idHotel != null && $idHabitacion!= null && $idCama!= null) {
    $where = "WHERE (";

    
        $where .= "hospedaje.idHotel" . " = $idHotel  AND hospedaje.idHabitacion" . " = $idHabitacion  AND hospedaje.idCama" . " = $idCama   ";
    
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

if ( $idHotel != null && $idHabitacion!= null && $idCama!= null && $estado != null ) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= "hospedaje.idHotel" . " = $idHotel  AND hospedaje.idHabitacion" . " = $idHabitacion  AND hospedaje.idCama" . " = $idCama and hospedaje.estado" . " LIKE '%" . $estado . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}




if ($idHotel == null && $idHabitacion== null && $idCama== null && $estado != null ) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= "hospedaje.estado" . " LIKE '%" . $estado . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

if ($idHotel == null && $idHabitacion== null && $idCama== null && $idEmpresa != null ) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= "persona.idEmpresa" . " LIKE '%" . $idEmpresa . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

if ($idHotel != null && $idHabitacion!= null && $idCama!= null && $idEmpresa != null ) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= "hospedaje.idHotel" . " = $idHotel  AND hospedaje.idHabitacion" . " = $idHabitacion  AND hospedaje.idCama" . " = $idCama and hospedaje.estado" . " LIKE '%" . $estado . "%' and empresa.idEmpresa " . " LIKE '%" . $idEmpresa . "%'";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}


if ($desde != null) {
    $where = "WHERE (";   
        $where .= "hospedaje.desde" . " LIKE'%" . $desde . "%' OR ";    
    $where = substr_replace($where, "", -3);
    $where .= ")";
}
elseif ($desde != null && $hasta != null) {
    $where = "WHERE (";   
        $where .= ".hospedaje.desde BETWEEN $desde AND  $desde  ";    
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

/* Limit */
$limit = isset($_POST['registros']) ? $conn->real_escape_string($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio , $limit";

/**
 * Ordenamiento
 */

 $sOrder = "ORDER BY hospedaje.idHabitacion";
 /*if(isset($_POST['orderCol'])){
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';
    
    $sOrder = "ORDER BY ". $columns[intval($orderCol)] . ' ' . $oderType ;
 }*/


/* Consulta */
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table 
INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
INNER JOIN cama ON hospedaje.idCama=cama.idCama 
INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
$where
$sOrder
$sLimit";
$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table ";
$resTotal = $conn->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = $row_total[0];

/* Mostrado resultados */
$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td>' . $row['nombreHotel'] . '</td>';
        $output['data'] .= '<td>' . $row['nHabitacion'] . '</td>';
        $output['data'] .= '<td>' . $row['nCama'] . '</td>';
        $output['data'] .= '<td>' . $row['nombresPersona'] . ' ' . $row['apellidoPersona1'] . '</td>';
        $output['data'] .= '<td>' . $row['rutPersona'] . '</td>';
        $output['data'] .= '<td>' . $row['nombreEmpresa'] . '</td>';
        $output['data'] .= '<td>' . $row['desde'] . '</td>';
        $output['data'] .= '<td>' . $row['hasta'] . '</td>';

        if ($row['tipohabitacion']=='D') {
            $output['data'] .= '<td>' . "Doble" . '</td>';
        }
        else
        {
            $output['data'] .= '<td>' . "Simple" . '</td>';
        }
        


        $output['data'] .= '<td>' . $row['fechaDespedida'] . '</td>';
        $output['data'] .= '<td>' . $row['horaDespedida'] . '</td>';
        $output['data'] .= '<td>' . $row['estado'] . '</td>';

        if ($row['estado']=='A') {
            $output['data'] .= 

                   "<td>
        <a class='glyphicon glyphicon-log-out' href='?c=hospedaje&a=Crud1&idHospedaje?id=" . $row['idHospedaje'] . "'></a></td>";
        }
        else
        {
          $output['data'] .= 

                   "<td></td>";
        }



        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="7">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if(($pagina - 4) > 1){
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if($numeroFin > $totalPaginas){
        $numeroFin = $totalPaginas;
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
