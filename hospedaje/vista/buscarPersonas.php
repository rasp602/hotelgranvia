Copy code
<?php
include "bd/db.php";
$con = connect();

if (!$con->set_charset("utf8")) {
    die("Error cargando el conjunto de caracteres utf8");
}

// Filtrar por nombre o apellido si se proporciona una cadena de búsqueda
$busqueda = isset($_GET['q']) ? $_GET['q'] : '';
$whereClause = '';

if (!empty($busqueda)) {
    $whereClause = " WHERE nombresPersona LIKE '%$busqueda%' OR apellidoPersona1 LIKE '%$busqueda%'";
}

$consulta = "SELECT * FROM persona" . $whereClause . " ORDER BY idPersona DESC";
$resultado = mysqli_query($con, $consulta);

$options = ''; // Variable para almacenar las opciones del select

while ($misdatos = mysqli_fetch_assoc($resultado)) {
    $options .= '<option value="' . $misdatos["idPersona"] . '" data-subtext="">' . $misdatos["nombresPersona"] . ' ' . $misdatos["apellidoPersona1"] . '-' . $misdatos["rutPersona"] . '</option>';
}

echo $options;
?>