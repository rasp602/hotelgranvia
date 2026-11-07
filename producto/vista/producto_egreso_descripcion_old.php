

<?php 
$usuario = null;
$usuarioRegistro = 0;
if (isset($_SESSION["usuarioInventario"])) {
    $usuario = $_SESSION["usuarioInventario"];
    if ($usuario->nivel == "U") {
        include_once 'menu_principal/vista/Menu_Usuarios.php'; 
    } elseif ($usuario->nivel == "F") {
        include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
    } elseif ($usuario->nivel == "I") {
        include_once 'menu_principal/vista/Menu_Inventario.php';   
    } 
           $usuarioRegistro=$usuario->idUsuario;
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
        background: linear-gradient(135deg, #dc3545, #b02a37);
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
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15) !important;
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
        color: #dc3545;
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
        color: #dc3545;
        margin-bottom: 15px;
        text-align: center;
    }

    .outer_div_ultimos_egresados {
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
        border-bottom: 1px solid #f1f3f5;
        font-size: 14px;
    }

    .select-buscador-item:hover {
        background: #eef4ff;
    }

    .select-buscador-item strong {
        color: #dc3545;
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
                <h2><i class="bi bi-search"></i> Egreso de Stock por Descripción</h2>
                <p>Busca el producto escribiendo su nombre o código y luego indica la cantidad a retirar.</p>
            </div>

            <div class="stock-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-panel">
                            <div class="modulo-titulo">
                                <i class="bi bi-search"></i> Buscar Producto
                            </div>

                            <form id="productForm" onsubmit="return false;">
      <input type="hidden" id="usuarioRegistro" value="<?php echo $usuarioRegistro; ?>">
                                <div class="form-group">
                                    <label for="buscarProductoInput"> Escribe nombre del producto</label>

                                    <div class="select-buscador-wrap">
                                        <input type="text" id="buscarProductoInput" class="form-control" placeholder="Escribe nombre o código del producto..." autocomplete="off" autofocus>
                                        <div id="resultadosProductos" class="select-buscador-resultados"></div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top:15px;">
                                    <label for="quantityInput">Cantidad a retirar</label>
                                    <input type="number" id="quantityInput" name="quantityInput" class="form-control" placeholder="Cantidad" required min="1" step="1">
                                </div>

                                <div style="margin-top:18px;">
                                    <button id="addButton" type="button" class="btn btn-success btn-modern btn-block-modern">
                                        <i class="bi bi-dash-circle"></i> Retirar del Stock
                                    </button>
                                </div>
                            </form>

                            <div class="text-center" style="margin-top:15px;">
                                <a href="?c=producto&a=menuProducto" class="btn btn-outline-primary btn-modern">
                                    <i class="bi bi-box-seam"></i> Ver Productos
                                </a>
                            </div>

                            <input type="hidden" id="idProductoEgreso" />

                            <div id="result"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12" style="margin-top:0;">
                        <div id="productDetails" style="display:none;" class="producto-panel">
                            <div class="modulo-titulo">
                                <i class="bi bi-card-image"></i> Producto Seleccionado
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
                <h2><i class="bi bi-box-arrow-up"></i> Últimos Productos Egresados</h2>
                <p>Historial reciente de egresos de stock.</p>
            </div>

            <div class="stock-body">
                <div class="outer_div_ultimos_egresados"></div>
            </div>
        </div>

    </div>
</div>


<script>
$(function () {
    'use strict';
    var endpoint = 'egreso_descripcion.php';
    var seleccionado = null, timer, version = 0, enviando = false;
    function mensaje(texto, ok) {
        $('#result').empty().append($('<div>').addClass('mensaje-resultado ' + (ok ? 'mensaje-ok' : 'mensaje-error')).text(texto));
    }
    function imagen(nombre) {
        return nombre ? 'img/productos/' + encodeURIComponent(String(nombre)) : 'img/no-image.png';
    }
    function mostrarProducto(p) {
        seleccionado = p;
        $('#idProductoEgreso').val(p.idProducto);
        $('#productName').text(p.nombreProducto);
        $('#productCode').text(p.codigoBarra || '');
        $('#currentStock').text(p.existenciaProducto);
        $('#productImage').attr('src', imagen(p.imagenProducto));
        $('#productDetails').show();
        $('#quantityInput').val('').focus();
    }
    function ultimos() {
        $.ajax({url: endpoint, type: 'POST', dataType: 'json', data: {accion: 'ultimos'}}).done(function (r) {
            var contenedor = $('.outer_div_ultimos_egresados').empty();
            if (!r.success) { contenedor.text(r.message || 'No se pudo cargar el historial.'); return; }
            if (!r.movimientos.length) { contenedor.text('Aún no hay egresos registrados.'); return; }
            var tabla = $('<table>').addClass('table table-striped');
            var cabecera = $('<tr>');
            ['Fecha', 'Hora', 'Producto', 'Cantidad retirada', 'Stock final', 'Usuario'].forEach(function (x) { cabecera.append($('<th>').text(x)); });
            tabla.append($('<thead>').append(cabecera));
            var cuerpo = $('<tbody>');
            r.movimientos.forEach(function (m) {
                var fila = $('<tr>');
                [m.fechaRegistro, m.horaRegistro, m.nombreProducto, m.cantRegistro, m.ultimoStock,
                    (m.nombreUsuario || '') + ' ' + (m.apellidoUsuario || '')].forEach(function (x) { fila.append($('<td>').text(x == null ? '' : x)); });
                cuerpo.append(fila);
            });
            contenedor.append($('<div>').addClass('table-responsive').append(tabla.append(cuerpo)));
        }).fail(function () { $('.outer_div_ultimos_egresados').text('No se pudo cargar el historial de egresos.'); });
    }
    $('#buscarProductoInput').on('input', function () {
        if (enviando) { return; }
        seleccionado = null;
        $('#idProductoEgreso').val('');
        $('#productDetails').hide();
        $('#quantityInput').val('');
        clearTimeout(timer);
        var busqueda = $(this).val().trim(), actual = ++version;
        $('#resultadosProductos').empty().hide();
        if (!busqueda) { return; }
        timer = setTimeout(function () {
            $.ajax({url: endpoint, type: 'POST', dataType: 'json', data: {accion: 'buscar', busqueda: busqueda}}).done(function (r) {
                if (actual !== version) { return; }
                var lista = $('#resultadosProductos').empty().show();
                if (!r.success) { lista.text(r.message || 'Error buscando productos.'); return; }
                if (!r.productos.length) { lista.append($('<div>').addClass('select-buscador-item').text('No se encontraron productos.')); return; }
                r.productos.forEach(function (p) {
                    var item = $('<div>').addClass('select-buscador-item').css('cursor', 'pointer');
                    item.append($('<strong>').text(p.codigoBarra || ''), document.createTextNode(' - ' + p.nombreProducto), $('<br>'), $('<small>').text('Stock actual: ' + p.existenciaProducto));
                    item.on('click', function () {
                        if (enviando) { return; }
                        ++version;
                        $('#buscarProductoInput').val(p.nombreProducto);
                        lista.empty().hide();
                        $('#result').empty();
                        mostrarProducto(p);
                    });
                    lista.append(item);
                });
            }).fail(function () { if (actual === version) { mensaje('Error al buscar productos.', false); } });
        }, 250);
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.select-buscador-wrap').length) { $('#resultadosProductos').hide(); }
    });
    $('#quantityInput').on('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); $('#addButton').trigger('click'); }
    });
    $('#addButton').on('click', function () {
        if (enviando) { return; }
        var cantidad = $('#quantityInput').val();
        if (!seleccionado) { mensaje('Debe seleccionar un producto desde el buscador.', false); return; }
        if (!/^\d+$/.test(cantidad) || Number(cantidad) < 1 || !Number.isSafeInteger(Number(cantidad))) {
            mensaje('Ingrese una cantidad entera mayor que cero.', false); return;
        }
        if (Number(cantidad) > Number(seleccionado.existenciaProducto)) { mensaje('La cantidad supera el stock disponible.', false); return; }
        enviando = true;
        $('#addButton, #buscarProductoInput, #quantityInput').prop('disabled', true);
        $.ajax({url: endpoint, type: 'POST', dataType: 'json', data: {
            accion: 'egresar', idProducto: seleccionado.idProducto, cantidad: cantidad, usuarioRegistro: $('#usuarioRegistro').val()
        }}).done(function (r) {
            mensaje(r.message || 'No se pudo registrar el egreso.', !!r.success);
            if (!r.success) { return; }
            var d = r.details;
            $('#lastScanned').empty().append(
                $('<div>').text('Producto: ' + d.nombreProducto),
                $('<div>').text('Código: ' + (d.codigoBarra || '')),
                $('<div>').text('Cantidad retirada: ' + d.cantidad),
                $('<div>').text('Existencia actual: ' + d.newExistencia)
            );
            $('#quantitySection').show();
            seleccionado = null;
            $('#buscarProductoInput, #quantityInput, #idProductoEgreso').val('');
            $('#productDetails').hide();
            $('#resultadosProductos').empty().hide();
            ultimos();
        }).fail(function (xhr) {
            mensaje(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'No se pudo confirmar el egreso. Revise el historial antes de volver a intentarlo.', false);
            ultimos();
        }).always(function () {
            enviando = false;
            $('#addButton, #buscarProductoInput, #quantityInput').prop('disabled', false);
            if (!seleccionado) { $('#buscarProductoInput').focus(); }
        });
    });
    ultimos();
});

</script>
