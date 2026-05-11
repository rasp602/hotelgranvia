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
$mañana = date("Y-m-d", strtotime($fecha . "+ 1 days"));
$ayer = date("Y-m-d", strtotime($fecha . "- 1 days"));

/* VERIFICA SI HAY HOSPEDAJES NUEVOS */
$ExisteH = mysqli_query($cone, "SELECT 
  hospedaje.idHospedaje,
  hospedaje.idPersona,
  hospedaje.idHotel,
  hospedaje.idHabitacion,
  hospedaje.idCama,
  hospedaje.desde,
  hospedaje.hasta,
  hospedaje.estado,
  hospedaje.fechaDespedida,
  hospedaje.horaDespedida,
  hotel.nombreHotel,
  habitacion.nHabitacion,
  cama.nCama,
  cama.estadoCama,
  persona.nombresPersona,
  persona.apellidoPersona1,
  empresa.nombreEmpresa
FROM hospedaje
INNER JOIN hotel ON hospedaje.idHotel = hotel.idHotel
INNER JOIN habitacion ON hospedaje.idHabitacion = habitacion.idHabitacion
INNER JOIN cama ON hospedaje.idCama = cama.idCama 
INNER JOIN persona ON hospedaje.idPersona = persona.idPersona 
INNER JOIN empresa ON persona.idEmpresa = empresa.idEmpresa 
WHERE hospedaje.estado = 'I' 
  AND hospedaje.idHotel = 1
  AND cama.estadoCama = 'I' 
  AND cama.idCama NOT IN (
      SELECT hospedaje.idCama FROM hospedaje WHERE estado = 'A'
  )
GROUP BY hospedaje.idHabitacion");

if (mysqli_num_rows($ExisteH) > 0) {
    while ($rowExisteH = mysqli_fetch_array($ExisteH)) {
        $idCama = $rowExisteH['idCama'];
        $idHabitacion = $rowExisteH['idHabitacion'];
        $nombreHotel = $rowExisteH['nombreHotel'];
        $nHabitacion = $rowExisteH['nHabitacion'];
        $nCama = $rowExisteH['nCama'];
        $persona = $rowExisteH['nombresPersona'] . " " . $rowExisteH['apellidoPersona1'];

        $actualizarCamaH2 = mysqli_query($cone, "UPDATE cama SET estadoCama = 'A' WHERE idCama ='$idCama'");

        if ($actualizarCamaH2) {
            echo '<div class="alert alert-info">
                    ✅ Cama <strong>' . $nCama . '</strong> en Habitación <strong>' . $nHabitacion . '</strong> (' . $nombreHotel . ') 
                    fue actualizada a estado <strong>ACTIVA</strong> para <strong>' . $persona . '</strong>.
                  </div>';
        }
    }
} else {
    echo '<div class="alert alert-warning">⚠ No se encontraron camas para actualizar en este momento.</div>';
}

/* ELIMINAR REGISTROS DUPLICADOS EN TABLA COMIDA */
/*
$ElimiarDuplicadosH1 = mysqli_query($cone, "DELETE c1
FROM comida c1
INNER JOIN comida c2 
  ON c1.idComida < c2.idComida 
  AND c1.idPersona = c2.idPersona 
  AND c1.tipoComida = c2.tipoComida 
  AND c1.fechaComida = c2.fechaComida 
  AND c1.horaComida = c2.horaComida 
  AND c1.idHospedaje = c2.idHospedaje");

$registrosEliminados = mysqli_affected_rows($cone);
if ($registrosEliminados > 0) {
    echo '<div class="alert alert-success">
            🗑 Se eliminaron <strong>' . $registrosEliminados . '</strong> registros duplicados en la tabla <strong>comida</strong> (HOTEL H1).
          </div>';
} else {
    echo '<div class="alert alert-info">ℹ No se encontraron registros duplicados en la tabla comida.</div>';
}*/
?>
