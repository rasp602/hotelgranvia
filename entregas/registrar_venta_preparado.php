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
    die("Error: usuario no está definido en la sesión.");
}

if (!isset($_SESSION['lista']) || !is_array($_SESSION['lista']) || count($_SESSION['lista']) === 0) {
    header("location: venderPreparado.php");
    exit();
}

if (!isset($_SESSION['clienteVenta']) || empty($_SESSION['clienteVenta'])) {
    die("Error: no hay hotel seleccionado.");
}

if (!isset($_POST['tipoEntrega']) || empty($_POST['tipoEntrega'])) {
    die("Error: debe seleccionar un tipo de entrega.");
}

$usuario = $_SESSION['usuario'];
$productos = $_SESSION['lista'];
$idHotel = $_SESSION['clienteVenta'];
$tipoEntrega = $_POST['tipoEntrega'];

$mesa = 1;
$gananciaG = 1;
$total = 1;

require('bd/conexionLocal.php');
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

$consultaUsuario = mysqli_query($con, "SELECT idUsuario FROM usuario WHERE usuario = '$usuario'");
if (!$consultaUsuario) {
    die("Error en consulta de usuario: " . mysqli_error($con));
}

if ($row1 = mysqli_fetch_array($consultaUsuario)) {
    $idUsuario = $row1['idUsuario'];

    if (empty($idUsuario)) {
        die("Error: idUsuario está vacío.");
    }

    $resultado = registrarVentaPreparado($productos, $idUsuario, $idHotel, $total, $tipoEntrega, $gananciaG, $mesa);

    if (!$resultado) {
        echo "<div class='alert alert-danger'>Error al registrar la venta preparada</div>";
        exit();
    }

    $consultaEstado = mysqli_query($con, "SELECT MAX(id) AS idVenta FROM ventas_preparada");
    if (!$consultaEstado) {
        die("Error al obtener el último id: " . mysqli_error($con));
    }

    $ultimoId = 0;
    if ($row = mysqli_fetch_array($consultaEstado)) {
        $ultimoId = (int)$row['idVenta'];
    }

    // Guardar resumen en sesión antes de limpiar
    $_SESSION['resumen_preparado'] = [
        'idVenta' => $ultimoId,
        'tipoEntrega' => $tipoEntrega,
        'idHotel' => $idHotel,
        'productos' => $productos
    ];

    // Limpiar carrito después de registrar
    unset($_SESSION['lista']);

    // Redirigir al resumen bonito
    header("location: resumen_venta_preparado.php?idVenta=" . $ultimoId);
    exit();
} else {
    die("Error: no se encontró el usuario en la base de datos.");
}
?>