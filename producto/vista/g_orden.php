

<div class="container-fluid">
<?php 
          $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                                echo "hola usuario";
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                                echo "hola Fiscalizador";
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
                        if ($usuario->nivel == "I") 
                        {
                                echo "hola Inventario";
                                include_once 'menu_principal/vista/Menu_Inventario.php';   
                        } 
               }  
               $id = $_REQUEST["id"];        
         ?> 
         
    <h3  class="page-header" align="center"><i class="bi bi-clipboard"></i> Nueva Orden de entrega</h3>

        <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Orden registrada correctamente..</div>'; ?> 
        
        <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Ordeneliminada correctamente..</div>'; ?>  
    <div class="row">


    
<div class="col-md-1"></div>

    </div>
    <?php

include_once "funciones.php";

$_SESSION['lista'] = (isset( $_SESSION['lista'])) ?  $_SESSION['lista'] : [];
/*$total = calcularTotalLista($_SESSION['lista']);*/
$clientes = obtenerClientes();
$clienteSeleccionado = (isset($_SESSION['clienteVenta'])) ? obtenerClientePorId($_SESSION['clienteVenta']) : null;

//$con = mysqli_connect('localhost','root','','ventas_php');
// Check connection
if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
date_default_timezone_set("America/Santiago");
    //date_default_timezone_set("America/Caracas");
    $hora=date('H:i:s');


?>

    <?php
// ... (código anterior)

// Función para calcular el subtotal de un producto
function calcularSubtotal($cantidad, $precio) {
    return $cantidad * $precio;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manejar cambios en la cantidad y actualizar el subtotal y el total
    if (isset($_POST['updateCantidad'])) {
        $productoId = $_POST['productoId'];
        $nuevaCantidad = $_POST['nuevaCantidad'];

        foreach ($_SESSION['lista'] as &$producto) {
            if ($producto->idProducto == $productoId) {
                $producto->cantidad = $nuevaCantidad;
                break;
            }
        }

        // Recalcular el total después de actualizar la cantidad
       /* $total = calcularTotalLista($_SESSION['lista']);*/
    }
}

// ... (código anterior)

?>
    <div class="container mt-3"> 
<form class="row" method="post" action="producto/vista/establecer_cliente_venta.php">
            <div class="col-6">
                <select class="form-select" aria-label="Default select example" name="idCliente">
                    <option selected value="">Selecciona el hotel</option>
                    <?php foreach($clientes as $cliente) {?>
                        <option value="<?php echo $cliente->idHotel?>"><?php echo $cliente->nombreHotel?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-auto">
                <input class="btn btn-info" type="submit" value="Seleccionar hotel"> </input>
            </div>
                <div class="col-auto">
                <h3>Orden de Entrega</h3>
            </div>
        </form>

                <?php if($clienteSeleccionado){ ?>
                <div class="alert alert-primary mt-3" role="alert">
                    <b>Hotel seleccionado: </b><br>
                    <b>Nombre: </b> <?php echo $clienteSeleccionado->nombreHotel?><br>
                    <b>Capacidad Hotel: </b> <?php echo $clienteSeleccionado->capacidadHotel?><br>
                    <b>Dirección: </b> <?php echo $clienteSeleccionado->direccion?><br>
                    <a href="quitar_cliente_venta.php" class="btn btn-warning">Quitar</a>
                </div>
    <div class="row">
        <div class="col-lg-8 col-md-12 mb-4">
            <form action="producto/vista/agregar_producto_venta.php" method="post" class="row">
            <div class="col-8">
                <select class="form-control form-control-lg" id="codigo" name="codigo" style="width: 100%;"></select>
            </div>
                <div class="col-4">
                    <input type="submit" value="Agregar" name="agregar" class="btn btn-success mt-2">
                    <input type="hidden" value="<?php echo $ultimoId;?>" name="idVenta" class="" id="idVenta">
                </div>
            </form>

            <?php if($_SESSION['lista']) { ?>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código de barra</th>
                            <th>Producto</th>
                            <th>Existencia</th>
                            <th>Cantidad</th>
                           
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($_SESSION['lista'] as $lista) { ?>
                        <tr>
                            <td><?php echo $lista->codigoBarra;?></td>
                            <td><?php echo $lista->nombreProducto;?></td>
                            <td><?php echo $lista->existenciaProducto;?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="productoId" value="<?php echo $lista->idProducto; ?>">
                                    <input type="number" name="nuevaCantidad" value="<?php echo $lista->cantidad; ?>" min="1" onchange="this.form.submit()" class="form-control">
                                    <input type="hidden" name="updateCantidad">
                                </form>
                            </td>
                            
                            <td>
                                <a href="quitar_producto_venta.php?idProducto=<?php echo $lista->idProducto?>" class="btn btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <form action="registrar_venta.php" method="post" class="row">
      
                    <div class="row mb-3">
                    <input class="btn btn-info" type="submit" value="Terminar Orden">
                    </div> 
                </input>
   
                <?php } ?>
                </form>
            </div>
            <?php } ?>
            <div class="text-center mt-3">
    

    <a class="btn btn-danger btn-lg" href="cancelar_venta.php">
        <i class="fa fa-times"></i> Cancelar
    </a>
</div>
        </div>

        <!-- Carta de productos - Siempre visible a la derecha en pantallas grandes, abajo en móviles -->
    
    </div>
</div>
<!-- Incluir jQuery primero -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Incluir Select2 después de jQuery -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Tu código para inicializar Select2 -->
<script>
jQuery(document).ready(function() {
    jQuery('#codigo').select2({
        placeholder: 'Buscar producto por descripción',
        minimumInputLength: 2,
        ajax: {
            url: 'producto/vista/buscador.php',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: jQuery.map(data, function (item) {
                        return {
                            id: item.idProducto,
                            text: item.nombreProducto + ' (' + item.existenciaProducto + ')'
                            
                        };
                    })
                };
            },
            cache: true
        }
    });
});

</script>




</div>
