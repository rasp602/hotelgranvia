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

    // ID del usuario que realizará el egreso
    $usuarioRegistro = $usuario->idUsuario;
}
?> 

<style>

.stock-page{
    padding:20px 0 35px;
}

.stock-shell{
    max-width:1400px;
    margin:0 auto;
}

.stock-card{
    background:#fff;
    border-radius:18px;
    box-shadow:0 8px 24px rgba(0,0,0,.10);
    overflow:hidden;
    border:1px solid #e9ecef;
    margin-bottom:20px;
}

.stock-header{
    background:linear-gradient(135deg,#dc3545,#b02a37);
    color:#fff;
    padding:22px 18px;
    text-align:center;
}

.stock-header h2{
    margin:0;
    font-size:28px;
    font-weight:700;
}

.stock-header p{
    margin:8px 0 0;
    font-size:14px;
    opacity:.95;
}

.stock-body{
    background:#f8fafc;
    padding:22px;
}

.form-panel,
.producto-panel,
.ultimo-panel{
    background:#fff;
    border:1px solid #eef2f6;
    border-radius:16px;
    padding:20px;
}

.form-group label,
.label-modern{
    font-weight:700;
    color:#344054;
    margin-bottom:8px;
    display:block;
}

.form-control{
    min-height:46px;
    border-radius:10px!important;
    border:1px solid #d0d5dd!important;
    box-shadow:none!important;
}

.form-control:focus{
    border-color:#dc3545!important;
    box-shadow:0 0 0 .15rem rgba(220,53,69,.15)!important;
}

.input-icon-wrap{
    position:relative;
}

.input-icon-wrap .icon-badge{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    color:#dc3545;
    font-size:18px;
    pointer-events:none;
}

.btn-modern{
    min-height:46px;
    border-radius:10px;
    font-weight:700;
}

.btn-block-modern{
    width:100%;
}

.producto-info-wrap{
    display:flex;
    gap:18px;
    align-items:center;
    flex-wrap:wrap;
}

.producto-img-box{
    width:130px;
    height:130px;
    border-radius:16px;
    background:linear-gradient(135deg,#fff1f2,#ffe2e6);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    border:1px solid #f1c6cc;
    flex-shrink:0;
}

.producto-img-box img{
    width:100%;
    height:100%;
    object-fit:contain;
    display:block;
    padding:8px;
}

.producto-datos{
    flex:1;
    min-width:220px;
}

.producto-titulo{
    font-size:22px;
    font-weight:700;
    color:#1d2939;
    margin-bottom:10px;
}

.dato-linea{
    margin-bottom:8px;
    font-size:15px;
    color:#475467;
}

.dato-linea strong{
    color:#dc3545;
}

.stock-badge{
    display:inline-block;
    padding:7px 12px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    background:#fff1f2;
    color:#dc3545;
    border:1px solid #f5c2c7;
}

.mensaje-resultado{
    margin-top:14px;
    padding:12px 14px;
    border-radius:12px;
    font-weight:600;
}

.mensaje-ok{
    background:#e9f9ee;
    color:#198754;
    border:1px solid #c9edd5;
}

.mensaje-error{
    background:#fdecec;
    color:#dc3545;
    border:1px solid #f5c2c7;
}

.ultimo-ingreso-box{
    background:#f8fafc;
    border:1px dashed #d0d5dd;
    border-radius:14px;
    padding:16px;
    color:#344054;
    font-size:15px;
}

.modulo-titulo{
    font-size:22px;
    font-weight:700;
    color:#dc3545;
    margin-bottom:15px;
    text-align:center;
}

.outer_div_ultimos_ingresadoss{
    margin-top:15px;
}

@media(max-width:767px){

    .stock-page{
        padding:10px 0 25px;
    }

    .stock-shell{
        padding-left:8px;
        padding-right:8px;
    }

    .stock-header h2{
        font-size:22px;
    }

    .stock-body{
        padding:14px;
    }

    .form-panel,
    .producto-panel,
    .ultimo-panel{
        padding:15px;
    }

    .producto-info-wrap{
        flex-direction:column;
        align-items:center;
        text-align:center;
    }

    .producto-img-box{
        width:110px;
        height:110px;
    }

    .producto-titulo{
        font-size:19px;
    }

    .btn-modern{
        width:100%;
    }
}

</style>


<div class="container-fluid stock-page">

    <div class="stock-shell">

        <div class="stock-card">

            <div class="stock-header">

                <h2>
                    <i class="bi bi-qr-code-scan"></i>
                    Egreso de Stock por Cantidad
                </h2>

                <p>
                    Escanea el producto, ingresa la cantidad y descuenta del inventario.
                </p>

            </div>


            <div class="stock-body">

                <div class="row">


                    <!-- FORMULARIO -->
                    <div class="col-md-6 col-sm-12">

                        <div class="form-panel">

                            <div class="modulo-titulo">

                                <i class="bi bi-upc-scan"></i>
                                Escaneo de Producto

                            </div>


                            <form id="productForm" onsubmit="return false;">


                                <!-- USUARIO QUE REALIZA EL EGRESO -->

                                <input
                                    type="hidden"
                                    id="usuarioRegistro"
                                    name="usuarioRegistro"
                                    value="<?php echo isset($usuarioRegistro) ? $usuarioRegistro : ''; ?>"
                                >


                                <div class="form-group">

                                    <label for="productBarcode">
                                        Escanea el código del producto
                                    </label>

                                    <div class="input-icon-wrap">

                                        <input
                                            type="text"
                                            id="productBarcode"
                                            name="productBarcode"
                                            class="form-control"
                                            autofocus
                                            autocomplete="off"
                                        >

                                        <span class="icon-badge">

                                            <i class="fa-solid fa-barcode"></i>

                                        </span>

                                    </div>

                                </div>


                                <div
                                    class="form-group"
                                    style="margin-top:15px;"
                                >

                                    <label for="quantityInput">
                                        Cantidad a egresar
                                    </label>

                                    <input
                                        type="number"
                                        id="quantityInput"
                                        name="quantityInput"
                                        class="form-control"
                                        placeholder="Ejemplo: 150"
                                        required
                                        min="1"
                                    >

                                </div>


                                <div style="margin-top:18px;">

                                    <button
                                        id="egressButton"
                                        type="button"
                                        class="btn btn-danger btn-modern btn-block-modern"
                                    >

                                        <i class="bi bi-dash-circle"></i>
                                        Egresar del Stock

                                    </button>

                                </div>


                            </form>


                            <div
                                class="text-center"
                                style="margin-top:15px;"
                            >

                                <a
                                    href="?c=producto&a=menuProducto"
                                    class="btn btn-outline-danger btn-modern"
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


                    <!-- PRODUCTO DETECTADO -->

                    <div class="col-md-6 col-sm-12">


                        <div
                            id="productDetails"
                            style="display:none;"
                            class="producto-panel"
                        >

                            <div class="modulo-titulo">

                                <i class="bi bi-card-image"></i>
                                Producto Detectado

                            </div>


                            <div class="producto-info-wrap">


                                <div class="producto-img-box">

                                    <img
                                        id="productImage"
                                        src="img/no-image.png"
                                        alt="Producto"
                                        onerror="this.onerror=null;this.src='img/no-image.png';"
                                    >

                                </div>


                                <div class="producto-datos">


                                    <div
                                        class="producto-titulo"
                                        id="productName"
                                    ></div>


                                    <div class="dato-linea">

                                        <strong>Código:</strong>

                                        <span id="productCode"></span>

                                    </div>


                                    <div class="dato-linea">

                                        <strong>Existencia actual:</strong>

                                        <span
                                            class="stock-badge"
                                            id="currentStock"
                                        ></span>

                                    </div>


                                </div>


                            </div>


                        </div>


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

                                Aún no se ha registrado ningún egreso.

                            </div>


                        </div>


                    </div>


                </div>

            </div>

        </div>


        <!-- HISTORIAL -->

        <div class="stock-card">

            <div class="stock-header">

                <h2>

                    <i class="bi bi-box-arrow-up"></i>

                    Últimos Productos Egresados

                </h2>

                <p>
                    Historial reciente de egresos de stock.
                </p>

            </div>


            <div class="stock-body">

                <div class="outer_div_ultimos_ingresadoss"></div>

            </div>


        </div>


    </div>

</div>



<script>

$(document).ready(function() {


    const RUTA_IMAGENES = 'img/productos/';
    const RUTA_DEFAULT = 'img/no-image.png';


    let buscando = false;
    let debounceTimer = null;



    function construirRutaImagen(nombreArchivo) {

        if (
            !nombreArchivo ||
            String(nombreArchivo).trim() === ''
        ) {

            return RUTA_DEFAULT;

        }


        nombreArchivo = String(nombreArchivo).trim();


        if (
            nombreArchivo.startsWith('http://') ||
            nombreArchivo.startsWith('https://') ||
            nombreArchivo.startsWith('img/')
        ) {

            return nombreArchivo;

        }


        return RUTA_IMAGENES + nombreArchivo;

    }



    function mostrarMensaje(html, tipo) {

        let clase = tipo === 'ok'

            ? 'mensaje-resultado mensaje-ok'

            : 'mensaje-resultado mensaje-error';


        $("#result").html(

            '<div class="' + clase + '">' +

            html +

            '</div>'

        );

    }



    function limpiarProductoDetectado() {

        $("#barcodeScanned").val('');

        $("#productDetails").hide();

        $("#quantitySection").hide();

        $("#productImage").attr(
            'src',
            RUTA_DEFAULT
        );

        $("#productName").text('');

        $("#currentStock").text('');

        $("#productCode").text('');

    }



    function limpiarFormularioCompleto() {

        $("#productBarcode").val('');

        $("#quantityInput").val('');

        limpiarProductoDetectado();


        setTimeout(function() {

            $("#productBarcode").focus();

        },300);

    }



    function buscarProducto(codigo) {


        codigo = String(codigo || '').trim();


        if (
            codigo === '' ||
            buscando
        ) {

            return;

        }


        buscando = true;


        $("#result").html('');


        $.ajax({

            url:'consultar_producto.php',

            type:'POST',

            data:{

                codigoBarra:codigo

            },

            dataType:'json',

            cache:false,


            success:function(response) {


                if (
                    response &&
                    response.success
                ) {


                    let details = response.details || {};


                    $("#productName").text(

                        details.nombre ||

                        details.nombreProducto ||

                        ''

                    );


                    $("#currentStock").text(

                        details.existenciaActual ||

                        details.existenciaProducto ||

                        '0'

                    );


                    $("#productCode").text(codigo);


                    $("#barcodeScanned").val(codigo);


                    $("#productImage").attr(

                        'src',

                        construirRutaImagen(
                            details.imagenProducto
                        )

                    );


                    $("#productDetails").show();


                    $("#quantitySection").show();


                    setTimeout(function(){

                        $("#quantityInput").focus().select();

                    },200);


                } else {


                    mostrarMensaje(

                        "Producto no encontrado.",

                        "error"

                    );


                    limpiarProductoDetectado();


                    setTimeout(function(){

                        $("#productBarcode")
                            .val('')
                            .focus();

                    },300);

                }

            },


            error:function(xhr) {


                console.error(xhr.responseText);


                mostrarMensaje(

                    "Error al consultar el producto.",

                    "error"

                );


                limpiarProductoDetectado();


                setTimeout(function(){

                    $("#productBarcode")
                        .val('')
                        .focus();

                },300);

            },


            complete:function(){

                buscando = false;

            }

        });

    }



    /*
    ========================================
    ESCÁNER / ENTER / TAB
    ========================================
    */

    $("#productBarcode").on(

        "keydown",

        function(e) {


            if (

                e.key === "Enter" ||

                e.keyCode === 13 ||

                e.key === "Tab" ||

                e.keyCode === 9

            ) {


                e.preventDefault();


                let codigo = $(this)
                    .val()
                    .trim();


                buscarProducto(codigo);

            }

        }

    );



    /*
    ========================================
    BÚSQUEDA AUTOMÁTICA
    ========================================
    */

    $("#productBarcode").on(

        "input",

        function() {


            let codigo = $(this)
                .val()
                .trim();


            clearTimeout(
                debounceTimer
            );


            debounceTimer = setTimeout(

                function() {


                    if (
                        codigo.length >= 3
                    ) {

                        buscarProducto(
                            codigo
                        );

                    }

                },

                450

            );

        }

    );



    /*
    ========================================
    EGRESAR PRODUCTO
    ========================================
    */

    $("#egressButton").click(function() {


        let codigoBarra = $("#barcodeScanned")
            .val()
            .trim();


        let cantidad = parseInt(

            $("#quantityInput").val(),

            10

        );


        /*
        OBTENER USUARIO
        */

        let usuarioRegistro = $("#usuarioRegistro")
            .val();


        if (!codigoBarra) {


            mostrarMensaje(

                "Primero debe escanear o escribir un producto válido.",

                "error"

            );


            $("#productBarcode").focus();


            return;

        }



        if (
            !cantidad ||
            isNaN(cantidad) ||
            cantidad <= 0
        ) {


            mostrarMensaje(

                "Ingrese una cantidad válida mayor a 0.",

                "error"

            );


            $("#quantityInput").focus();


            return;

        }



        /*
        VALIDAR USUARIO
        */

        if (
            !usuarioRegistro ||
            parseInt(usuarioRegistro) <= 0
        ) {


            mostrarMensaje(

                "No se pudo identificar el usuario que realiza el egreso.",

                "error"

            );


            console.error(
                "usuarioRegistro vacío:",
                usuarioRegistro
            );


            return;

        }



        /*
        ========================================
        AJAX EGRESO
        ========================================
        */


        $.ajax({

            url:'restar_product_varios.php',

            type:'POST',


            /*
            IMPORTANTE:
            AQUÍ SE ENVÍA idUsuario
            */

            data:{

                codigoBarra:codigoBarra,

                cantidad:cantidad,

                usuarioRegistro:usuarioRegistro

            },


            dataType:'json',

            cache:false,


            success:function(response) {


                console.log(
                    "Respuesta egreso:",
                    response
                );


                if (
                    response &&
                    response.success
                ) {


                    mostrarMensaje(

                        response.message ||

                        "Producto egresado correctamente.",

                        "ok"

                    );


                } else {


                    mostrarMensaje(

                        response.message ||

                        "No se pudo egresar el producto.",

                        "error"

                    );

                }



                if (
                    response &&
                    response.details
                ) {


                    let details =
                        response.details;


                    let imagen =
                        construirRutaImagen(

                            details.imagenProducto

                        );


                    $("#lastScanned").html(`


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

                                    ${
                                        details.codigoBarra ||
                                        codigoBarra
                                    }

                                </div>


                                <div style="margin-bottom:6px;">

                                    <strong>
                                        Producto:
                                    </strong>

                                    ${
                                        details.nombre ||

                                        details.nombreProducto ||

                                        ''
                                    }

                                </div>


                                <div style="margin-bottom:6px;">

                                    <strong>
                                        Cantidad egresada:
                                    </strong>

                                    ${
                                        details.cantidadEgresada ||

                                        cantidad
                                    }

                                </div>


                                <div>

                                    <strong>
                                        Existencia actual:
                                    </strong>

                                    ${
                                        details.newExistencia ||

                                        details.existenciaActual ||

                                        ''
                                    }

                                </div>


                            </div>


                        </div>


                    `);

                }


                limpiarFormularioCompleto();

            },


            error:function(xhr) {


                console.error(
                    "ERROR AJAX:"
                );


                console.error(
                    xhr.responseText
                );


                mostrarMensaje(

                    "Error al actualizar el producto.",

                    "error"

                );


                limpiarFormularioCompleto();

            }

        });


    });



    /*
    FOCO INICIAL
    */

    setTimeout(function(){

        $("#productBarcode").focus();

    },500);


});

</script>