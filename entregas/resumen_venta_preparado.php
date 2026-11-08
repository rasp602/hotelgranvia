<?php
include_once "funciones.php";
include_once "encabezado.php";
session_start();
require('bd/conexionLocal.php');

if (!isset($_GET['idVenta']) || empty($_GET['idVenta'])) {
    die("No se recibió el número de venta.");
}

$idVenta = (int)$_GET['idVenta'];

$resumen = isset($_SESSION['resumen_preparado']) ? $_SESSION['resumen_preparado'] : null;
if (!$resumen || (int)$resumen['idVenta'] !== $idVenta) {
    die("No se encontró el resumen de la orden.");
}

$tipoEntrega = $resumen['tipoEntrega'];
$idHotel = $resumen['idHotel'];
$productos = $resumen['productos'];

$nombreHotel = "No disponible";
$direccionHotel = "No disponible";

$consultaHotel = mysqli_query($con, "SELECT nombreHotel, direccion FROM hotel WHERE idHotel = '$idHotel'");
if ($consultaHotel && mysqli_num_rows($consultaHotel) > 0) {
    $rowHotel = mysqli_fetch_assoc($consultaHotel);
    $nombreHotel = $rowHotel['nombreHotel'];
    $direccionHotel = $rowHotel['direccion'];
}

$textoEntrega = ($tipoEntrega === 'L') ? 'Lonchera' : 'Empacada';

$totalItems = 0;
foreach ($productos as $p) {
    $totalItems += isset($p->cantidad) ? (int)$p->cantidad : 1;
}

date_default_timezone_set("America/Santiago");
$fechaActual = date("d-m-Y");
$horaActual = date("H:i:s");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Resumen Orden</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<style>
body{
    background:#fff;
    font-size:12px;
    font-family: Arial, sans-serif;
}

.resumen-box{
    max-width:900px;
    margin:auto;
}

.resumen-header{
    background:#2e7d32;
    color:#fff;
    padding:12px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.resumen-header h3{
    margin:0;
    font-size:18px;
}

.logo{
    max-height:60px;
}

.info{
    padding:10px;
    border:1px solid #ddd;
    margin-bottom:10px;
}

.numero{
    font-size:18px;
    font-weight:bold;
    color:#2e7d32;
}

.table{
    font-size:11px;
}

.table th{
    background:#2e7d32;
    color:#fff;
    text-align:center;
    padding:6px !important;
}

.table td{
    padding:5px !important;
}

.firma{
    margin-top:50px;
    padding-top:20px;
}

.linea{
    border-top:1px solid #000;
    margin-top:40px;
    width:250px;
}

.text-center{
    text-align:center;
}

.acciones{
    margin-top:20px;
    text-align:center;
}

@media print{
    .acciones{
        display:none;
    }
}
</style>

</head>

<body>

<div class="resumen-box">

    <div class="resumen-header">
        <h3>RESUMEN ORDEN PREPARADA</h3>
        <img src="../hotelgranvia/img/bmarriendos.png" class="logo">
    </div>

    <div class="info">
        <div><strong>Orden:</strong> <span class="numero">#<?php echo $idVenta; ?></span></div>
        <div><strong>Fecha:</strong> <?php echo $fechaActual; ?> | <strong>Hora:</strong> <?php echo $horaActual; ?></div>
        <div><strong>Tipo:</strong> <?php echo $textoEntrega; ?></div>
        <div><strong>Total unidades:</strong> <?php echo $totalItems; ?></div>
    </div>

    <div class="info">
        <strong>Destino:</strong><br>
        <?php echo htmlspecialchars($nombreHotel); ?><br>
        <?php echo htmlspecialchars($direccionHotel); ?>
    </div>

    <div class="info">
        <strong>Detalle:</strong>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php $n=1; ?>
                <?php foreach ($productos as $producto) { ?>
                <tr>
                    <td><?php echo $n++; ?></td>
                    <td><?php echo htmlspecialchars($producto->nombreProducto); ?></td>
                    <td><?php echo (int)$producto->cantidad; ?></td>
                    <td><?php echo (int)$producto->existenciaProducto; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- FIRMA -->
    <div class="firma text-center">
        <div><strong>Nombre:</strong> __________________________</div>
        <div><strong>RUT:</strong> _____________________________</div>
        <br><br><br><br>
        <div>_____________________________</div>
        <div><strong>Firma Recepción</strong></div>
    </div>

    <div class="acciones">
        <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
        <a href="venderPreparado.php" class="btn btn-success">Nueva Orden</a>
    </div>

</div>

</body>
</html>