<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php
include_once "funciones.php";
include_once "encabezado.php";
session_start();

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    die("Error: idUsuario no está definido en la sesión.");
}

$usuario = $_SESSION['usuario'];
$productos = $_SESSION['lista'];
//$idHotel = $_SESSION['clienteVenta'];

$tipoPedido = "P";
$mesa = 1;
$gananciaG = 1;
$total = 1;
$bodega = 1;

if (count($productos) === 0) {
    header("location: venderPedido.php");
    exit();
}

require('bd/conexionLocal.php');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$consultaUsuario = mysqli_query($con, "SELECT idUsuario FROM usuario WHERE usuario = '$usuario'");
if ($row1 = mysqli_fetch_array($consultaUsuario)) {
    $idUsuario = $row1['idUsuario'];

    if (empty($idUsuario)) {
        die("Error: idUsuario está vacío.");
    }

    $resultado = registrarPedido($productos, $idUsuario, $total, $tipoPedido, $gananciaG, $mesa);

    if (!$resultado) {
        echo "<div class='alert alert-danger'>Error al registrar la venta</div>";
        exit();
    }

    if ($resultado) {
        $consultaEstado = mysqli_query($con, "SELECT MAX(idPedido) AS idPedido FROM ventas_pedidos");
        if ($row = mysqli_fetch_array($consultaEstado)) {
            $ultimoId = $row['idPedido'];
        }
    
        // Limpiar productos de la sesión
        unset($_SESSION['lista']);
    
        // Redirigir a otra URL
        header("Location: https://hotelgranvia.net/enviarCorreoNotificacion.php");
        exit();
    }
}
?>
