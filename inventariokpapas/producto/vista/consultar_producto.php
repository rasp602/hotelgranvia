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
====================================================
NUEVO: INFORMACION CAJA
====================================================
*/

.caja-info {
    display: none;
    margin-top: 10px;
    padding: 12px 14px;
    border-radius: 12px;
    background: #e8f1ff;
    border: 1px solid #bfd5ff;
    color: #0d6efd;
    font-size: 14px;
}

.caja-info strong {
    color: #084298;
}

.caja-preview {
    display: none;
    margin-top: 10px;
    padding: 11px 14px;
    border-radius: 10px;
    background: #fff8e1;
    border: 1px solid #ffe69c;
    color: #664d03;
    font-size: 14px;
    font-weight: 600;
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

.badge-caja {
    display: inline-block;
    margin-left: 8px;
    padding: 3px 8px;
    border-radius: 999px;
    background: #e8f1ff;
    color: #0d6efd;
    font-size: 11px;
    font-weight: 700;
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


        <!-- ===================================================
        INGRESO
        ==================================================== -->

        <div class="stock-card">

            <div class="stock-header">

                <h2>
                    <i class="bi bi-search"></i>
                    Ingreso de Stock por Buscador
                </h2>

                <p>
                    Busca el producto escribiendo su nombre o código y luego ingresa la cantidad.
                </p>

            </div>


            <div class="stock-body">

                <div class="row">


                    <!-- =================================================
                    FORMULARIO
                    ================================================== -->

                    <div class="col-md-6 col-sm-12">

                        <div class="form-panel">

                            <div class="modulo-titulo">

                                <i class="bi bi-search"></i>

                                Buscar Producto

                            </div>


                            <form id="productForm" onsubmit="return false;">


                                <!-- USUARIO -->

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



                                <!-- CANTIDAD -->

                                <div
                                    class="form-group"
                                    style="margin-top:15px;"
                                >

                                    <label for="quantityInput">

                                        Cantidad a ingresar

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


                                    <!-- NUEVO -->
                                    <div
                                        id="cajaPreview"
                                        class="caja-preview"
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
                    PRODUCTO SELECCIONADO
                    ================================================== -->

                    <div
                        class="col-md-6 col-sm-12"
                        style="margin-top:0;"
                    >


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


                                <!-- IMAGEN -->

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



                                <!-- DATOS -->

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


                                    <!-- NUEVO: CAJA -->

                                    <div
                                        id="cajaInfo"
                                        class="caja-info"
                                    >

                                        <i class="bi bi-box-seam"></i>

                                        Producto configurado por caja.

                                        <br>

                                        <strong>
                                            Unidades por caja:
                                        </strong>

                                        <span id="unidadesCaja"></span>

                                    </div>


                                </div>


                            </div>

                        </div>



                        <!-- =================================================
                        ULTIMO MOVIMIENTO
                        ================================================== -->

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



        <!-- ===================================================
        HISTORIAL
        ==================================================== -->

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


    /*
    ============================================================
    CONFIGURACION
    ============================================================
    */

    const RUTA_IMAGENES =
        'img/productos/';


    const RUTA_DEFAULT =
        'img/no-image.png';


    /*
    Caja del producto seleccionado
    */

    let cajaProductoActual = 1;



    /*
    ============================================================
    CONSTRUIR RUTA DE IMAGEN
    ============================================================
    */

    function construirRutaImagen(
        nombreArchivo
    ) {


        if (
            !nombreArchivo ||
            String(nombreArchivo).trim() === ''
        ) {

            return RUTA_DEFAULT;

        }


        nombreArchivo =
            String(nombreArchivo).trim();


        /*
        Si ya viene como ruta completa
        */

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
    ============================================================
    MENSAJES
    ============================================================
    */

    function mostrarMensaje(
        html,
        tipo
    ) {


        let clase =
            (
                tipo === 'ok'
            )
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
    ============================================================
    ACTUALIZAR PREVIEW DE CAJA
    ============================================================
    */

    function actualizarPreviewCaja()
    {


        let cantidad =
            parseInt(
                $("#quantityInput").val(),
                10
            );


        if (
            isNaN(cantidad) ||
            cantidad <= 0
        ) {

            $("#cajaPreview")
                .hide()
                .html('');

            return;

        }


        /*
        PRODUCTO POR CAJA
        */

        if (
            cajaProductoActual > 1
        ) {


            let totalUnidades =
                cantidad *
                cajaProductoActual;


            $("#cajaPreview")
                .html(

                    '<i class="bi bi-calculator"></i> ' +

                    cantidad +

                    ' caja(s) × ' +

                    cajaProductoActual +

                    ' unidades = ' +

                    '<strong>' +

                    totalUnidades +

                    ' unidades a ingresar</strong>'

                )
                .show();


        } else {


            $("#cajaPreview")
                .hide()
                .html('');

        }

    }



    /*
    ============================================================
    LIMPIAR FORMULARIO
    ============================================================
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
        CAJA
        */

        cajaProductoActual = 1;


        $("#cajaInfo")
            .hide();


        $("#unidadesCaja")
            .text('');


        $("#cajaPreview")
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
    ============================================================
    CARGAR PRODUCTO
    ============================================================
    */

    function cargarProductoPorCodigo(
        codigoBarra
    )
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


            data:
            {

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


                        /*
                        CODIGO
                        */

                        $("#barcodeScanned")
                            .val(
                                codigoBarra
                            );


                        /*
                        NOMBRE
                        */

                        $("#productName")
                            .text(
                                response.details.nombre ||
                                ''
                            );


                        /*
                        STOCK
                        */

                        $("#currentStock")
                            .text(
                                response.details.existenciaActual ||
                                '0'
                            );


                        /*
                        CODIGO VISIBLE
                        */

                        $("#productCode")
                            .text(
                                codigoBarra
                            );


                        /*
                        =================================================
                        NUEVO:
                        OBTENER CAJA
                        =================================================
                        */

                        cajaProductoActual =
                            parseInt(
                                response.details.caja ||
                                1,
                                10
                            );


                        if (
                            isNaN(
                                cajaProductoActual
                            ) ||
                            cajaProductoActual <= 0
                        ) {

                            cajaProductoActual =
                                1;

                        }



                        /*
                        MOSTRAR CONFIGURACION CAJA
                        */

                        if (
                            cajaProductoActual > 1
                        )
                        {

                            $("#unidadesCaja")
                                .text(
                                    cajaProductoActual
                                );


                            $("#cajaInfo")
                                .show();

                        }
                        else
                        {

                            $("#cajaInfo")
                                .hide();


                            $("#unidadesCaja")
                                .text('');

                        }



                        /*
                        IMAGEN
                        */

                        let imagen =
                            construirRutaImagen(

                                response.details.imagenProducto

                            );


                        $("#productImage")
                            .attr(
                                'src',
                                imagen
                            );


                        /*
                        MOSTRAR PANEL
                        */

                        $("#productDetails")
                            .show();


                        $("#quantitySection")
                            .show();


                        /*
                        ACTUALIZAR PREVIEW
                        */

                        actualizarPreviewCaja();


                        /*
                        FOCO CANTIDAD
                        */

                        setTimeout(
                            function()
                            {

                                $("#quantityInput")
                                    .focus()
                                    .select();

                            },

                            150
                        );


                    }
                    else
                    {


                        mostrarMensaje(

                            response.message ||
                            "Producto no encontrado.",

                            "error"

                        );


                        limpiarFormulario();

                    }

                },


            error:
                function(
                    xhr,
                    status,
                    error
                )
                {


                    console.error(
                        xhr.responseText
                    );


                    mostrarMensaje(

                        "Error al consultar el producto.",

                        "error"

                    );


                    limpiarFormulario();

                }

        });

    }



    /*
    ============================================================
    BUSCADOR DE PRODUCTOS
    ============================================================
    */

    $("#buscarProductoInput")
        .on(
            'keyup',
            function(e)
            {


                let busqueda =
                    $(this)
                        .val()
                        .trim();


                /*
                Desmarcar producto anterior
                */

                $("#barcodeScanned")
                    .val('');


                $("#productDetails")
                    .hide();


                cajaProductoActual =
                    1;


                $("#cajaInfo")
                    .hide();


                $("#cajaPreview")
                    .hide()
                    .html('');



                if (
                    timerBuscador
                ) {

                    clearTimeout(
                        timerBuscador
                    );

                }



                if (
                    busqueda.length < 2
                )
                {

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


                                data:
                                {

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


                                                        let caja =
                                                            parseInt(
                                                                producto.caja ||
                                                                1,
                                                                10
                                                            );


                                                        if (
                                                            isNaN(caja) ||
                                                            caja <= 0
                                                        ) {

                                                            caja =
                                                                1;

                                                        }


                                                        let badgeCaja =
                                                            '';


                                                        if (
                                                            caja > 1
                                                        )
                                                        {

                                                            badgeCaja =

                                                                '<span class="badge-caja">' +

                                                                caja +

                                                                ' por caja' +

                                                                '</span>';

                                                        }



                                                        html += `

                                                            <div
                                                                class="select-buscador-item"

                                                                data-codigo="${producto.codigoBarra}"

                                                                data-nombre="${producto.nombreProducto}"

                                                                data-caja="${caja}"
                                                            >

                                                                <strong>

                                                                    ${producto.codigoBarra}

                                                                </strong>

                                                                -

                                                                ${producto.nombreProducto}

                                                                ${badgeCaja}

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


                                        }
                                        else
                                        {


                                            $("#resultadosProductos")
                                                .html(`

                                                    <div class="select-buscador-item">

                                                        No se encontraron productos.

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
    ============================================================
    SELECCIONAR PRODUCTO
    ============================================================
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


                /*
                Si es el mensaje:
                No se encontraron productos
                */

                if (
                    !codigo
                ) {

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
    ============================================================
    CERRAR RESULTADOS AL HACER CLICK AFUERA
    ============================================================
    */

    $(document)
        .on(
            'click',
            function(e)
            {


                if (
                    !$(e.target)
                        .closest(
                            '.select-buscador-wrap'
                        )
                        .length
                )
                {

                    $("#resultadosProductos")
                        .hide();

                }

            }
        );



    /*
    ============================================================
    CUANDO CAMBIA LA CANTIDAD
    ============================================================
    */

    $("#quantityInput")
        .on(
            'input keyup change',
            function()
            {

                actualizarPreviewCaja();

            }
        );



    /*
    ============================================================
    ENTER EN CANTIDAD
    ============================================================
    */

    $("#quantityInput")
        .on(
            'keydown',
            function(e)
            {


                if (
                    e.key === "Enter" ||
                    e.keyCode === 13
                )
                {

                    e.preventDefault();


                    $("#addButton")
                        .trigger(
                            'click'
                        );

                }

            }
        );



    /*
    ============================================================
    INGRESAR PRODUCTO
    ============================================================
    */

    $("#addButton")
        .click(
            function()
            {


                let codigoBarra =
                    $("#barcodeScanned")
                        .val()
                        .trim();


                let cantidad =
                    parseInt(
                        $("#quantityInput")
                            .val(),
                        10
                    );


                let usuarioRegistro =
                    $("#usuarioRegistro")
                        .val();



                /*
                VALIDAR PRODUCTO
                */

                if (
                    !codigoBarra ||
                    codigoBarra === ''
                )
                {


                    mostrarMensaje(

                        "Debe seleccionar un producto desde el buscador.",

                        "error"

                    );


                    return;

                }



                /*
                VALIDAR CANTIDAD
                */

                if (
                    !cantidad ||
                    isNaN(cantidad) ||
                    cantidad <= 0
                )
                {


                    mostrarMensaje(

                        "Debe ingresar una cantidad válida.",

                        "error"

                    );


                    $("#quantityInput")
                        .focus();


                    return;

                }



                /*
                VALIDAR USUARIO
                */

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
                ========================================================
                IMPORTANTE

                NO ENVIAMOS LA VARIABLE CAJA DESDE JAVASCRIPT.

                sumar_product_varios.php obtiene producto.caja
                directamente desde la base de datos.

                Así evitamos inconsistencias.
                ========================================================
                */


                $.ajax({


                    url:
                        'sumar_product_varios.php',


                    type:
                        'POST',


                    data:
                    {

                        codigoBarra:
                            codigoBarra,

                        cantidad:
                            cantidad,

                        usuarioRegistro:
                            usuarioRegistro

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

                                    response.message ||
                                    "Producto ingresado correctamente.",

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



                            /*
                            =================================================
                            DETALLE ULTIMO INGRESO
                            =================================================
                            */

                            if (
                                response &&
                                response.details
                            )
                            {


                                let details =
                                    response.details;


                                let imagen =
                                    construirRutaImagen(

                                        details.imagenProducto

                                    );


                                let caja =
                                    parseInt(
                                        details.caja ||
                                        1,
                                        10
                                    );


                                if (
                                    isNaN(caja) ||
                                    caja <= 0
                                ) {

                                    caja =
                                        1;

                                }



                                let detalleCantidad =
                                    '';



                                /*
                                =============================================
                                PRODUCTO POR CAJA
                                =============================================
                                */

                                if (
                                    caja > 1
                                )
                                {


                                    detalleCantidad = `


                                        <div
                                            style="
                                                margin-bottom:6px;
                                            "
                                        >

                                            <strong>
                                                Cajas ingresadas:
                                            </strong>

                                            ${details.cantidad || cantidad}

                                        </div>


                                        <div
                                            style="
                                                margin-bottom:6px;
                                            "
                                        >

                                            <strong>
                                                Unidades por caja:
                                            </strong>

                                            ${caja}

                                        </div>


                                        <div
                                            style="
                                                margin-bottom:6px;
                                            "
                                        >

                                            <strong>
                                                Total de unidades ingresadas:
                                            </strong>

                                            ${details.cantidadIngresada || ((details.cantidad || cantidad) * caja)}

                                        </div>

                                    `;


                                }

                                /*
                                =============================================
                                PRODUCTO INDIVIDUAL
                                =============================================
                                */

                                else
                                {


                                    detalleCantidad = `


                                        <div
                                            style="
                                                margin-bottom:6px;
                                            "
                                        >

                                            <strong>
                                                Unidades ingresadas:
                                            </strong>

                                            ${details.cantidadIngresada || details.cantidad || cantidad}

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


                                            <!-- IMAGEN -->

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



                                            <!-- INFORMACION -->

                                            <div
                                                style="
                                                    flex:1;
                                                    min-width:220px;
                                                "
                                            >


                                                <div
                                                    style="
                                                        margin-bottom:6px;
                                                    "
                                                >

                                                    <strong>
                                                        Código:
                                                    </strong>

                                                    ${details.codigoBarra || codigoBarra}

                                                </div>


                                                <div
                                                    style="
                                                        margin-bottom:6px;
                                                    "
                                                >

                                                    <strong>
                                                        Producto:
                                                    </strong>

                                                    ${details.nombre || ''}

                                                </div>


                                                ${detalleCantidad}


                                                <div>

                                                    <strong>
                                                        Existencia actual:
                                                    </strong>

                                                    ${details.newExistencia ?? ''}

                                                </div>


                                            </div>


                                        </div>

                                    `);

                            }



                            /*
                            Limpiamos producto,
                            pero dejamos visible el mensaje
                            */

                            limpiarFormulario();

                        },



                    error:
                        function(
                            xhr,
                            status,
                            error
                        )
                        {


                            console.error(
                                xhr.responseText
                            );


                            mostrarMensaje(

                                "Error al actualizar el producto.",

                                "error"

                            );


                            /*
                            No modificamos ningún otro flujo
                            */

                            limpiarFormulario();

                        }

                });

            }
        );



    /*
    ============================================================
    FOCO INICIAL
    ============================================================
    */

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