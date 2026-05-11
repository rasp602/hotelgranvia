<script src="producto/js/ajaxProducto.js"></script>

<?php 
$usuario = null;
if (isset($_SESSION["usuarioInventario"])) {
    $usuario = $_SESSION["usuarioInventario"];
    if ($usuario->nivel == "U") {
        include_once 'menu_principal/vista/Menu_Usuarios.php'; 
    } elseif ($usuario->nivel == "F") {
        include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
    } elseif ($usuario->nivel == "I") {
        include_once 'menu_principal/vista/Menu_Inventario.php';   
    } 
}
?> 

<style>
    .stock-page {
        padding: 20px 0 35px 0;
    }

    .stock-shell {
        max-width: 1400px;
        margin: 0 auto;
    }

    .stock-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
        overflow: hidden;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .stock-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        padding: 22px 18px;
        text-align: center;
    }

    .stock-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
    }

    .stock-header p {
        margin: 8px 0 0 0;
        font-size: 14px;
        opacity: .95;
    }

    .stock-body {
        background: #f8fafc;
        padding: 22px;
    }

    .form-panel,
    .producto-panel,
    .ultimo-panel {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 20px;
    }

    .form-group label,
    .label-modern {
        font-weight: 700;
        color: #344054;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        min-height: 46px;
        border-radius: 10px !important;
        border: 1px solid #d0d5dd !important;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15) !important;
    }

    .input-icon-wrap {
        position: relative;
    }

    .input-icon-wrap .icon-badge {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #0d6efd;
        font-size: 18px;
        pointer-events: none;
    }

    .btn-modern {
        min-height: 46px;
        border-radius: 10px;
        font-weight: 700;
    }

    .btn-block-modern {
        width: 100%;
    }

    .producto-info-wrap {
        display: flex;
        gap: 18px;
        align-items: center;
        flex-wrap: wrap;
    }

    .producto-img-box {
        width: 130px;
        height: 130px;
        border-radius: 16px;
        background: linear-gradient(135deg, #eef4ff, #dbeafe);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #dbe4f0;
        flex-shrink: 0;
    }

    .producto-img-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        padding: 8px;
    }

    .producto-datos {
        flex: 1;
        min-width: 220px;
    }

    .producto-titulo {
        font-size: 22px;
        font-weight: 700;
        color: #1d2939;
        margin-bottom: 10px;
    }

    .dato-linea {
        margin-bottom: 8px;
        font-size: 15px;
        color: #475467;
    }

    .dato-linea strong {
        color: #0d6efd;
    }

    .stock-badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        background: #e9f9ee;
        color: #198754;
    }

    .mensaje-resultado {
        margin-top: 14px;
        padding: 12px 14px;
        border-radius: 12px;
        font-weight: 600;
    }

    .mensaje-ok {
        background: #e9f9ee;
        color: #198754;
        border: 1px solid #c9edd5;
    }

    .mensaje-error {
        background: #fdecec;
        color: #dc3545;
        border: 1px solid #f5c2c7;
    }

    .ultimo-ingreso-box {
        background: #f8fafc;
        border: 1px dashed #d0d5dd;
        border-radius: 14px;
        padding: 16px;
        color: #344054;
        font-size: 15px;
    }

    .modulo-titulo {
        font-size: 22px;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 15px;
        text-align: center;
    }

    .outer_div_ultimos_ingresados {
        margin-top: 15px;
    }

    .select-buscador-wrap {
        position: relative;
    }

    .select-buscador-resultados {
        display: none;
        position: absolute;
        z-index: 9999;
        width: 100%;
        max-height: 260px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #d0d5dd;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        margin-top: 4px;
    }

    .select-buscador-item {
        padding: 10px 12px;
        cursor: pointer;
        border-bottom: 1px solid #f1f3f5;
        font-size: 14px;
    }

    .select-buscador-item:hover {
        background: #eef4ff;
    }

    .select-buscador-item strong {
        color: #0d6efd;
    }

    @media (max-width: 767px) {
        .stock-page {
            padding: 10px 0 25px 0;
        }

        .stock-shell {
            padding-left: 8px;
            padding-right: 8px;
        }

        .stock-header h2 {
            font-size: 22px;
        }

        .stock-body {
            padding: 14px;
        }

        .form-panel,
        .producto-panel,
        .ultimo-panel {
            padding: 15px;
        }

        .producto-info-wrap {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .producto-img-box {
            width: 110px;
            height: 110px;
        }

        .producto-titulo {
            font-size: 19px;
        }

        .btn-modern {
            width: 100%;
        }
    }
</style>

<div class="container-fluid stock-page">
    <div class="stock-shell">

        <div class="stock-card">
            <div class="stock-header">
                <h2><i class="bi bi-qr-code-scan"></i> Ingreso de Stock por Escáner</h2>
                <p>Escanea el código del producto o búscalo manualmente por nombre/código.</p>
            </div>

            <div class="stock-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-panel">
                            <div class="modulo-titulo">
                                <i class="bi bi-upc-scan"></i> Escaneo o Búsqueda de Producto
                            </div>

                            <form id="productForm" onsubmit="return false;">

                                <div class="form-group">
                                    <label for="productBarcode">Escanea el código del producto</label>
                                    <div class="input-icon-wrap">
                                        <input type="text" id="productBarcode" name="productBarcode" class="form-control" autofocus autocomplete="off">
                                        <span class="icon-badge">
                                            <i class="fa-solid fa-barcode"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top:15px;">
                                    <label for="buscarProductoInput">O busca el producto por nombre o código</label>

                                    <div class="select-buscador-wrap">
                                        <input type="text" id="buscarProductoInput" class="form-control" placeholder="Escribe nombre o código del producto..." autocomplete="off">
                                        <div id="resultadosProductos" class="select-buscador-resultados"></div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top:15px;">
                                    <label for="quantityInput">Cantidad a ingresar</label>
                                    <input type="number" id="quantityInput" name="quantityInput" class="form-control" placeholder="Cantidad" required min="1">
                                </div>

                                <div style="margin-top:18px;">
                                    <button id="addButton" type="button" class="btn btn-success btn-modern btn-block-modern">
                                        <i class="bi bi-plus-circle"></i> Agregar al Stock
                                    </button>
                                </div>
                            </form>

                            <div class="text-center" style="margin-top:15px;">
                                <a href="?c=producto&a=menuProducto" class="btn btn-outline-primary btn-modern">
                                    <i class="bi bi-box-seam"></i> Ver Productos
                                </a>
                            </div>

                            <input type="hidden" id="barcodeScanned" />
                            <div id="result"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12" style="margin-top:0;">
                        <div id="productDetails" style="display:none;" class="producto-panel">
                            <div class="modulo-titulo">
                                <i class="bi bi-card-image"></i> Producto Detectado
                            </div>

                            <div class="producto-info-wrap">
                                <div class="producto-img-box">
                                    <img id="productImage" src="img/no-image.png" alt="Producto" onerror="this.onerror=null;this.src='img/no-image.png';">
                                </div>

                                <div class="producto-datos">
                                    <div class="producto-titulo" id="productName"></div>

                                    <div class="dato-linea">
                                        <strong>Código:</strong>
                                        <span id="productCode"></span>
                                    </div>

                                    <div class="dato-linea">
                                        <strong>Existencia actual:</strong>
                                        <span class="stock-badge" id="currentStock"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="quantitySection" style="display:none; margin-top:15px;" class="ultimo-panel">
                            <div class="modulo-titulo">
                                <i class="bi bi-clock-history"></i> Último Movimiento
                            </div>

                            <div class="ultimo-ingreso-box" id="lastScanned">
                                Aún no se ha registrado ningún movimiento.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stock-card">
            <div class="stock-header">
                <h2><i class="bi bi-box-arrow-in-down"></i> Últimos Productos Ingresados</h2>
                <p>Historial reciente de ingresos a stock.</p>
            </div>

            <div class="stock-body">
                <div class="outer_div_ultimos_ingresados"></div>
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {
    let inputBuffer = '';
    let timer;
    let timerBuscador;

    const RUTA_IMAGENES = 'img/productos/';
    const RUTA_DEFAULT = 'img/no-image.png';

    function construirRutaImagen(nombreArchivo) {
        if (!nombreArchivo || String(nombreArchivo).trim() === '') {
            return RUTA_DEFAULT;
        }
        return RUTA_IMAGENES + String(nombreArchivo).trim();
    }

    function limpiarFormulario() {
        $("#productBarcode").val('');
        $("#quantityInput").val('');
        $("#barcodeScanned").val('');
        $("#buscarProductoInput").val('');
        $("#resultadosProductos").hide().html('');
        $("#productDetails").hide();
        $("#quantitySection").hide();
        $("#productImage").attr('src', RUTA_DEFAULT);
        $("#productName").text('');
        $("#currentStock").text('');
        $("#productCode").text('');
        $("#productBarcode").focus();
        inputBuffer = '';
    }

    function mostrarMensaje(html, tipo) {
        let clase = (tipo === 'ok') ? 'mensaje-resultado mensaje-ok' : 'mensaje-resultado mensaje-error';
        $("#result").html('<div class="' + clase + '">' + html + '</div>');
    }

    function cargarProductoPorCodigo(codigoBarra) {
        if (!codigoBarra || String(codigoBarra).trim() === '') {
            return;
        }

        codigoBarra = String(codigoBarra).trim();

        $.ajax({
            url: 'consultar_producto.php',
            type: 'POST',
            data: { 
                codigoBarra: codigoBarra
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $("#result").html('');

                    $("#productBarcode").val(codigoBarra);
                    $("#barcodeScanned").val(codigoBarra);

                    $("#productName").text(response.details.nombre || '');
                    $("#currentStock").text(response.details.existenciaActual || '0');
                    $("#productCode").text(codigoBarra);

                    let imagen = construirRutaImagen(response.details.imagenProducto);
                    $("#productImage").attr('src', imagen);

                    $("#productDetails").show();
                    $("#quantitySection").show();
                    $("#quantityInput").focus();
                } else {
                    mostrarMensaje("Producto no encontrado.", "error");
                    limpiarFormulario();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                mostrarMensaje("Error al consultar el producto.", "error");
                limpiarFormulario();
            }
        });
    }

    // Captura rápida del escáner
    $("#productBarcode").on('keypress', function(e) {
        inputBuffer += String.fromCharCode(e.which);

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(function() {
            if (inputBuffer.length > 0) {
                cargarProductoPorCodigo(inputBuffer);
                inputBuffer = '';
            }
        }, 120);
    });

    // También permite buscar al presionar Enter en el input de código
    $("#productBarcode").on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let codigo = $("#productBarcode").val();
            cargarProductoPorCodigo(codigo);
        }
    });

    // Buscador tipo select por nombre o código
    $("#buscarProductoInput").on('keyup', function(e) {
        let busqueda = $(this).val().trim();

        if (timerBuscador) {
            clearTimeout(timerBuscador);
        }

        if (busqueda.length < 2) {
            $("#resultadosProductos").hide().html('');
            return;
        }

        timerBuscador = setTimeout(function() {
            $.ajax({
                url: 'buscar_productos_stock.php',
                type: 'POST',
                data: {
                    busqueda: busqueda
                },
                dataType: 'json',
                success: function(response) {
                    let html = '';

                    if (response.success && response.productos.length > 0) {
                        response.productos.forEach(function(producto) {
                            html += `
                                <div class="select-buscador-item"
                                     data-codigo="${producto.codigoBarra}"
                                     data-nombre="${producto.nombreProducto}">
                                    <strong>${producto.codigoBarra}</strong> - ${producto.nombreProducto}
                                    <br>
                                    <small>Stock actual: ${producto.existenciaProducto}</small>
                                </div>
                            `;
                        });

                        $("#resultadosProductos").html(html).show();
                    } else {
                        $("#resultadosProductos").html(`
                            <div class="select-buscador-item">
                                No se encontraron productos.
                            </div>
                        `).show();
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    $("#resultadosProductos").html(`
                        <div class="select-buscador-item">
                            Error al buscar productos.
                        </div>
                    `).show();
                }
            });
        }, 250);
    });

    // Seleccionar producto desde el buscador
    $(document).on('click', '.select-buscador-item', function() {
        let codigo = $(this).data('codigo');
        let nombre = $(this).data('nombre');

        if (!codigo) {
            return;
        }

        $("#buscarProductoInput").val(nombre);
        $("#resultadosProductos").hide().html('');

        cargarProductoPorCodigo(codigo);
    });

    // Ocultar resultados si hace click fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.select-buscador-wrap').length) {
            $("#resultadosProductos").hide();
        }
    });

    // Agregar stock
    $("#addButton").click(function() {
        let codigoBarra = $("#productBarcode").val();
        let cantidad = $("#quantityInput").val();

        if (!codigoBarra || codigoBarra.trim() === '') {
            mostrarMensaje("Debe escanear o seleccionar un producto.", "error");
            return;
        }

        if (cantidad && !isNaN(cantidad) && parseInt(cantidad) > 0) {
            $.ajax({
                url: 'sumar_product_varios.php',
                type: 'POST',
                data: { 
                    codigoBarra: codigoBarra,
                    cantidad: cantidad
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        mostrarMensaje(response.message, "ok");
                    } else {
                        mostrarMensaje(response.message || "No se pudo actualizar el producto.", "error");
                    }

                    if (response.details) {
                        let imagen = construirRutaImagen(response.details.imagenProducto);

                        $("#lastScanned").html(`
                            <div style="display:flex; gap:15px; align-items:center; flex-wrap:wrap;">
                                <div style="width:80px; height:80px; border-radius:12px; overflow:hidden; background:#fff; border:1px solid #dde3ea;">
                                    <img src="${imagen}" alt="Producto" style="width:100%; height:100%; object-fit:contain; padding:6px;" onerror="this.onerror=null;this.src='${RUTA_DEFAULT}';">
                                </div>
                                <div style="flex:1; min-width:220px;">
                                    <div style="margin-bottom:6px;"><strong>Código:</strong> ${response.details.codigoBarra || ''}</div>
                                    <div style="margin-bottom:6px;"><strong>Producto:</strong> ${response.details.nombre || ''}</div>
                                    <div><strong>Existencia actual:</strong> ${response.details.newExistencia || ''}</div>
                                </div>
                            </div>
                        `);
                    }

                    limpiarFormulario();
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    mostrarMensaje("Error al actualizar el producto.", "error");
                    limpiarFormulario();
                }
            });
        } else {
            mostrarMensaje("Debe ingresar una cantidad válida.", "error");
        }
    });
});
</script>