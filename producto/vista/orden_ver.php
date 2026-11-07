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

$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;

$datosOrden = [];
$productosEntrega = [];
$productosSinStock = [];

$totalCantidad = 0;
$nombreHotel = "";
$fechaOrden = "";
$nombreSolicitante = "";
$tipoEntrega = "";

$query = mysqli_query($con, "
    SELECT 
        productos_ventas.cantidad,
        productos_ventas.precio,

        producto.idProducto,
        producto.nombreProducto,
        producto.codigoBarra,

        tipoproducto.nombreTipoProducto,

        ventas.id AS idVenta,
        ventas.fecha,
        ventas.tipoEntrega,
        ventas.estado,
        ventas.idUsuario,
        ventas.idHotel,

        usuario.id_user,
        usuario.usuario,

        tblusuario.idUsuario AS idUsuarioPersona,
        tblusuario.rut,
        tblusuario.nombre,
        tblusuario.apellido,

        hotel.idHotel AS idHotelOrden,
        hotel.nombreHotel

    FROM productos_ventas

    INNER JOIN producto 
        ON productos_ventas.idProducto = producto.idProducto

    LEFT JOIN tipoproducto 
        ON producto.idTipoProducto = tipoproducto.idTipoProducto

    INNER JOIN ventas 
        ON productos_ventas.idVenta = ventas.id

    LEFT JOIN usuario
        ON ventas.idUsuario = usuario.idUsuario

    LEFT JOIN tblusuario
        ON usuario.idUsuario = tblusuario.idUsuario

    LEFT JOIN hotel
        ON ventas.idHotel = hotel.idHotel

    WHERE ventas.id = $id
");

if ($query && mysqli_num_rows($query) > 0) {

    while ($row = mysqli_fetch_assoc($query)) {
        $datosOrden[] = $row;
    }

    /*
    =====================================================
    TOTAL DE UNIDADES
    =====================================================
    */

    $totalCantidad = 0;

    foreach ($datosOrden as $item) {
        // Se utiliza la cantidad GUARDADA, nunca el stock actual del producto.
        if ((int)$item['cantidad'] === 0) {
            $productosSinStock[] = $item;
        } else {
            $productosEntrega[] = $item;
            $totalCantidad += (int)$item['cantidad'];
        }
    }

    /*
    =====================================================
    DATOS GENERALES DE LA ORDEN
    =====================================================
    */

    $primero = $datosOrden[0];

    /*
    =====================================================
    NOMBRE DEL HOTEL
    =====================================================
    */

    if (!empty($primero["nombreHotel"])) {
        $nombreHotel = utf8_encode(
            trim($primero["nombreHotel"])
        );
    } else {
        $nombreHotel = "Hotel no identificado";
    }

    /*
    =====================================================
    FECHA DE LA ORDEN
    =====================================================
    */

    $fechaOrden = !empty($primero["fecha"])
        ? date(
            "d-m-Y H:i",
            strtotime($primero["fecha"])
        )
        : "";

    /*
    =====================================================
    NOMBRE DE QUIEN REALIZÓ / SOLICITÓ
    =====================================================
    */

    $nombre = isset($primero["nombre"])
        ? trim($primero["nombre"])
        : "";

    $apellido = isset($primero["apellido"])
        ? trim($primero["apellido"])
        : "";

    $nombreSolicitante = trim(
        $nombre . " " . $apellido
    );

    if ($nombreSolicitante != "") {
        $nombreSolicitante = utf8_encode(
            $nombreSolicitante
        );
    } else {

        /*
        Si todavía no existe relación con tblusuario,
        mostramos el usuario del sistema.
        */

        if (!empty($primero["usuario"])) {
            $nombreSolicitante = utf8_encode(
                trim($primero["usuario"])
            );
        } else {
            $nombreSolicitante = "Usuario no identificado";
        }
    }

    /*
    =====================================================
    TIPO DE ENTREGA
    =====================================================
    */

    $tipoEntrega = !empty($primero["tipoEntrega"])
        ? utf8_encode($primero["tipoEntrega"])
        : "No especificado";
}
?>

<style>
    .orden-wrapper {
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .orden-card {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 5px 16px rgba(0,0,0,0.10);
        overflow: hidden;
        border: 1px solid #e6e6e6;
    }

    .orden-header {
        background: linear-gradient(135deg, #198754, #157347);
        color: #fff;
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.15);
    }

    .orden-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .orden-header .subtexto {
        margin-top: 3px;
        font-size: 12px;
        opacity: 0.95;
    }

    .acciones-orden {
        padding: 8px 12px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        text-align: right;
    }

    .acciones-orden .btn {
        margin-left: 6px;
    }

    .orden-info {
        padding: 12px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .info-box {
        background: #fff;
        border-radius: 10px;
        padding: 10px 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        border: 1px solid #ebeff2;
        margin-bottom: 10px;
        min-height: 72px;
    }

    .info-box .titulo {
        font-size: 11px;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: .3px;
    }

    .info-box .valor {
        font-size: 15px;
        color: #212529;
        font-weight: bold;
        line-height: 1.2;
        word-break: break-word;
    }

    .tabla-contenedor {
        padding: 12px;
    }

    .tabla-contenedor h4 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #198754;
        font-weight: bold;
        font-size: 16px;
    }

    #tabla {
        margin-bottom: 10px;
    }

    #tabla thead tr {
        background: #198754;
        color: #fff;
    }

    #tabla th {
        font-size: 12px;
        padding: 8px;
        vertical-align: middle !important;
    }

    #tabla td {
        font-size: 13px;
        padding: 8px;
        vertical-align: middle !important;
    }

    #tabla tbody tr:hover {
        background-color: #f3fbf6;
    }

    .badge-cantidad {
        display: inline-block;
        background: #198754;
        color: #fff;
        font-size: 13px;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 18px;
        min-width: 38px;
        text-align: center;
    }

    .codigo-producto {
        font-size: 11px;
        color: #6c757d;
        display: block;
        margin-top: 2px;
    }

    .firma-area {
        margin-top: 18px;
        padding-top: 10px;
    }

    .firma-linea {
        width: 240px;
        border-top: 1px solid #333;
        margin-top: 30px;
        padding-top: 5px;
        font-size: 13px;
        text-align: center;
    }

    .alert-custom {
        margin-top: 10px;
    }

    .sin-datos {
        margin-top: 20px;
    }

    .orden-sin-stock {
        margin-top: 20px;
        padding: 12px;
        border: 1px solid #e7c487;
        border-radius: 10px;
        background: #fffaf0;
    }
    .orden-sin-stock h4 { color: #805000; }
    .sin-stock-nota { font-size: 12px; color: #634b25; margin-bottom: 10px; }
    .tabla-sin-stock { width: 100%; margin-bottom: 8px; }
    .tabla-sin-stock th, .tabla-sin-stock td { padding: 8px; font-size: 13px; vertical-align: middle !important; }
    .tabla-sin-stock thead { background: #fff0cc; color: #634000; }
    .cantidad-sin-stock { display: inline-block; padding: 5px 10px; border: 1px solid #a16b19; border-radius: 18px; font-weight: bold; color: #805000; }
    .estado-sin-stock { display: block; font-size: 11px; margin-top: 4px; color: #805000; font-weight: bold; }
    .sin-stock-resumen { margin: 0; font-size: 12px; text-align: right; }

    @media print {
        .orden-card { overflow: visible !important; }
        .print-area .table-responsive { overflow: visible !important; }
        .print-area thead { display: table-header-group; }
        .print-area tr, .firma-area { break-inside: avoid; page-break-inside: avoid; }
        .orden-sin-stock h4, .sin-stock-nota { break-after: avoid; page-break-after: avoid; }
        .orden-sin-stock { background: #fff !important; border-color: #777; }
        .tabla-sin-stock thead { background: #f0f0f0 !important; color: #000; }

        body * {
            visibility: hidden !important;
        }

        .print-area,
        .print-area * {
            visibility: visible !important;
        }

        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .acciones-orden,
        .navbar,
        .main-sidebar,
        .main-header,
        .main-footer,
        .content-header,
        .no-print {
            display: none !important;
        }

        .orden-wrapper {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .orden-card {
            box-shadow: none !important;
            border: 1px solid #cfcfcf !important;
        }

        .orden-header {
            background: #198754 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        #tabla thead tr {
            background: #198754 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .badge-cantidad {
            background: #198754 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .info-box {
            box-shadow: none !important;
            border: 1px solid #dcdcdc !important;
        }
    }
</style>

<div class="row orden-wrapper">

    <div class="col-md-2"></div>

    <div class="col-md-8 print-area">

        <?php if (isset($_GET["success"])) { ?>

            <div class="alert alert-info alert-custom no-print" role="alert">
                Orden registrada correctamente.
            </div>

        <?php } ?>


        <?php if (isset($_GET["delete"])) { ?>

            <div class="alert alert-warning alert-custom no-print" role="alert">
                Orden eliminada correctamente.
            </div>

        <?php } ?>


        <?php if (!empty($datosOrden)) { ?>

            <div class="orden-card">


                <!-- CABECERA -->

                <div class="orden-header">

                    <h3>
                        <i class="bi bi-truck"></i>
                        Orden de Entrega N° <?php echo $id; ?>
                    </h3>

                    <div class="subtexto">
                        Detalle de productos para impresión
                    </div>

                </div>


                <!-- BOTONES -->

                <div class="acciones-orden no-print">

                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        onclick="window.history.back();"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Volver
                    </button>

                    <button
                        type="button"
                        class="btn btn-success btn-sm"
                        onclick="window.print();"
                    >
                        <i class="bi bi-printer"></i>
                        Imprimir
                    </button>

                </div>


                <!-- INFORMACIÓN DE LA ORDEN -->

                <div class="orden-info">

                    <div class="row">


                        <!-- NUMERO -->

                        <div class="col-md-3 col-sm-6">

                            <div class="info-box">

                                <div class="titulo">
                                    N° Orden
                                </div>

                                <div class="valor">
                                    <?php echo $id; ?>
                                </div>

                            </div>

                        </div>


                        <!-- FECHA -->

                        <div class="col-md-3 col-sm-6">

                            <div class="info-box">

                                <div class="titulo">
                                    Fecha
                                </div>

                                <div class="valor">
                                    <?php echo $fechaOrden; ?>
                                </div>

                            </div>

                        </div>


                        <!-- USUARIO -->

                        <div class="col-md-3 col-sm-6">

                            <div class="info-box">

                                <div class="titulo">
                                    Entregado por:
                                </div>

                                <div class="valor">
                                    <?php echo $nombreSolicitante; ?>
                                </div>

                            </div>

                        </div>


                        <!-- HOTEL -->

                        <div class="col-md-3 col-sm-6">

                            <div class="info-box">

                                <div class="titulo">
                                    Solicitado por:
                                </div>

                                <div class="valor">
                                    <?php echo $nombreHotel; ?>
                                </div>

                            </div>

                        </div>


                    </div>

                </div>


                <!-- PRODUCTOS -->

                <div class="tabla-contenedor">

                    <h4>
                        <i class="bi bi-box-seam"></i>
                        Productos para entrega
                    </h4>


                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-hover table-striped"
                            id="tabla"
                        >

                            <thead>

                                <tr>

                                    <th style="width:12%; text-align:center;">
                                        Cant.
                                    </th>

                                    <th style="width:58%;">
                                        Producto
                                    </th>

                                    <th style="width:30%;">
                                        Tipo
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php if (empty($productosEntrega)) { ?>
                                    <tr>
                                        <td colspan="3" style="text-align:center; padding:16px;">
                                            Esta orden no contiene unidades para entregar.
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php foreach ($productosEntrega as $row) { ?>

                                    <tr>

                                        <td style="text-align:center;">

                                            <span class="badge-cantidad">

                                                <?php
                                                echo (int)$row['cantidad'];
                                                ?>

                                            </span>

                                        </td>


                                        <td>

                                            <?php
                                            echo utf8_encode(
                                                $row['nombreProducto']
                                            );
                                            ?>

                                            <?php if (!empty($row['codigoBarra'])) { ?>

                                                <span class="codigo-producto">

                                                    Código:

                                                    <?php
                                                    echo utf8_encode(
                                                        $row['codigoBarra']
                                                    );
                                                    ?>

                                                </span>

                                            <?php } ?>

                                        </td>


                                        <td>

                                            <?php
                                            echo utf8_encode(
                                                $row['nombreTipoProducto']
                                            );
                                            ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>

                    </div>


                    <!-- TOTAL -->

                    <div style="
                        margin-top:12px;
                        padding:10px;
                        background:#f3fbf6;
                        border-radius:10px;
                        text-align:right;
                        font-weight:bold;
                    ">

                        <i class="bi bi-box-seam"></i>

                        Total de unidades para entrega:

                        <span style="
                            background:#198754;
                            color:white;
                            padding:5px 12px;
                            border-radius:20px;
                            margin-left:5px;
                        ">

                            <?php echo $totalCantidad; ?>

                        </span>

                    </div>


                    <?php if (!empty($productosSinStock)) { ?>
                    <section class="orden-sin-stock">
                        <h4>Productos sin stock</h4>
                        <p class="sin-stock-nota">
                            Productos registrados en esta orden con cantidad 0.
                            No se entregaron unidades ni se descontó inventario por estos productos.
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered tabla-sin-stock">
                                <thead>
                                    <tr>
                                        <th style="width:12%;text-align:center;">Cant.</th>
                                        <th style="width:58%;">Producto</th>
                                        <th style="width:30%;">Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productosSinStock as $rowSinStock) { ?>
                                    <tr>
                                        <td style="text-align:center;"><span class="cantidad-sin-stock">0</span></td>
                                        <td>
                                            <?php echo htmlspecialchars(utf8_encode($rowSinStock['nombreProducto']), ENT_QUOTES, 'UTF-8'); ?>
                                            <?php if (!empty($rowSinStock['codigoBarra'])) { ?>
                                            <span class="codigo-producto">Código: <?php echo htmlspecialchars(utf8_encode($rowSinStock['codigoBarra']), ENT_QUOTES, 'UTF-8'); ?></span>
                                            <?php } ?>
                                            <span class="estado-sin-stock">Sin stock · No entregado</span>
                                        </td>
                                        <td><?php echo htmlspecialchars(utf8_encode((string)$rowSinStock['nombreTipoProducto']), ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <p class="sin-stock-resumen">Productos sin stock: <strong><?php echo count($productosSinStock); ?></strong></p>
                    </section>
                    <?php } ?>

                    <!-- FIRMA -->

                    <div class="firma-area">

                        <div class="firma-linea">
                            Firma de Recepción
                        </div>

                    </div>


                </div>

            </div>


        <?php } else { ?>


            <div class="container sin-datos">

                <div class="alert alert-danger alert-dismissable">

                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                    >
                        &times;
                    </button>

                    <h4>

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        Aviso

                    </h4>

                    No hay datos para mostrar para esta orden.

                </div>

            </div>


        <?php } ?>

    </div>


    <div class="col-md-2"></div>

</div>

</div>