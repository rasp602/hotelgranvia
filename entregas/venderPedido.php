
<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";

if(empty($_SESSION['usuario'])) header("location: login.php");
$_SESSION['lista'] = (isset( $_SESSION['lista'])) ?  $_SESSION['lista'] : [];
/*$total = calcularTotalLista($_SESSION['lista']);*/
$clientes = obtenerClientes();
$clienteSeleccionado = (isset($_SESSION['clienteVenta'])) ? obtenerClientePorId($_SESSION['clienteVenta']) : null;
require('bd/conexionLocal.php');
//$con = mysqli_connect('localhost','root','','ventas_php');
// Check connection
if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
date_default_timezone_set("America/Santiago");
    //date_default_timezone_set("America/Caracas");
    $hora=date('H:i:s');

    $consultaEstado=mysqli_query($con,"SELECT MAX( id ) FROM ventas");
    $rowcount1=mysqli_num_rows($consultaEstado);
if($row= mysqli_fetch_array($consultaEstado))
{
 $idVenta= $row['MAX( id )'];
 $ultimoId= $idVenta+1;
 }

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

<div class="container-fluid mt-3">

<h1>Producto <i class="bi bi-box-seam"></i></h1>

    

    <div class="row">
        <div class="col-lg-8 col-md-6 mb-2">
            <form action="agregar_producto_pedido.php" method="post" class="row">
            <div class="col-8">
                <select class="form-control form-control-lg" id="codigo" name="codigo" style="width: 100%;"></select>
            </div>
                <div class="col-4">
                    <input type="submit" value="Agregar" name="agregar" class="btn btn-success mt-2">
                    <input type="hidden" value="<?php echo $ultimoId;?>" name="idPedido" class="" id="idPedido">
                </div>
            </form>

            <?php if($_SESSION['lista']) { ?>
            
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código de barra <i class="bi bi-upc"></i></th>
                            <th>Producto <i class="bi bi-box-seam"></i></th>
                           
                            <th>Cantidad <i class="bi bi-123"></i></th>
                           
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($_SESSION['lista'] as $lista) { ?>
                        <tr>
                            <td><?php echo $lista->codigoBarra;?></td>
                            <td><?php echo $lista->nombreProducto;?></td>
                          
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="productoId" value="<?php echo $lista->idProducto; ?>">
                                    <input type="number" name="nuevaCantidad" value="<?php echo $lista->cantidad; ?>" min="1" onchange="this.form.submit()" class="form-control">
                                    <input type="hidden" name="updateCantidad">
                                </form>
                            </td>
                            
                            <td>
                                <a href="quitar_producto_pedido.php?idProducto=<?php echo $lista->idProducto?>" class="btn btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <form action="registrar_pedido.php" method="post" class="row">
      
                    <div class="row mb-3">
                    <input class="btn btn-info" type="submit" value="Terminar Orden">
                    </div> 
              

                </input>
   
                <?php } ?>
                </form>
            </div>
              <div>              
            <div class="text-center mt-3">
    

    <a class="btn btn-danger btn-lg" href="cancelar_pedido.php">
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
            url: 'buscador.php',
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
