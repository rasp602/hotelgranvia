<div class="container-fluid">
<?php 
    $usuario = null;

    if (isset($_SESSION["usuarioInventario"])) {
        $usuario = $_SESSION["usuarioInventario"];

        if ($usuario->nivel == "U") {
            include_once 'menu_principal/vista/Menu_Usuarios.php'; 
        }

        if ($usuario->nivel == "F") {
            include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
        }

        if ($usuario->nivel == "I") {
            include_once 'menu_principal/vista/Menu_Inventario.php';   
        }
    }

    include 'bd/conexionLocal.php';
    error_reporting(E_ERROR | E_PARSE);

    $idPedido = isset($_REQUEST["idPedido"]) ? intval($_REQUEST["idPedido"]) : 0;

    // Consulta para traer encabezado + detalle del pedido
    $query = mysqli_query($con, "
        SELECT 
            productos_pedido.idPedido,
            productos_pedido.cantidad,
            productos_pedido.idProducto,
            producto.nombreProducto,
            producto.codigoBarra,
            tipoproducto.nombreTipoProducto,
            ventas_pedidos.fecha,
            ventas_pedidos.idUsuario,
            ventas_pedidos.tipoPedido,
            tblusuario.nombre,
            tblusuario.apellido
        FROM productos_pedido
        INNER JOIN producto 
            ON productos_pedido.idProducto = producto.idProducto
        INNER JOIN tipoproducto 
            ON producto.idTipoProducto = tipoproducto.idTipoProducto
        INNER JOIN ventas_pedidos 
            ON productos_pedido.idPedido = ventas_pedidos.idPedido
        INNER JOIN tblusuario 
            ON ventas_pedidos.idUsuario = tblusuario.idUsuario
        WHERE ventas_pedidos.idPedido = $idPedido
    ");

    $datosPedido = [];
    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $datosPedido[] = $row;
        }

        $primero = $datosPedido[0];
        $fechaPedido = !empty($primero["fecha"]) ? date("d-m-Y", strtotime($primero["fecha"])) : "";
        $nombreSolicitante = utf8_encode($primero["nombre"] . " " . $primero["apellido"]);
    }
?>

<style>
    .pedido-wrapper {
        margin-top: 20px;
        margin-bottom: 30px;
    }

    .pedido-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        overflow: hidden;
        border: 1px solid #e6e6e6;
    }

    .pedido-header {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: #fff;
        padding: 25px;
        text-align: center;
    }

    .pedido-header h2,
    .pedido-header h3,
    .pedido-header h4 {
        margin: 5px 0;
        font-weight: 600;
    }

    .pedido-info {
        padding: 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .info-box {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 15px;
        min-height: 95px;
    }

    .info-box .titulo {
        font-size: 13px;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .info-box .valor {
        font-size: 20px;
        color: #212529;
        font-weight: bold;
    }

    .tabla-contenedor {
        padding: 20px;
    }

    .tabla-contenedor h4 {
        margin-top: 0;
        margin-bottom: 15px;
        color: #0d6efd;
        font-weight: bold;
    }

    #tabla thead tr {
        background: #0d6efd;
        color: white;
    }

    #tabla tbody tr:hover {
        background-color: #f1f7ff;
    }

    .alert-custom {
        margin-top: 15px;
    }

    .sin-datos {
        margin-top: 25px;
    }

    .badge-cantidad {
        background: #198754;
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 20px;
    }
</style>

<div class="row pedido-wrapper">
    <div class="col-md-2"></div>

    <div class="col-md-8">
        <?php if (isset($_GET["success"])) { ?>
            <div class="alert alert-info alert-custom" role="alert">
                Orden registrada correctamente.
            </div>
        <?php } ?>

        <?php if (isset($_GET["delete"])) { ?>
            <div class="alert alert-warning alert-custom" role="alert">
                Orden eliminada correctamente.
            </div>
        <?php } ?>

        <?php if (!empty($datosPedido)) { ?>
            <div class="pedido-card">
                
                <div class="pedido-header">
                    <h2><i class="bi bi-clipboard2-check"></i> Detalle del Pedido</h2>
                    <h3>N° <?php echo $idPedido; ?></h3>
                </div>

                <div class="pedido-info">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <div class="titulo"><i class="bi bi-hash"></i> Número Pedido </div>
                                <div class="valor"> <?php echo $idPedido; ?></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <div class="titulo"><i class="bi bi-calendar-date"></i> Fecha del Pedido </div>
                                <div class="valor"> <?php echo $fechaPedido; ?></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <div class="titulo"><i class="bi bi-person-fill"></i> Solicitado por </div>
                                <div class="valor" style="font-size:18px;"> <?php echo $nombreSolicitante; ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tabla-contenedor">
                    <h4><i class="bi bi-box-seam"></i> Productos del Pedido</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="tabla">
                            <thead>
                                <tr>
                                    <th style="width: 15%; text-align:center;">Cantidad</th>
                                    <th style="width: 50%;">Descripción del Producto</th>
                                    <th style="width: 35%;">Tipo Producto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datosPedido as $row) { ?>
                                    <tr>
                                        <td style="text-align:center;">
                                            <span class="badge badge-cantidad">
                                                <?php echo utf8_encode($row['cantidad']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo utf8_encode($row['nombreProducto']); ?></td>
                                        <td><?php echo utf8_encode($row['nombreTipoProducto']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        <?php } else { ?>
            <div class="container sin-datos">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="bi bi-exclamation-triangle-fill"></i> Aviso</h4>
                    No hay datos para mostrar para este pedido.
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="col-md-2"></div>
</div>
</div>