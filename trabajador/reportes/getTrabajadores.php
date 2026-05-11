<?php
require_once '../../bd/conexionLocal.php';

mysqli_report(MYSQLI_REPORT_OFF);

$sql = "SELECT COUNT(*) AS total FROM trabajador";
$resultado = mysqli_query($con, $sql);

if (!$resultado) {
    echo 0;
    exit;
}

$row = mysqli_fetch_assoc($resultado);
echo $row['total'];
?>