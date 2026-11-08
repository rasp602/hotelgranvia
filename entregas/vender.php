<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";

if (empty($_SESSION['usuario'])) {
    header("location: login.php");
    exit;
}

$_SESSION['lista'] = (isset($_SESSION['lista']) && is_array($_SESSION['lista'])) ? $_SESSION['lista'] : [];

$clientes = obtenerClientes();
$clienteSeleccionado = (isset($_SESSION['clienteVenta']) && !empty($_SESSION['clienteVenta']))
    ? obtenerClientePorId($_SESSION['clienteVenta'])
    : null;

require('bd/conexionLocal.php');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

date_default_timezone_set("America/Santiago");

$consultaEstado = mysqli_query($con, "SELECT MAX(id) AS ultimo FROM ventas");
$ultimoId = 1;
if ($row = mysqli_fetch_assoc($consultaEstado)) {
    $ultimoId = ((int)$row['ultimo']) + 1;
}

function obtenerMensajeFlashVenta() {
    if (isset($_SESSION['mensaje_venta'])) {
        $mensaje = $_SESSION['mensaje_venta'];
        unset($_SESSION['mensaje_venta']);
        return $mensaje;
    }
    return null;
}

function obtenerNombreUsuarioActual() {
    if (isset($_SESSION['usuario'])) {
        if (is_object($_SESSION['usuario'])) {
            if (isset($_SESSION['usuario']->usuario)) return $_SESSION['usuario']->usuario;
            if (isset($_SESSION['usuario']->nombre)) return $_SESSION['usuario']->nombre;
        }
        if (is_array($_SESSION['usuario'])) {
            if (isset($_SESSION['usuario']['usuario'])) return $_SESSION['usuario']['usuario'];
            if (isset($_SESSION['usuario']['nombre'])) return $_SESSION['usuario']['nombre'];
        }
    }
    return 'Usuario';
}

function obtenerImagenProducto($producto) {
    $rutaBaseWeb = "../../hotelgranvia/img/productos/";
    $rutaBaseFisica = $_SERVER['DOCUMENT_ROOT'] . "../../hotelgranvia/img/productos/";

    $camposPosibles = ['imagen', 'imagenProducto', 'foto', 'fotoProducto', 'rutaImagen', 'urlImagen'];

    foreach ($camposPosibles as $campo) {
        if (isset($producto->$campo) && !empty($producto->$campo)) {
            return $rutaBaseWeb . $producto->$campo;
        }
    }

    if (isset($producto->idProducto)) {
        $id = $producto->idProducto;

        if (file_exists($rutaBaseFisica . $id . ".jpg")) return $rutaBaseWeb . $id . ".jpg";
        if (file_exists($rutaBaseFisica . $id . ".png")) return $rutaBaseWeb . $id . ".png";
        if (file_exists($rutaBaseFisica . $id . ".jpeg")) return $rutaBaseWeb . $id . ".jpeg";
        if (file_exists($rutaBaseFisica . $id . ".webp")) return $rutaBaseWeb . $id . ".webp";
    }

    return "https://via.placeholder.com/160x120?text=Producto";
}

function cantidadTotalItems($lista) {
    $total = 0;
    foreach ($lista as $item) {
        $total += isset($item->cantidad) ? (int)$item->cantidad : 1;
    }
    return $total;
}

function totalReferencialItems($lista) {
    $total = 0;
    foreach ($lista as $item) {
        $cantidad = isset($item->cantidad) ? (int)$item->cantidad : 1;
        $precio = 0;
        if (isset($item->precioVenta)) $precio = (float)$item->precioVenta;
        elseif (isset($item->precio)) $precio = (float)$item->precio;
        elseif (isset($item->precioProducto)) $precio = (float)$item->precioProducto;
        $total += $cantidad * $precio;
    }
    return $total;
}

$flash = obtenerMensajeFlashVenta();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['updateCantidad'])) {
    $productoId = isset($_POST['productoId']) ? (int)$_POST['productoId'] : 0;
    $nuevaCantidad = isset($_POST['nuevaCantidad']) ? (int)$_POST['nuevaCantidad'] : 1;

    if ($nuevaCantidad < 1) {
        $nuevaCantidad = 1;
    }

    foreach ($_SESSION['lista'] as &$producto) {
        if ((int)$producto->idProducto === $productoId) {
            $existencia = isset($producto->existenciaProducto) ? (int)$producto->existenciaProducto : $nuevaCantidad;

            if ($existencia <= 0) {
                $producto->cantidad = 1;
                $_SESSION['mensaje_venta'] = [
                    'tipo' => 'warning',
                    'texto' => 'Este producto ya no tiene stock disponible.'
                ];
            } elseif ($nuevaCantidad > $existencia) {
                $producto->cantidad = $existencia;
                $_SESSION['mensaje_venta'] = [
                    'tipo' => 'warning',
                    'texto' => 'La cantidad fue ajustada al stock disponible.'
                ];
            } else {
                $producto->cantidad = $nuevaCantidad;
                $_SESSION['mensaje_venta'] = [
                    'tipo' => 'success',
                    'texto' => 'Cantidad actualizada correctamente.'
                ];
            }
            break;
        }
    }
    unset($producto);

    header("Location: vender.php#bloque-productos");
    exit;
}

$totalItems = cantidadTotalItems($_SESSION['lista']);
$totalReferencial = totalReferencialItems($_SESSION['lista']);
$usuarioActual = obtenerNombreUsuarioActual();
?>
<style>
    :root{
        --jumbo-1:#2e7d32;
        --jumbo-2:#43a047;
        --jumbo-3:#66bb6a;
        --jumbo-4:#e8f5e9;
        --jumbo-5:#f4fbf4;
        --jumbo-6:#1f5f24;
        --txt:#1e293b;
        --danger:#e53935;
        --warning:#ffb300;
        --shadow:0 12px 35px rgba(46,125,50,.14);
        --radius:18px;
    }

    html{
        scroll-behavior:smooth;
    }

    body{
        background:#f3f7f3;
    }

    .entrega-wrapper{
        background: linear-gradient(180deg, #f9fffa 0%, #eef8ef 100%);
        border-radius: 28px;
        padding: 22px;
        box-shadow: var(--shadow);
        animation: fadeInUp .45s ease;
        max-width: 1400px;
        margin: 0 auto;
    }

    .hero-entrega{
        background: linear-gradient(135deg, var(--jumbo-1), var(--jumbo-2));
        color: #fff;
        border-radius: 24px;
        padding: 20px 24px;
        margin-bottom: 18px;
        box-shadow: 0 18px 40px rgba(46,125,50,.25);
        position: relative;
        overflow: hidden;
    }

    .hero-entrega::after{
        content:'';
        position:absolute;
        right:-40px;
        top:-40px;
        width:180px;
        height:180px;
        background:rgba(255,255,255,.08);
        border-radius:50%;
    }

    .hero-chip{
        display:inline-flex;
        align-items:center;
        gap:8px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.22);
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 13px;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .card-soft{
        background:#fff;
        border:none;
        border-radius:var(--radius);
        box-shadow: var(--shadow);
    }

    .card-soft .card-header{
        border-bottom:none;
        background:transparent;
        padding-bottom:0;
    }

    .section-title{
        color:var(--jumbo-6);
        font-weight:700;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .btn-jumbo{
        background: linear-gradient(135deg, var(--jumbo-1), var(--jumbo-2));
        border:none;
        color:#fff;
        border-radius: 14px;
        padding: 11px 18px;
        font-weight:700;
        box-shadow: 0 10px 20px rgba(67,160,71,.24);
        transition: all .25s ease;
    }

    .btn-jumbo:hover{
        transform: translateY(-2px);
        color:#fff;
        box-shadow: 0 14px 28px rgba(67,160,71,.32);
    }

    .btn-warning-soft{
        background:#fff8e1;
        color:#f57f17;
        border:none;
        border-radius:12px;
        font-weight:700;
    }

    .btn-danger-soft{
        background:#ffebee;
        color:#c62828;
        border:none;
        border-radius:12px;
        font-weight:700;
    }

    .info-pill{
        background: var(--jumbo-4);
        color: var(--jumbo-6);
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 700;
        display:inline-flex;
        align-items:center;
        gap:8px;
    }

    .select2-container{
        width:100% !important;
    }

    .select2-container--default .select2-selection--single{
        height: 56px !important;
        border-radius: 16px !important;
        border:1px solid #dfe7df !important;
        padding: 10px 14px !important;
        display:flex !important;
        align-items:center !important;
        box-shadow:none !important;
        background:#fff !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 34px !important;
        padding-left: 0 !important;
        color: #334155 !important;
        font-weight: 600;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 54px !important;
        right: 10px !important;
    }

    .select2-dropdown{
        border-radius:16px !important;
        overflow:hidden !important;
        border:1px solid #dfe7df !important;
        box-shadow: 0 18px 30px rgba(0,0,0,.08) !important;
    }

    .select2-search--dropdown{
        padding: 10px !important;
        background: #f8fff8;
        border-bottom: 1px solid #edf4ed;
    }

    .select2-search__field{
        border-radius: 12px !important;
        border: 1px solid #cfe3d1 !important;
        padding: 10px 12px !important;
        min-height: 42px;
    }

    .producto-card{
        border:1px solid #edf4ed;
        border-radius:18px;
        padding:16px;
        background:#fff;
        transition:all .22s ease;
        height:100%;
    }

    .producto-card:hover{
        transform:translateY(-3px);
        box-shadow:0 14px 30px rgba(46,125,50,.10);
        border-color:#cae5cc;
    }

    .producto-img{
        width:96px;
        height:96px;
        border-radius:18px;
        object-fit:cover;
        background:#f3f7f3;
        border:1px solid #edf4ed;
    }

    .stock-badge{
        display:inline-block;
        padding:5px 10px;
        border-radius:999px;
        background:#edf7ee;
        color:#2e7d32;
        font-size:12px;
        font-weight:700;
    }

    .stock-badge.low{
        background:#fff3e0;
        color:#ef6c00;
    }

    .qty-box{
        width:90px;
        border-radius:12px;
        text-align:center;
        border:1px solid #dbe8dc;
        font-weight:700;
    }

    .empty-state{
        padding:32px 18px;
        text-align:center;
        border:2px dashed #d9e9da;
        border-radius:18px;
        background:#fbfffb;
    }

    .toast-floating{
        position: fixed;
        top: 18px;
        right: 18px;
        z-index: 9999;
        min-width: 290px;
        border-radius: 16px;
        box-shadow: 0 18px 40px rgba(0,0,0,.15);
        animation: slideInRight .35s ease;
    }

    .estado-cliente{
        background: linear-gradient(135deg, #ffffff, #f3fbf3);
        border:1px solid #d9eadb;
        border-radius:20px;
        padding:16px;
    }

    .mini-stat{
        background:#fff;
        border-radius:16px;
        padding:14px;
        box-shadow:0 10px 24px rgba(46,125,50,.08);
        height:100%;
    }

    .mini-stat h4{
        margin:0;
        font-size:22px;
        color:var(--jumbo-6);
        font-weight:800;
    }

    .select2-producto{
        display:flex;
        align-items:center;
        gap:12px;
        padding:6px 2px;
    }

    .select2-producto__img{
        width:52px;
        height:52px;
        border-radius:12px;
        object-fit:cover;
        border:1px solid #e5efe5;
        background:#f4f8f4;
        flex-shrink:0;
    }

    .select2-producto__title{
        font-weight:700;
        color:#1f2937;
        line-height:1.2;
        margin-bottom:3px;
    }

    .select2-producto__sub{
        font-size:12px;
        color:#64748b;
    }

    .select2-producto__stock{
        display:inline-block;
        margin-top:4px;
        border-radius:999px;
        padding:3px 8px;
        font-size:11px;
        color:#fff;
    }

    .compact-card .card-body{
        padding:16px 18px;
    }

    .compact-label{
        font-size:13px;
        font-weight:700;
        color:#4b5563;
        margin-bottom:6px;
    }

    .bloque-productos{
        scroll-margin-top: 90px;
    }

    .resumen-bottom .resumen-line{
        display:flex;
        justify-content:space-between;
        padding:10px 0;
        border-bottom:1px dashed #e6eee6;
    }

    .acciones-bottom{
        position: sticky;
        bottom: 10px;
        z-index: 10;
    }

    @keyframes fadeInUp{
        from{opacity:0; transform:translateY(14px);}
        to{opacity:1; transform:translateY(0);}
    }

    @keyframes slideInRight{
        from{opacity:0; transform:translateX(25px);}
        to{opacity:1; transform:translateX(0);}
    }

    @media (max-width: 991px){
        .hero-entrega{
            padding:18px;
        }

        .producto-img{
            width:82px;
            height:82px;
        }

        .acciones-bottom{
            position: static;
        }

        .entrega-wrapper{
            padding:14px;
            border-radius:20px;
        }
    }

    .buscador-sticky-top{
        position: sticky;
        top: 10px;
        z-index: 1020;
    }

    .buscador-sticky-top .card-soft{
        box-shadow: 0 12px 30px rgba(46,125,50,.18);
        border: 1px solid #dcebdc;
    }

    @media (max-width: 991px){
        .buscador-sticky-top{
            top: 8px;
        }
    }
</style>

<div class="container-fluid py-3 px-2 px-sm-3 px-md-4">
    <div class="entrega-wrapper">

        <?php if ($flash) { ?>
            <div class="alert alert-<?php echo htmlspecialchars($flash['tipo']); ?> toast-floating">
                <strong>
                    <?php
                    if ($flash['tipo'] === 'success') echo 'Éxito';
                    elseif ($flash['tipo'] === 'warning') echo 'Atención';
                    elseif ($flash['tipo'] === 'error' || $flash['tipo'] === 'danger') echo 'Error';
                    else echo 'Información';
                    ?>:
                </strong>
                <?php echo htmlspecialchars($flash['texto']); ?>
            </div>
        <?php } ?>

        <div class="hero-entrega">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-2"><i class="fa fa-truck me-2"></i>Sistema de Entregas</h2>
                    <p class="mb-3" style="opacity:.92;">
                        Interfaz optimizada para preparar, revisar y cerrar entregas de forma rápida, visual y amigable.
                    </p>

                    <span class="hero-chip"><i class="fa fa-user"></i> <?php echo htmlspecialchars($usuarioActual); ?></span>
                    <span class="hero-chip"><i class="fa fa-shopping-basket"></i> <?php echo $totalItems; ?> item(s)</span>
                    <span class="hero-chip"><i class="fa fa-list-ol"></i> Orden #<?php echo $ultimoId; ?></span>
                </div>
                <div class="col-lg-4">
                    <div class="row g-2 mt-2 mt-lg-0">
                        <div class="col-6">
                            <div class="mini-stat">
                                <small>Productos</small>
                                <h4><?php echo count($_SESSION['lista']); ?></h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mini-stat">
                                <small>Unidades</small>
                                <h4><?php echo $totalItems; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">

                <div class="card card-soft compact-card mb-3">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fa fa-map-marker-alt"></i>
                            Lugar de entrega
                        </h5>

                        <form class="row g-2 align-items-end js-keep-products-view" method="post" action="establecer_cliente_venta.php">
                            <div class="col-lg-9 col-md-8">
                                <label class="compact-label">Selecciona un lugar</label>
                                <select class="form-select" name="idCliente" required>
                                    <option value="">Selecciona un lugar</option>
                                    <?php foreach($clientes as $cliente) { ?>
                                        <option value="<?php echo $cliente->idHotel; ?>"
                                            <?php echo ($clienteSeleccionado && (int)$clienteSeleccionado->idHotel === (int)$cliente->idHotel) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cliente->nombreHotel); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-4 d-grid">
                                <button class="btn btn-jumbo" type="submit">
                                    <i class="fa fa-check-circle me-2"></i>Seleccionar
                                </button>
                            </div>
                        </form>

                        <?php if($clienteSeleccionado){ ?>
                            <div class="estado-cliente mt-3">
                                <div class="row align-items-center">
                                    <div class="col-md-9">
                                        <div class="section-title mb-2" style="font-size:16px;">
                                            <i class="fa fa-building"></i>
                                            Destino activo
                                        </div>
                                        <div><strong>Nombre:</strong> <?php echo htmlspecialchars($clienteSeleccionado->nombreHotel); ?></div>
                                        <div><strong>Capacidad:</strong> <?php echo htmlspecialchars($clienteSeleccionado->capacidadHotel); ?></div>
                                        <div><strong>Dirección:</strong> <?php echo htmlspecialchars($clienteSeleccionado->direccion); ?></div>
                                    </div>
                                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                        <a href="quitar_cliente_venta.php#bloque-productos" class="btn btn-warning-soft js-keep-products-link">
                                            <i class="fa fa-times-circle me-1"></i>Quitar lugar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php if($clienteSeleccionado){ ?>
                <div class="buscador-sticky-top mb-3">
                    <div class="card card-soft">
                        <div class="card-body">
                            <h5 class="section-title mb-3">
                                <i class="fa fa-search"></i>
                                Agregar productos a la entrega
                            </h5>

                            <form action="agregar_producto_venta.php" method="post" class="row g-3 align-items-end js-keep-products-view">
                                <div class="col-lg-10 col-md-9">
                                    <label class="form-label fw-bold">Buscar producto por nombre o código</label>
                                    <select class="form-control form-control-lg" id="codigo" name="codigo" required></select>
                                </div>
                                <div class="col-lg-2 col-md-3 d-grid">
                                    <input type="hidden" value="<?php echo $ultimoId; ?>" name="idVenta" id="idVenta">
                                    <button type="submit" name="agregar" class="btn btn-jumbo btn-lg">
                                        <i class="fa fa-plus-circle me-2"></i>Agregar
                                    </button>
                                </div>
                            </form>

                            <div class="mt-3">
                                <span class="info-pill"><i class="fa fa-lightbulb"></i>Al tocar el buscador, queda listo para escribir al instante.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-soft mb-3 bloque-productos" id="bloque-productos">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h4 class="section-title mb-0">
                                <i class="fa fa-box-open"></i>
                                Productos cargados para entrega
                            </h4>
                            <span class="info-pill"><i class="fa fa-cubes"></i><?php echo $totalItems; ?> unidad(es)</span>
                        </div>

                        <?php if(!empty($_SESSION['lista'])) { ?>
                            <div class="row g-3">
                                <?php foreach($_SESSION['lista'] as $lista) { 
                                    $imagen = obtenerImagenProducto($lista);
                                    $existencia = isset($lista->existenciaProducto) ? (int)$lista->existenciaProducto : 0;
                                    $cantidad = isset($lista->cantidad) ? (int)$lista->cantidad : 1;
                                    $stockClass = ($existencia <= 5) ? 'low' : '';
                                ?>
                                    <div class="col-12">
                                        <div class="producto-card">
                                            <div class="row align-items-center g-3">
                                                <div class="col-lg-1 col-md-2 col-3 text-center">
                                                    <img src="<?php echo htmlspecialchars($imagen); ?>" class="producto-img" alt="Producto">
                                                </div>

                                                <div class="col-lg-5 col-md-4 col-9">
                                                    <h5 class="mb-1"><?php echo htmlspecialchars($lista->nombreProducto); ?></h5>
                                                    <div class="text-muted small mb-2">
                                                        Código: <?php echo htmlspecialchars($lista->codigoBarra); ?>
                                                    </div>
                                                    <span class="stock-badge <?php echo $stockClass; ?>">
                                                        <i class="fa fa-warehouse me-1"></i>Stock: <?php echo $existencia; ?>
                                                    </span>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-6">
                                                    <label class="form-label fw-bold mb-2">Cantidad</label>
                                                    <form action="" method="post" class="d-flex align-items-center gap-2 js-keep-products-view">
                                                        <input type="hidden" name="productoId" value="<?php echo (int)$lista->idProducto; ?>">
                                                        <input
                                                            type="number"
                                                            name="nuevaCantidad"
                                                            value="<?php echo $cantidad; ?>"
                                                            min="1"
                                                            max="<?php echo max(1, $existencia); ?>"
                                                            onchange="this.form.submit()"
                                                            class="form-control qty-box"
                                                        >
                                                        <input type="hidden" name="updateCantidad" value="1">
                                                    </form>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-6 text-md-end text-start">
                                                    <a href="quitar_producto_venta.php?idProducto=<?php echo (int)$lista->idProducto; ?>#bloque-productos" class="btn btn-danger-soft js-keep-products-link">
                                                        <i class="fa fa-trash me-1"></i>Quitar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="empty-state">
                                <div style="font-size:52px; color:#81c784;" class="mb-3">
                                    <i class="fa fa-truck-loading"></i>
                                </div>
                                <h4 class="mb-2">Aún no hay productos en la entrega</h4>
                                <p class="text-muted mb-0">Busca productos arriba y agrégalos para comenzar a preparar la orden.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="card card-soft mb-3 resumen-bottom">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fa fa-clipboard-list"></i>
                            Resumen de la entrega
                        </h5>

                        <div class="resumen-line">
                            <span>Orden</span>
                            <strong>#<?php echo $ultimoId; ?></strong>
                        </div>
                        <div class="resumen-line">
                            <span>Productos distintos</span>
                            <strong><?php echo count($_SESSION['lista']); ?></strong>
                        </div>
                        <div class="resumen-line">
                            <span>Unidades totales</span>
                            <strong><?php echo $totalItems; ?></strong>
                        </div>
                        <div class="resumen-line">
                            <span>Total referencial</span>
                            <strong>$<?php echo number_format($totalReferencial, 0, ',', '.'); ?></strong>
                        </div>
                        <div class="resumen-line" style="border-bottom:none;">
                            <span>Destino</span>
                            <strong>
                                <?php echo $clienteSeleccionado ? htmlspecialchars($clienteSeleccionado->nombreHotel) : 'Sin seleccionar'; ?>
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="card card-soft acciones-bottom">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fa fa-check-double"></i>
                            Acciones
                        </h5>

                        <?php if($clienteSeleccionado && !empty($_SESSION['lista'])) { ?>
                            <form action="registrar_venta.php" method="post" class="d-grid gap-2 js-keep-products-view">
                                <button class="btn btn-jumbo btn-lg" type="submit">
                                    <i class="fa fa-paper-plane me-2"></i>Terminar orden de entrega
                                </button>
                            </form>
                        <?php } else { ?>
                            <button class="btn btn-secondary btn-lg w-100" disabled>
                                <i class="fa fa-lock me-2"></i>Completa lugar y productos
                            </button>
                        <?php } ?>

                        <div class="d-grid gap-2 mt-2">
                            <a class="btn btn-danger-soft btn-lg js-keep-products-link" href="cancelar_venta.php#bloque-productos">
                                <i class="fa fa-times me-2"></i>Cancelar orden
                            </a>
                        </div>
                    </div>
                </div>

                <?php } else { ?>
                    <div class="card card-soft">
                        <div class="card-body">
                            <div class="empty-state">
                                <div style="font-size:52px; color:#81c784;" class="mb-3">
                                    <i class="fa fa-map-marked-alt"></i>
                                </div>
                                <h4 class="mb-2">Primero selecciona un lugar de entrega</h4>
                                <p class="text-muted mb-0">Después de elegir el destino, se activará el buscador de productos y el carrito de entrega.</p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
jQuery(document).ready(function() {

    function formatoProducto(item) {
        if (!item.id) {
            return item.text || item.nombreProducto || 'Producto';
        }

        const stock = parseInt(item.existenciaProducto || 0);
        const badgeColor = stock <= 5 ? '#ffb74d' : '#66bb6a';
        const image = item.imagen && item.imagen !== ''
            ? item.imagen
            : 'https://via.placeholder.com/52x52?text=P';

        return `
            <div class="select2-producto">
                <img src="${image}" class="select2-producto__img" alt="Producto">
                <div>
                    <div class="select2-producto__title">${item.nombreProducto || item.text}</div>
                    <div class="select2-producto__sub">Código: ${item.codigoBarra || item.id}</div>
                    <span class="select2-producto__stock" style="background:${badgeColor};">Stock: ${stock}</span>
                </div>
            </div>
        `;
    }

    jQuery('#codigo').select2({
        placeholder: 'Haz click aquí para buscar producto...',
        minimumInputLength: 0,
        width: '100%',
        allowClear: true,
        ajax: {
            url: 'buscador.php',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term || ''
                };
            },
            processResults: function (data) {
                return {
                    results: jQuery.map(data, function (item) {
                        return {
                            id: item.idProducto,
                            text: item.nombreProducto,
                            nombreProducto: item.nombreProducto,
                            codigoBarra: item.codigoBarra,
                            existenciaProducto: item.existenciaProducto,
                            imagen: item.imagen
                        };
                    })
                };
            },
            cache: true
        },
        templateResult: function(item) {
            return item.loading ? item.text : jQuery(formatoProducto(item));
        },
        templateSelection: function(item) {
            return item.nombreProducto || item.text || 'Buscar producto...';
        },
        escapeMarkup: function(markup) { return markup; }
    });

    jQuery(document).on('click', '.select2-selection--single', function() {
        jQuery('#codigo').select2('open');
    });

    jQuery('#codigo').on('select2:open', function() {
        setTimeout(function() {
            const campoBusqueda = document.querySelector('.select2-container--open .select2-search__field');
            if (campoBusqueda) {
                campoBusqueda.focus();
            }
        }, 50);
    });

    setTimeout(function(){
        jQuery('.toast-floating').fadeOut(500);
    }, 2800);

    function guardarVistaProductos() {
        sessionStorage.setItem('volver_productos_entrega', '1');
    }

    jQuery(document).on('submit', '.js-keep-products-view', function() {
        guardarVistaProductos();
    });

    jQuery(document).on('click', '.js-keep-products-link', function() {
        guardarVistaProductos();
    });

    if (window.location.hash === '#bloque-productos' || sessionStorage.getItem('volver_productos_entrega') === '1') {
        setTimeout(function() {
            const bloque = document.getElementById('bloque-productos');
            if (bloque) {
                bloque.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            sessionStorage.removeItem('volver_productos_entrega');
        }, 120);
    }
});
</script>