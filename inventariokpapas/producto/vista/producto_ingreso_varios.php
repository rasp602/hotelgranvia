<script src="producto/js/ajaxProducto.js"></script>

<?php 

$usuario = null;
$usuarioRegistro = "";

if (isset($_SESSION["usuarioInventario"])) {

    $usuario = $_SESSION["usuarioInventario"];

    if ($usuario->nivel == "U") {
        include_once 'menu_principal/vista/Menu_Usuarios.php'; 

    } elseif ($usuario->nivel == "F") {
        include_once 'menu_principal/vista/Menu_Fiscalizador.php';   

    } elseif ($usuario->nivel == "I") {
        include_once 'menu_principal/vista/Menu_Inventario.php';   
    }

    $usuarioRegistro = $usuario->idUsuario;
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


/*
==========================================================
CONFIGURACIÓN INGRESO POR CAJA
==========================================================
*/

.caja-manual-box {
    background: #f8fbff;
    border: 1px solid #cfe2ff;
    border-radius: 14px;
    padding: 16px;
    margin-top: 15px;
}

.caja-manual-check {
    display: flex;
    align-items: center;
    gap: 10px;
}

.caja-manual-check input {
    width: 20px;
    height: 20px;
    cursor: pointer;
    margin: 0;
}

.caja-manual-check label {
    margin: 0;
    cursor: pointer;
    color: #0d6efd;
    font-weight: 700;
}

.caja-manual-ayuda {
    font-size: 13px;
    color: #667085;
    margin-top: 8px;
}

#configCajaManual {
    display: none;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #dbeafe;
}

.preview-calculo {
    display: none;
    margin-top: 12px;
    background: #fff8e1;
    border: 1px solid #ffe69c;
    color: #664d03;
    padding: 11px 14px;
    border-radius: 10px;
    font-weight: 600;
}

.badge-modo {
    display: inline-block;
    border-radius: 999px;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 700;
}

.badge-modo-caja {
    background: #e8f1ff;
    color: #0d6efd;
}

.badge-modo-unidad {
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


<!-- =========================================================
INGRESO
========================================================= -->

<div class="stock-card">

    <div class="stock-header">

        <h2>
            <i class="bi bi-search"></i>
            Ingreso de Stock por Buscador
        </h2>

        <p>
            Selecciona el producto y decide si ingresar unidades individuales o cajas.
        </p>

    </div>


    <div class="stock-body">

        <div class="row">


            <!-- =================================================
            FORMULARIO
            ================================================= -->

            <div class="col-md-6 col-sm-12">

                <div class="form-panel">


                    <div class="modulo-titulo">

                        <i class="bi bi-search"></i>

                        Buscar Producto

                    </div>


                    <form id="productForm" onsubmit="return false;">


                        <input
                            type="hidden"
                            id="usuarioRegistro"
                            value="<?php echo $usuarioRegistro; ?>"
                        >


                        <!-- BUSCADOR -->

                        <div class="form-group">

                            <label for="buscarProductoInput">
                                Escribe nombre del producto
                            </label>


                            <div class="select-buscador-wrap">

                                <input
                                    type="text"
                                    id="buscarProductoInput"
                                    class="form-control"
                                    placeholder="Escribe nombre o código del producto..."
                                    autocomplete="off"
                                    autofocus
                                >

                                <div
                                    id="resultadosProductos"
                                    class="select-buscador-resultados"
                                ></div>

                            </div>

                        </div>



                        <!-- =================================================
                        MODO CAJA MANUAL
                        ================================================= -->

                        <div class="caja-manual-box">


                            <div class="caja-manual-check">

                                <input
                                    type="checkbox"
                                    id="ingresoPorCaja"
                                >


                                <label for="ingresoPorCaja">

                                    <i class="bi bi-box-seam"></i>

                                    Ingresar este movimiento por caja

                                </label>

                            </div>


                            <div class="caja-manual-ayuda">

                                Esta opción solo afecta este ingreso.
                                No modifica la configuración del producto.

                            </div>



                            <div id="configCajaManual">


                                <div class="form-group">

                                    <label for="unidadesPorCajaManual">

                                        Unidades que contiene cada caja

                                    </label>


                                    <input
                                        type="number"
                                        id="unidadesPorCajaManual"
                                        class="form-control"
                                        value=""
                                        min="2"
                                        step="1"
                                        placeholder="Ejemplo: 10"
                                    >

                                </div>


                            </div>


                        </div>



                        <!-- CANTIDAD -->

                        <div
                            class="form-group"
                            style="margin-top:15px;"
                        >

                            <label
                                for="quantityInput"
                                id="labelCantidad"
                            >

                                Cantidad de unidades a ingresar

                            </label>


                            <input
                                type="number"
                                id="quantityInput"
                                name="quantityInput"
                                class="form-control"
                                placeholder="Cantidad"
                                required
                                min="1"
                            >


                            <div
                                id="previewCalculo"
                                class="preview-calculo"
                            ></div>

                        </div>



                        <!-- BOTON -->

                        <div style="margin-top:18px;">

                            <button
                                id="addButton"
                                type="button"
                                class="btn btn-success btn-modern btn-block-modern"
                            >

                                <i class="bi bi-plus-circle"></i>

                                Agregar al Stock

                            </button>

                        </div>


                    </form>


                    <div
                        class="text-center"
                        style="margin-top:15px;"
                    >

                        <a
                            href="?c=producto&a=menuProducto"
                            class="btn btn-outline-primary btn-modern"
                        >

                            <i class="bi bi-box-seam"></i>

                            Ver Productos

                        </a>

                    </div>


                    <input
                        type="hidden"
                        id="barcodeScanned"
                    >


                    <div id="result"></div>


                </div>

            </div>



            <!-- =================================================
            PRODUCTO
            ================================================= -->

            <div class="col-md-6 col-sm-12">


                <div
                    id="productDetails"
                    style="display:none;"
                    class="producto-panel"
                >

                    <div class="modulo-titulo">

                        <i class="bi bi-card-image"></i>

                        Producto Seleccionado

                    </div>


                    <div class="producto-info-wrap">


                        <div class="producto-img-box">

                            <img
                                id="productImage"
                                src="img/no-image.png"
                                alt="Producto"
                                onerror="
                                    this.onerror=null;
                                    this.src='img/no-image.png';
                                "
                            >

                        </div>


                        <div class="producto-datos">


                            <div
                                class="producto-titulo"
                                id="productName"
                            ></div>


                            <div class="dato-linea">

                                <strong>
                                    Código:
                                </strong>

                                <span id="productCode"></span>

                            </div>


                            <div class="dato-linea">

                                <strong>
                                    Existencia actual:
                                </strong>

                                <span
                                    class="stock-badge"
                                    id="currentStock"
                                ></span>

                            </div>


                        </div>


                    </div>

                </div>



                <!-- ULTIMO MOVIMIENTO -->

                <div
                    id="quantitySection"
                    style="display:none; margin-top:15px;"
                    class="ultimo-panel"
                >

                    <div class="modulo-titulo">

                        <i class="bi bi-clock-history"></i>

                        Último Movimiento

                    </div>


                    <div
                        class="ultimo-ingreso-box"
                        id="lastScanned"
                    >

                        Aún no se ha registrado ningún movimiento.

                    </div>

                </div>


            </div>


        </div>

    </div>

</div>



<!-- =========================================================
HISTORIAL
========================================================= -->

<div class="stock-card">

    <div class="stock-header">

        <h2>

            <i class="bi bi-box-arrow-in-down"></i>

            Últimos Productos Ingresados

        </h2>

        <p>
            Historial reciente de ingresos a stock.
        </p>

    </div>


    <div class="stock-body">

        <div class="outer_div_ultimos_ingresados"></div>

    </div>

</div>


</div>

</div>



<script>

$(document).ready(function() {


    let timerBuscador = null;


    const RUTA_IMAGENES =
        'img/productos/';


    const RUTA_DEFAULT =
        'img/no-image.png';



    /*
    =========================================================
    IMAGEN
    =========================================================
    */

    function construirRutaImagen(nombreArchivo)
    {

        if (
            !nombreArchivo ||
            String(nombreArchivo).trim() === ''
        ) {

            return RUTA_DEFAULT;

        }


        nombreArchivo =
            String(nombreArchivo).trim();


        if (
            nombreArchivo.startsWith('http://') ||
            nombreArchivo.startsWith('https://') ||
            nombreArchivo.startsWith('img/')
        ) {

            return nombreArchivo;

        }


        return RUTA_IMAGENES +
            nombreArchivo;
    }



    /*
    =========================================================
    MENSAJES
    =========================================================
    */

    function mostrarMensaje(
        html,
        tipo
    )
    {

        let clase =
            tipo === 'ok'
                ? 'mensaje-resultado mensaje-ok'
                : 'mensaje-resultado mensaje-error';


        $("#result").html(

            '<div class="' +
            clase +
            '">' +
            html +
            '</div>'

        );
    }



    /*
    =========================================================
    CAMBIAR MODO CAJA
    =========================================================
    */

    $("#ingresoPorCaja").on(
        'change',
        function()
        {

            if ($(this).is(':checked')) {


                $("#configCajaManual")
                    .slideDown(180);


                $("#labelCantidad")
                    .text(
                        "Cantidad de cajas a ingresar"
                    );


                $("#quantityInput")
                    .attr(
                        'placeholder',
                        'Cantidad de cajas'
                    );


                $("#unidadesPorCajaManual")
                    .prop(
                        'required',
                        true
                    )
                    .focus();


            } else {


                $("#configCajaManual")
                    .slideUp(180);


                $("#unidadesPorCajaManual")
                    .val('')
                    .prop(
                        'required',
                        false
                    );


                $("#labelCantidad")
                    .text(
                        "Cantidad de unidades a ingresar"
                    );


                $("#quantityInput")
                    .attr(
                        'placeholder',
                        'Cantidad'
                    );


                $("#previewCalculo")
                    .hide()
                    .html('');

            }


            actualizarPreview();

        }
    );



    /*
    =========================================================
    PREVIEW
    =========================================================
    */

    function actualizarPreview()
    {

        if (
            !$("#ingresoPorCaja").is(':checked')
        ) {

            $("#previewCalculo")
                .hide()
                .html('');

            return;

        }


        let cajas =
            parseInt(
                $("#quantityInput").val(),
                10
            );


        let unidadesCaja =
            parseInt(
                $("#unidadesPorCajaManual").val(),
                10
            );


        if (
            isNaN(cajas) ||
            cajas <= 0 ||
            isNaN(unidadesCaja) ||
            unidadesCaja <= 1
        ) {

            $("#previewCalculo")
                .hide()
                .html('');

            return;

        }


        let total =
            cajas *
            unidadesCaja;


        $("#previewCalculo")
            .html(

                '<i class="bi bi-calculator"></i> ' +

                cajas +

                ' caja(s) × ' +

                unidadesCaja +

                ' unidades = ' +

                '<strong>' +

                total +

                ' unidades a ingresar</strong>'

            )
            .show();

    }



    $("#quantityInput, #unidadesPorCajaManual")
        .on(
            'input change keyup',
            actualizarPreview
        );



    /*
    =========================================================
    LIMPIAR PRODUCTO

    IMPORTANTE:
    Reiniciamos también el modo caja después de cada ingreso.
    =========================================================
    */

    function limpiarFormulario()
    {

        $("#quantityInput")
            .val('');


        $("#barcodeScanned")
            .val('');


        $("#buscarProductoInput")
            .val('');


        $("#resultadosProductos")
            .hide()
            .html('');


        $("#productDetails")
            .hide();


        $("#quantitySection")
            .hide();


        $("#productImage")
            .attr(
                'src',
                RUTA_DEFAULT
            );


        $("#productName")
            .text('');


        $("#currentStock")
            .text('');


        $("#productCode")
            .text('');


        /*
        CAJA MANUAL
        */

        $("#ingresoPorCaja")
            .prop(
                'checked',
                false
            );


        $("#configCajaManual")
            .hide();


        $("#unidadesPorCajaManual")
            .val('');


        $("#labelCantidad")
            .text(
                'Cantidad de unidades a ingresar'
            );


        $("#quantityInput")
            .attr(
                'placeholder',
                'Cantidad'
            );


        $("#previewCalculo")
            .hide()
            .html('');


        setTimeout(
            function()
            {

                $("#buscarProductoInput")
                    .focus();

            },

            200
        );

    }



    /*
    =========================================================
    CARGAR PRODUCTO
    =========================================================
    */

    function cargarProductoPorCodigo(codigoBarra)
    {

        if (
            !codigoBarra ||
            String(codigoBarra).trim() === ''
        ) {

            return;

        }


        codigoBarra =
            String(codigoBarra).trim();


        $.ajax({

            url:
                'consultar_producto.php',

            type:
                'POST',

            data: {

                codigoBarra:
                    codigoBarra

            },

            dataType:
                'json',

            cache:
                false,


            success:
                function(response)
                {

                    if (
                        response &&
                        response.success
                    )
                    {

                        $("#result")
                            .html('');


                        $("#barcodeScanned")
                            .val(
                                codigoBarra
                            );


                        $("#productName")
                            .text(
                                response.details.nombre ||
                                ''
                            );


                        $("#currentStock")
                            .text(
                                response.details.existenciaActual ||
                                '0'
                            );


                        $("#productCode")
                            .text(
                                codigoBarra
                            );


                        let imagen =
                            construirRutaImagen(
                                response.details.imagenProducto
                            );


                        $("#productImage")
                            .attr(
                                'src',
                                imagen
                            );


                        $("#productDetails")
                            .show();


                        $("#quantitySection")
                            .show();


                        setTimeout(
                            function()
                            {

                                if (
                                    $("#ingresoPorCaja").is(':checked')
                                ) {

                                    $("#unidadesPorCajaManual")
                                        .focus();

                                } else {

                                    $("#quantityInput")
                                        .focus()
                                        .select();

                                }

                            },

                            150
                        );


                    } else {


                        mostrarMensaje(

                            response.message ||
                            "Producto no encontrado.",

                            "error"

                        );

                    }

                },


            error:
                function(xhr)
                {

                    console.error(
                        xhr.responseText
                    );


                    mostrarMensaje(

                        "Error al consultar el producto.",

                        "error"

                    );

                }

        });

    }



    /*
    =========================================================
    BUSCADOR
    =========================================================
    */

    $("#buscarProductoInput")
        .on(
            'keyup',
            function()
            {

                let busqueda =
                    $(this)
                        .val()
                        .trim();


                $("#barcodeScanned")
                    .val('');


                $("#productDetails")
                    .hide();


                if (
                    timerBuscador
                ) {

                    clearTimeout(
                        timerBuscador
                    );

                }


                if (
                    busqueda.length < 2
                ) {

                    $("#resultadosProductos")
                        .hide()
                        .html('');

                    return;

                }


                timerBuscador =
                    setTimeout(

                        function()
                        {

                            $.ajax({

                                url:
                                    'buscar_productos_stock.php',

                                type:
                                    'POST',

                                data: {

                                    busqueda:
                                        busqueda

                                },

                                dataType:
                                    'json',

                                cache:
                                    false,


                                success:
                                    function(response)
                                    {

                                        let html =
                                            '';


                                        if (
                                            response &&
                                            response.success &&
                                            response.productos &&
                                            response.productos.length > 0
                                        )
                                        {

                                            response.productos
                                                .forEach(
                                                    function(producto)
                                                    {

                                                        html += `

                                                            <div
                                                                class="select-buscador-item"

                                                                data-codigo="${producto.codigoBarra}"

                                                                data-nombre="${producto.nombreProducto}"
                                                            >

                                                                <strong>
                                                                    ${producto.codigoBarra}
                                                                </strong>

                                                                -

                                                                ${producto.nombreProducto}

                                                                <br>

                                                                <small>

                                                                    Stock actual:
                                                                    ${producto.existenciaProducto}

                                                                </small>

                                                            </div>

                                                        `;

                                                    }
                                                );


                                            $("#resultadosProductos")
                                                .html(
                                                    html
                                                )
                                                .show();


                                        } else {


                                            let mensaje =
                                                "No se encontraron productos.";


                                            if (
                                                response &&
                                                response.success === false &&
                                                response.message
                                            ) {

                                                mensaje =
                                                    response.message;

                                            }


                                            $("#resultadosProductos")
                                                .html(`

                                                    <div class="select-buscador-item">

                                                        ${mensaje}

                                                    </div>

                                                `)
                                                .show();

                                        }

                                    },


                                error:
                                    function(xhr)
                                    {

                                        console.error(
                                            xhr.responseText
                                        );


                                        $("#resultadosProductos")
                                            .html(`

                                                <div class="select-buscador-item">

                                                    Error al buscar productos.

                                                </div>

                                            `)
                                            .show();

                                    }

                            });

                        },

                        250
                    );

            }
        );



    /*
    =========================================================
    SELECCIONAR PRODUCTO
    =========================================================
    */

    $(document)
        .on(
            'click',
            '.select-buscador-item',
            function()
            {

                let codigo =
                    $(this)
                        .data(
                            'codigo'
                        );


                let nombre =
                    $(this)
                        .data(
                            'nombre'
                        );


                if (!codigo) {
                    return;
                }


                $("#buscarProductoInput")
                    .val(
                        nombre
                    );


                $("#resultadosProductos")
                    .hide()
                    .html('');


                cargarProductoPorCodigo(
                    codigo
                );

            }
        );



    /*
    =========================================================
    CLICK FUERA
    =========================================================
    */

    $(document).on(
        'click',
        function(e)
        {

            if (
                !$(e.target)
                    .closest(
                        '.select-buscador-wrap'
                    )
                    .length
            ) {

                $("#resultadosProductos")
                    .hide();

            }

        }
    );



    /*
    =========================================================
    ENTER EN CANTIDAD
    =========================================================
    */

    $("#quantityInput").on(
        'keydown',
        function(e)
        {

            if (
                e.key === "Enter" ||
                e.keyCode === 13
            ) {

                e.preventDefault();

                $("#addButton")
                    .trigger(
                        'click'
                    );

            }

        }
    );



    /*
    =========================================================
    AGREGAR AL STOCK
    =========================================================
    */

    $("#addButton").click(
        function()
        {

            let codigoBarra =
                $("#barcodeScanned")
                    .val()
                    .trim();


            let cantidad =
                parseInt(
                    $("#quantityInput").val(),
                    10
                );


            let usuarioRegistro =
                $("#usuarioRegistro")
                    .val();


            let ingresoPorCaja =
                $("#ingresoPorCaja")
                    .is(':checked')
                    ? 1
                    : 0;


            let unidadesPorCaja =
                1;


            /*
            =====================================================
            VALIDACIONES
            =====================================================
            */

            if (
                !codigoBarra
            )
            {

                mostrarMensaje(

                    "Debe seleccionar un producto desde el buscador.",

                    "error"

                );

                return;
            }


            if (
                isNaN(cantidad) ||
                cantidad <= 0
            )
            {

                mostrarMensaje(

                    ingresoPorCaja
                        ? "Debe ingresar una cantidad válida de cajas."
                        : "Debe ingresar una cantidad válida.",

                    "error"

                );


                $("#quantityInput")
                    .focus();


                return;
            }


            if (
                ingresoPorCaja === 1
            )
            {

                unidadesPorCaja =
                    parseInt(
                        $("#unidadesPorCajaManual").val(),
                        10
                    );


                if (
                    isNaN(unidadesPorCaja) ||
                    unidadesPorCaja <= 1
                )
                {

                    mostrarMensaje(

                        "Debe indicar cuántas unidades contiene cada caja.",

                        "error"

                    );


                    $("#unidadesPorCajaManual")
                        .focus();


                    return;
                }

            }


            if (
                !usuarioRegistro ||
                parseInt(usuarioRegistro,10) <= 0
            )
            {

                mostrarMensaje(

                    "No se pudo identificar el usuario que realiza el ingreso.",

                    "error"

                );

                return;
            }



            /*
            =====================================================
            PROCESAR

            IMPORTANTE:
            Este endpoint es exclusivo de CrudIngresoDescripcion.
            No modifica producto.caja.
            =====================================================
            */

            $.ajax({

                url:
                    'sumar_producto_descripcion.php',

                type:
                    'POST',

                data:
                {

                    codigoBarra:
                        codigoBarra,

                    cantidad:
                        cantidad,

                    usuarioRegistro:
                        usuarioRegistro,

                    ingresoPorCaja:
                        ingresoPorCaja,

                    unidadesPorCaja:
                        unidadesPorCaja

                },

                dataType:
                    'json',

                cache:
                    false,


                success:
                    function(response)
                    {

                        if (
                            response &&
                            response.success
                        )
                        {

                            mostrarMensaje(

                                response.message,

                                "ok"

                            );

                        }
                        else
                        {

                            mostrarMensaje(

                                response.message ||
                                "No se pudo actualizar el producto.",

                                "error"

                            );

                        }



                        if (
                            response &&
                            response.details
                        )
                        {

                            let d =
                                response.details;


                            let imagen =
                                construirRutaImagen(
                                    d.imagenProducto
                                );


                            let detalleModo =
                                '';


                            if (
                                parseInt(d.ingresoPorCaja) === 1
                            )
                            {

                                detalleModo = `

                                    <div style="margin-bottom:6px;">

                                        <span class="badge-modo badge-modo-caja">

                                            <i class="bi bi-box-seam"></i>

                                            INGRESO POR CAJA

                                        </span>

                                    </div>


                                    <div style="margin-bottom:6px;">

                                        <strong>
                                            Cajas ingresadas:
                                        </strong>

                                        ${d.cantidadSolicitada}

                                    </div>


                                    <div style="margin-bottom:6px;">

                                        <strong>
                                            Unidades por caja:
                                        </strong>

                                        ${d.unidadesPorCaja}

                                    </div>


                                    <div style="margin-bottom:6px;">

                                        <strong>
                                            Total unidades:
                                        </strong>

                                        ${d.cantidadIngresada}

                                    </div>

                                `;

                            }
                            else
                            {

                                detalleModo = `

                                    <div style="margin-bottom:6px;">

                                        <span class="badge-modo badge-modo-unidad">

                                            INGRESO DETALLADO

                                        </span>

                                    </div>


                                    <div style="margin-bottom:6px;">

                                        <strong>
                                            Unidades ingresadas:
                                        </strong>

                                        ${d.cantidadIngresada}

                                    </div>

                                `;

                            }



                            $("#lastScanned")
                                .html(`

                                    <div
                                        style="
                                            display:flex;
                                            gap:15px;
                                            align-items:center;
                                            flex-wrap:wrap;
                                        "
                                    >


                                        <div
                                            style="
                                                width:80px;
                                                height:80px;
                                                border-radius:12px;
                                                overflow:hidden;
                                                background:#fff;
                                                border:1px solid #dde3ea;
                                            "
                                        >

                                            <img
                                                src="${imagen}"
                                                alt="Producto"
                                                style="
                                                    width:100%;
                                                    height:100%;
                                                    object-fit:contain;
                                                    padding:6px;
                                                "
                                                onerror="
                                                    this.onerror=null;
                                                    this.src='${RUTA_DEFAULT}';
                                                "
                                            >

                                        </div>


                                        <div
                                            style="
                                                flex:1;
                                                min-width:220px;
                                            "
                                        >


                                            <div style="margin-bottom:6px;">

                                                <strong>
                                                    Código:
                                                </strong>

                                                ${d.codigoBarra || ''}

                                            </div>


                                            <div style="margin-bottom:6px;">

                                                <strong>
                                                    Producto:
                                                </strong>

                                                ${d.nombre || ''}

                                            </div>


                                            ${detalleModo}


                                            <div>

                                                <strong>
                                                    Existencia actual:
                                                </strong>

                                                ${d.newExistencia}

                                            </div>


                                        </div>


                                    </div>

                                `);

                        }


                        limpiarFormulario();

                    },


                error:
                    function(xhr)
                    {

                        console.error(
                            xhr.responseText
                        );


                        mostrarMensaje(

                            "Error al actualizar el producto.",

                            "error"

                        );

                    }

            });

        }
    );


    setTimeout(
        function()
        {

            $("#buscarProductoInput")
                .focus();

        },

        300
    );

});

</script>