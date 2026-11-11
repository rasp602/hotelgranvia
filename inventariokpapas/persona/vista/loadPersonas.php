<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/



require '../../bd/config.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['idPersona','rutPersona', 'nombresPersona', 'apellidoPersona1', 'apellidoPersona2', 'persona.fechaCreado', 'horaCreado', 'genero', 'nombreEmpresa', 'qrPersona','empresa.idEmpresa'];

/* Nombre de la tabla */
$table = "persona";

$id = 'idPersona';

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;
$genero = isset($_POST['genero']) ? $conn->real_escape_string($_POST['genero']) : null;
$idEmpresa = isset($_POST['idEmpresa']) ? $conn->real_escape_string($_POST['idEmpresa']) : null;
$desde = isset($_POST['desde']) ? $conn->real_escape_string($_POST['desde']) : null;
$hasta = isset($_POST['hasta']) ? $conn->real_escape_string($_POST['hasta']) : null;

/* Filtrado */
$where = '';

/*if ($campo != null ) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {

        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

*/
if ($genero != null) {
    $where = "WHERE (";

        $where .= "persona.genero" . " LIKE '%" . $genero . "%' OR ";
    
    $where = substr_replace($where, "", -3);
    $where .= ")";
}


if ($campo != null) {
  
    $where = "WHERE (";   
       $where .= "persona.nombresPersona" . " LIKE '%" . $campo . "%' OR "; 
    $where = substr_replace($where, "", -3);
    $where .= ")";
}


if ($idEmpresa != null) {

    $where = "WHERE (";   
        $where .= "empresa.idEmpresa" . " LIKE'%" . $idEmpresa . "%' OR ";    
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

if ($desde != null) {
    $where = "WHERE (";   
        $where .= "persona.fechaCreado" . " LIKE'%" . $desde . "%' OR ";    
    $where = substr_replace($where, "", -3);
    $where .= ")";
}
elseif ($desde != null && $hasta != null) {
    $where = "WHERE (";   
        $where .= ".persona.fechaCreado BETWEEN $desde AND  $desde  ";    
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

 $sOrder = "";
 if(isset($_POST['orderCol'])){
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';
    
    $sOrder = "ORDER BY ". $columns[intval($orderCol)] . ' ' . $oderType;
 }


/* Consulta */
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa

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
        $output['data'] .= '<td>' . $row['idPersona'] . '</td>';
        $output['data'] .= '<td>' . $row['rutPersona'] . '</td>';
        $output['data'] .= '<td align="left">' . $row['nombresPersona'] . ' '.$row['apellidoPersona1'] . ' '.$row['apellidoPersona2'] .'</td>';
        $output['data'] .= '<td>' . $row['fechaCreado'] . '</td>';
        $output['data'] .= '<td>' . $row['horaCreado'] . '</td>';
        $output['data'] .= '<td>' . $row['genero'] . '</td>';
        $output['data'] .= '<td>' . $row['nombreEmpresa'] . '</td>';
        $output['data'] .= '<td>' . $row['qrPersona'] . '</td>';


        $output['data'] .= '<td><a class="glyphicon glyphicon-edit" href="?c=persona&a=Crud1&idPersona=' . $row['idPersona'] . '"></a></td>';
        $output['data'] .= "<td><a class='glyphicon glyphicon-trash' href='?c=persona&a=Eliminar&idPersona=" . $row['idPersona'] . "' onclick='javascript:return confirm('¿Seguro de eliminar este registro?');'></a></td>";
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
