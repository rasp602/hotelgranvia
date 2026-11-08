<script src="producto/js/ajaxProducto.js"></script>

<?php 
$usuario = null;
if (!empty($_SESSION["usuarioInventario"]->idUsuario) && empty($_SESSION['csrfEgresoLector'])) {
    $_SESSION['csrfEgresoLector'] = bin2hex(random_bytes(32));
}
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
?> 

<style>
    .stock-page {
        padding: 20px 0 35px 0;
    }

    .stock-shell {
        width: 80%;
        margin: 0 auto;
    }

    .stock-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
        overflow: hidden;
        border: 1px solid #e9ecef;
        margin-bottom: 22px;
    }

    .stock-header {
        background: linear-gradient(135deg, #dc3545, #b02a37);
        color: #fff;
        padding: 22px 18px;
        text-align: center;
    }

    .stock-header h2 {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
    }

    .stock-header p {
        margin: 8px 0 0 0;
        font-size: 14px;
        opacity: .95;
    }

    .stock-body {
        background: #f8fafc;
        padding: 24px;
    }

    .panel-box {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 22px;
    }

    .titulo-modulo {
        font-size: 24px;
        font-weight: 700;
        color: #dc3545;
        margin-bottom: 18px;
        text-align: center;
    }

    .label-modern {
        font-weight: 700;
        color: #344054;
        margin-bottom: 8px;
        display: block;
    }

    .input-icon-wrap {
        position: relative;
    }

    .form-control {
        min-height: 48px;
        border-radius: 10px !important;
        border: 1px solid #d0d5dd !important;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.15) !important;
    }

    .scan-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #dc3545;
        font-size: 20px;
        pointer-events: none;
    }

    .mensaje-resultado {
        margin-top: 18px;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        text-align: center;
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

    .ultimo-producto-box {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 20px;
        margin-top: 18px;
        display: none;
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
        background: linear-gradient(135deg, #fff1f2, #ffe2e6);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #f1c6cc;
        flex-shrink: 0;
    }

    .producto-img-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
    }

    .producto-detalle {
        flex: 1;
        min-width: 220px;
    }

    .producto-titulo {
        font-size: 22px;
        font-weight: 700;
        color: #1d2939;
        margin-bottom: 12px;
    }

    .detalle-linea {
        font-size: 15px;
        color: #475467;
        margin-bottom: 8px;
    }

    .detalle-linea strong {
        color: #dc3545;
    }

    .stock-badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        background: #fff1f2;
        color: #dc3545;
        border: 1px solid #f5c2c7;
    }

    .historial-card .stock-body {
        padding: 20px;
    }

    .outer_div_ultimos_ingresadoss {
        margin-top: 8px;
    }

    @media (max-width: 1200px) {
        .stock-shell {
            width: 90%;
        }
    }

    @media (max-width: 767px) {
        .stock-page {
            padding: 10px 0 25px 0;
        }

        .stock-shell {
            width: 96%;
        }

        .stock-header h2 {
            font-size: 22px;
        }

        .stock-body {
            padding: 14px;
        }

        .panel-box,
        .ultimo-producto-box {
            padding: 15px;
        }

        .producto-info-wrap {
            flex-direction: column;
            text-align: center;
        }

        .producto-img-box {
            width: 110px;
            height: 110px;
        }

        .producto-titulo {
            font-size: 19px;
        }
    }
</style>

<div class="container-fluid stock-page">
    <div class="stock-shell">

        <div class="stock-card">
            <div class="stock-header">
                <h2><i class="bi bi-qr-code-scan"></i> Egreso de Stock por Escáner</h2>
                <p>Cada lectura válida descuenta una unidad del inventario.</p>
            </div>

            <div class="stock-body">
                <div class="panel-box">
                    <div class="titulo-modulo">
                        <i class="bi bi-upc-scan"></i> Escaneo de Producto
                    </div>

                    <form id="productForm" onsubmit="return false;">
                        <label for="productBarcode" class="label-modern">Escanea el código del producto</label>

                        <div class="input-icon-wrap">
                            <input type="text" id="productBarcode" name="productBarcode" autofocus class="form-control" autocomplete="off">
                            <span class="scan-icon">
                                <i class="fa-solid fa-barcode"></i>
                            </span>
                        </div>
                    </form>

                    <div id="result" role="status" aria-live="polite"></div>

                    <div id="ultimoProductoBox" class="ultimo-producto-box">
                        <div class="titulo-modulo" style="font-size:20px; margin-bottom:15px;">
                            <i class="bi bi-box-seam"></i> Último Producto Egresado
                        </div>

                        <div class="producto-info-wrap">
                            <div class="producto-img-box">
                                <img id="productImage" src="img/no-image.png" alt="Producto" onerror="this.onerror=null;this.src='img/no-image.png';">
                            </div>

                            <div class="producto-detalle">
                                <div class="producto-titulo" id="productName">Producto</div>

                                <div class="detalle-linea">
                                    <strong>Código de barras:</strong>
                                    <span id="productBarcodeText"></span>
                                </div>

                                <div class="detalle-linea">
                                    <strong>Existencia actual:</strong>
                                    <span class="stock-badge" id="currentStock"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:18px;">
                        <a href="?c=producto&a=menuProducto" class="btn btn-outline-danger">
                            <i class="bi bi-box-seam"></i> PRODUCTOS
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="stock-card historial-card">
            <div class="stock-header">
                <h2><i class="bi bi-box-arrow-up"></i> Últimos Productos Egresados</h2>
                <p>Historial reciente de egresos de stock.</p>
            </div>

            <div class="stock-body">
                <div class="outer_div_ultimos_ingresadoss"></div>
            </div>
        </div>

    </div>
</div>

<script>
$(function () {
    const entrada = $("#productBarcode");
    const token = <?= json_encode($_SESSION['csrfEgresoLector'] ?? '') ?>;
    const imagenDefault = "img/no-image.png";
    let timer;
    let enviando = false;

    function mensaje(texto, ok) {
        $("#result").empty().append(
            $("<div>").addClass("mensaje-resultado " + (ok ? "mensaje-ok" : "mensaje-error")).text(texto)
        );
    }

    function egresar() {
        clearTimeout(timer);
        const codigo = entrada.val().trim();
        if (!codigo || enviando) return;
        if (!token) {
            mensaje("Inicia sesión en inventario y vuelve a abrir el módulo.", false);
            return;
        }

        enviando = true;
        entrada.val("").prop("readonly", true);
        mensaje("Registrando salida de una unidad…", true);

        $.ajax({
            url: "restar_product_lector.php",
            type: "POST",
            dataType: "json",
            data: {codigoBarra: codigo, token: token}
        }).done(function (r) {
            mensaje(r.message || "No se pudo registrar el egreso.", r.success === true);
            if (!r.success || !r.details) return;
            const d = r.details;
            const imagen = String(d.imagenProducto || "").trim();
            $("#productImage").attr("src", imagen ? "img/productos/" + encodeURIComponent(imagen) : imagenDefault);
            $("#productName").text(d.nombre || "");
            $("#productBarcodeText").text(d.codigoBarra || codigo);
            $("#currentStock").text(d.newExistencia);
            $("#ultimoProductoBox").show();
        }).fail(function () {
            mensaje("No se pudo confirmar la salida. Revisa el historial antes de escanear otra vez.", false);
        }).always(function () {
            enviando = false;
            entrada.prop("readonly", false).focus();
        });
    }

    entrada.on("keydown", function (e) {
        if (e.key === "Enter" || e.keyCode === 13 ||
            ((e.key === "Tab" || e.keyCode === 9) && entrada.val().trim() !== "")) {
            e.preventDefault();
            egresar();
        }
    });

    entrada.on("input", function () {
        clearTimeout(timer);
        if (entrada.val().trim()) timer = setTimeout(egresar, 450);
    });

    entrada.focus();
});
</script>
