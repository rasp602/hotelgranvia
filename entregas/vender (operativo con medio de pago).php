<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";

if(empty($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}
/*
foreach ($_SESSION['lista'] as &$producto) {
    if (isset($producto->cantidad)) {
        echo $producto->cantidad;
    } else {
        echo 'Cantidad no definida';
    }
}
echo '<pre>';
print_r($_SESSION['lista']);
echo '</pre>';*/
$usuario = $_SESSION['usuario'];
function obtenerRangoMesas($usuario) {
    // Mapeamos los nombres de usuario a un número de caja
    $usuarios = [
        "caja1" => 1,
        "caja2" => 2,
        "caja3" => 3,
        "caja4" => 4,
        "caja5" => 5,
        "caja6" => 6,
        "caja7" => 7,
        "caja8" => 8,
        "caja9" => 9,
        "caja10" => 10
    ];
    
    // Si el usuario no está en el listado, le asignamos el primer rango
    $numeroCaja = isset($usuarios[$usuario]) ? $usuarios[$usuario] : 1;

    // Calculamos el rango de mesas basado en la caja del usuario
    $mesaInicio = ($numeroCaja - 1) * 5 + 1;
    $mesaFin = $mesaInicio + 4;

    return range($mesaInicio, $mesaFin);
}

$usuario = $_SESSION['usuario'];
$_SESSION['lista'] = isset($_SESSION['lista']) ? $_SESSION['lista'] : [];
$total = calcularTotalLista($_SESSION['lista']);
$clientes = obtenerClientes();
$clienteSeleccionado = isset($_SESSION['clienteVenta']) ? obtenerClientePorId($_SESSION['clienteVenta']) : null;

require('bd/conexionLocal.php');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

date_default_timezone_set("America/Santiago");
$hora = date('H:i:s');

$consultaEstado = mysqli_query($con, "SELECT MAX(id) FROM ventas");
if ($row = mysqli_fetch_array($consultaEstado)) {
    $idVenta = $row['MAX(id)'];
    $ultimoId = $idVenta + 1;
}

// Función para calcular el subtotal de un producto
function calcularSubtotal($cantidad, $precio) {
    return $cantidad * $precio;
}
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manejar cambios en la cantidad y actualizar el subtotal
    if (isset($_POST['updateCantidad']) && isset($_POST['productoId']) && isset($_POST['nuevaCantidad'])) {
        $productoId = $_POST['productoId'];
        $nuevaCantidad = (int) $_POST['nuevaCantidad']; // Asegurarse de que sea un entero

        // Recorrer la lista de productos y actualizar la cantidad
        foreach ($_SESSION['lista'] as &$producto) {
            if ($producto->id == $productoId && $nuevaCantidad > 0) {
                $producto->cantidad = $nuevaCantidad;
                break;
            }
        }
    }
}*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manejar cambios en la cantidad y actualizar el subtotal
    if (isset($_POST['updateCantidad'])) {
        $productoId = $_POST['productoId'];
        $nuevaCantidad = $_POST['nuevaCantidad'];
        
        foreach ($_SESSION['lista'] as &$producto) {
            if ($producto->id == $productoId) {
                $producto->cantidad = $nuevaCantidad;
                break;
            }
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="container mt-3">
                <h1>Ingresar Código de producto</h1>
                <form action="agregar_producto_venta.php" method="post" class="row">
                    <div class="col-8">
                        <input class="form-control form-control-lg" name="codigo" autofocus id="codigo" type="text" placeholder="Código de barras del producto" aria-label="codigoBarras">
                    </div>
                    <div class="col-4">
                        <input type="submit" value="Agregar" name="agregar" class="btn btn-success mt-2">
                        <input type="hidden" value="<?php echo $ultimoId; ?>" name="idVenta" class="" id="idVenta">
                    </div>
                </form>

                <?php if (!empty($_SESSION['lista'])) { ?>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                            <th>Código</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Quitar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['lista'] as $lista) { ?>
                            <tr>
                            <td><?php echo $lista->codigo;?></td>
                                <td><?php echo $lista->nombre; ?></td>
                                <td>$<?php echo $lista->venta; ?></td>
                                <td><?php echo $lista->cantidad;?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="productoId" value="<?php echo $lista->id; ?>">
                                       
                                        <input type="hidden" name="updateCantidad">
                                    </form>
                                </td>
                                <td>$<?php echo floatval($lista->cantidad * $lista->venta);?></td>
                                <td>
                                    <a href="quitar_producto_venta.php?id=<?php echo $lista->id; ?>" class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Si hay un cliente seleccionado, mostrarlo -->
                <?php if ($clienteSeleccionado) { ?>
                <div class="alert alert-primary mt-3" role="alert">
                    <b>Cliente seleccionado: </b><br>
                    <b>Nombre: </b> <?php echo $clienteSeleccionado->nombre; ?><br>
                    <b>Teléfono: </b> <?php echo $clienteSeleccionado->telefono; ?><br>
                    <b>Dirección: </b> <?php echo $clienteSeleccionado->direccion; ?><br>
                    <a href="quitar_cliente_venta.php" class="btn btn-warning">Quitar</a>
                </div>
                <?php } ?>
                
                <!-- Formulario para registrar la venta -->
                <form action="registrar_venta.php" method="post" class="row">
                    <h1>Seleccionar Método de pago</h1>
                    <div class="row">
                        <select class="form-select" name="tipoPago" id="tipoPago" required>
                            <option selected value="">Seleccione un método de pago</option>
                            <option value="E">Efectivo</option>
                            <option value="T">Transbank</option>
                        </select>
                    </div>
<h1></h1>
<div class="row">
     <div class="col-12">
    <select class="form-select" name="mesa" id="mesa" required>
        <option selected value="">Seleccione una mesa</option>
        <?php
        // Obtenemos las mesas correspondientes al usuario
        $mesasDisponibles = obtenerRangoMesas($usuario);

        // Generamos las opciones de las mesas
        foreach ($mesasDisponibles as $mesa) {
            echo "<option value='{$mesa}'>Mesa {$mesa}</option>";
        }
        ?>
    </select>
</div>
</div>
                </div>
                    <div class="col-12 text-center mt-3">
                        <h1>Total: $<?php echo number_format($total); ?></h1>
                        <input type="submit" id="registrar" class="btn btn-success" value="Terminar Venta">
                        <a class="btn btn-danger" href="cancelar_venta.php">Cancelar Venta</a>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-4">
            <h1>Carta</h1>
            <?php
            if (empty($_SESSION['usuario'])) {
                header("location: login.php");
                exit();
            }

            $nombreProducto = isset($_POST['nombreProducto']) ? $_POST['nombreProducto'] : null;
            $productos1 = obtenerProductos($nombreProducto);
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio venta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos1 as $productolista) { ?>
                    <tr>
                        <td><?= $productolista->codigo; ?></td>
                        <td><?= $productolista->nombre; ?></td>
                        <td><?= '$' . number_format($productolista->venta, 2); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
