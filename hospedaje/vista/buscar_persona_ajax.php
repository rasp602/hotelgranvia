<?php
// simple conexion a la base de datos
require '../../bd/db.php';

// Función para limpiar y preparar la cadena de búsqueda
function limpiarBusqueda($str)
{
    return mysqli_real_escape_string(connect(), $str);
}

// Obtener el nombre ingresado desde la solicitud AJAX
$nombre = limpiarBusqueda($_POST['nombre']);

// Consulta para buscar la persona por nombre y/o apellido
$consulta = "SELECT idPersona, CONCAT(nombresPersona, ' ', apellidoPersona1) AS nombreCompleto, rutPersona FROM persona WHERE nombresPersona LIKE '%$nombre%' OR CONCAT(nombresPersona, ' ', apellidoPersona1) LIKE '%$nombre%' OR  rutPersona LIKE '%$nombre%' OR  apellidoPersona1 LIKE '%$nombre%' ORDER BY idPersona DESC";

$resultado = mysqli_query(connect(), $consulta);

// Arreglo para almacenar los resultados
$resultadosArray = array();

while ($misdatos = mysqli_fetch_assoc($resultado)) {
    $resultadosArray[] = $misdatos;
}

// Enviar los resultados en formato JSON
header('Content-Type: application/json');
echo json_encode($resultadosArray);
?>
