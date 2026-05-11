<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
require('bd/conexionLocalPase.php'); // conexión
date_default_timezone_set("America/Santiago");

$fecha = date('Y-m-d');

/* ELIMINAR REGISTROS DUPLICADOS SOLO DEL DÍA ACTUAL */
$sql = "DELETE c1
FROM comida c1
INNER JOIN comida c2 
  ON c1.idComida < c2.idComida 
  AND c1.idPersona = c2.idPersona 
  AND c1.tipoComida = c2.tipoComida 
  AND c1.fechaComida = c2.fechaComida 
  AND c1.horaComida = c2.horaComida 
  AND c1.idHospedaje = c2.idHospedaje 
WHERE c1.fechaComida = '$fecha' 
  AND c2.fechaComida = '$fecha'";

$ElimiarDuplicadosH1 = mysqli_query($cone, $sql);

if (!$ElimiarDuplicadosH1) {
    die("❌ Error en la consulta: " . mysqli_error($cone));
}

$registrosEliminados = mysqli_affected_rows($cone);
if ($registrosEliminados > 0) {
    echo '<div class="alert alert-success">
            🗑 Se eliminaron <strong>' . $registrosEliminados . '</strong> registros duplicados en la tabla <strong>comida</strong> (HOTEL H1) del día <strong>' . $fecha . '</strong>.
          </div>';
} else {
    echo '<div class="alert alert-info">ℹ No se encontraron registros duplicados en la tabla comida para el día <strong>' . $fecha . '</strong>.</div>';
}
?>

