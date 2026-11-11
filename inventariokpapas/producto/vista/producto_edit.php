<?php
error_reporting(E_ERROR | E_PARSE);

require_once 'bd/conexionLocal.php';

$sql_producto = "SELECT * FROM tipoProducto";
$result_producto = $conn->query($sql_producto);


/*
===========================================================
CONFIGURACIÓN CAJA DEL PRODUCTO ACTUAL
===========================================================
*/

$cantidadCajaActual = isset($vte->caja)
    ? (int)$vte->caja
    : 1;

if ($cantidadCajaActual <= 0) {
    $cantidadCajaActual = 1;
}

$productoEsCaja = ($cantidadCajaActual > 1);
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

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
?> 

<style>

.producto-page {
    padding: 20px 0 35px 0;
}

.producto-shell {
    max-width: 900px;
    margin: 0 auto;
}

.producto-card {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.producto-header {
    background: linear-gradient(135deg, #0d6efd, #0a58ca);
    color: #fff;
    padding: 22px 18px;
    text-align: center;
}

.producto-header h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
}

.producto-header p {
    margin: 8px 0 0 0;
    font-size: 14px;
    opacity: .95;
}

.producto-body {
    background: #f8fafc;
    padding: 24px;
}

.form-panel {
    background: #fff;
    border: 1px solid #eef2f6;
    border-radius: 16px;
    padding: 22px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-weight: 700;
    color: #344054;
    margin-bottom: 8px;
}

.form-control {
    min-height: 44px;
    border-radius: 10px;
    border: 1px solid #d0d5dd;
    box-shadow: none;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.15rem rgba(13,110,253,0.15);
}


/*
===========================================================
CAJA
===========================================================
*/

.caja-config {
    margin-top: 18px;
    background: #f8fbff;
    border: 1px solid #dbeafe;
    border-radius: 14px;
    padding: 16px;
}

.caja-switch {
    display: flex;
    align-items: center;
    gap: 12px;
}

.caja-switch input {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.caja-switch label {
    margin: 0;
    cursor: pointer;
    font-weight: 700;
    color: #344054;
}

.caja-ayuda {
    color: #667085;
    font-size: 13px;
    margin-top: 7px;
}

#contenedorCaja {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #dbeafe;
}

.caja-ejemplo {
    background: #e8f1ff;
    color: #0d6efd;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 13px;
    margin-top: 10px;
}


/*
===========================================================
IMAGEN
===========================================================
*/

.preview-box {
    margin-top: 12px;
    border: 2px dashed #d0d5dd;
    border-radius: 14px;
    background: #fff;
    padding: 15px;
    text-align: center;
}

.preview-box img {
    max-width: 100%;
    max-height: 220px;
    object-fit: contain;
    border-radius: 10px;
    margin: 0 auto;
    display: block;
}

.img-actual-label {
    display: inline-block;
    background: #e8f1ff;
    color: #0d6efd;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 10px;
}

.btn-guardar {
    min-height: 46px;
    border-radius: 10px;
    font-weight: 700;
    min-width: 180px;
}

.acciones {
    text-align: center;
    margin-top: 25px;
}

@media (max-width: 767px) {

    .producto-page {
        padding: 10px 0 25px;
    }

    .producto-shell {
        padding-left: 8px;
        padding-right: 8px;
    }

    .producto-header h2 {
        font-size: 22px;
    }

    .producto-body {
        padding: 14px;
    }

    .form-panel {
        padding: 16px;
    }

    .btn-guardar {
        width: 100%;
    }
}

</style>


<div class="producto-page">

<div class="producto-shell">

<div class="producto-card">


    <div class="producto-header">

        <h2>
            <i class="fas fa-edit"></i>
            Editar Producto
        </h2>

        <p>
            Actualiza los datos del producto seleccionado.
        </p>

    </div>


    <div class="producto-body">

        <div class="form-panel">


            <form
                id="form1"
                action="?c=producto&a=Guardar"
                method="post"
                enctype="multipart/form-data"
            >


                <!-- ID PRODUCTO -->

                <input
                    type="hidden"
                    name="idProducto"
                    id="idProducto"
                    value="<?php echo htmlspecialchars($vte->idProducto); ?>"
                >


                <!-- IMAGEN ACTUAL -->

                <input
                    type="hidden"
                    name="imagenActual"
                    value="<?php echo htmlspecialchars($vte->imagenProducto); ?>"
                >



                <!-- TIPO PRODUCTO -->

                <div class="form-group">

                    <label for="idTipoProducto">
                        Tipo de Producto
                    </label>

                    <select
                        name="idTipoProducto"
                        id="idTipoProducto"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Seleccionar tipo producto
                        </option>


                        <?php

                        if ($result_producto) {

                            while ($row_producto = $result_producto->fetch_assoc()) {

                                $selected = (
                                    $row_producto['idTipoProducto'] ==
                                    $vte->idTipoProducto
                                )
                                    ? 'selected'
                                    : '';

                        ?>

                            <option
                                value="<?php echo $row_producto['idTipoProducto']; ?>"
                                <?php echo $selected; ?>
                            >

                                <?php
                                echo htmlspecialchars(
                                    $row_producto['nombreTipoProducto']
                                );
                                ?>

                            </option>

                        <?php
                            }
                        }
                        ?>

                    </select>

                </div>



                <!-- NOMBRE -->

                <div class="form-group">

                    <label for="nombreProducto">
                        Nombre de Producto
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="nombreProducto"
                        id="nombreProducto"
                        placeholder="Nombre del Producto"
                        value="<?php echo htmlspecialchars($vte->nombreProducto); ?>"
                        required
                    >

                </div>



                <!-- CODIGO -->

                <div class="form-group">

                    <label for="codigoBarra">
                        Código de Barra
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="codigoBarra"
                        id="codigoBarra"
                        placeholder="Código de Barra"
                        value="<?php echo htmlspecialchars($vte->codigoBarra); ?>"
                    >

                </div>



                <!-- PRECIO -->

                <div class="form-group">

                    <label for="precioProducto">
                        Precio del Producto
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="precioProducto"
                        id="precioProducto"
                        value="<?php echo htmlspecialchars($vte->precioProducto); ?>"
                        required
                        onkeypress="return numeros(event);"
                    >

                </div>



                <!-- ===================================================
                CONFIGURACIÓN CAJA
                ==================================================== -->

                <div class="caja-config">


                    <div class="caja-switch">

                        <input
                            type="checkbox"
                            id="productoCaja"
                            <?php echo $productoEsCaja ? 'checked' : ''; ?>
                        >


                        <label for="productoCaja">

                            <i class="bi bi-box-seam"></i>

                            Este producto viene por caja

                        </label>

                    </div>


                    <div class="caja-ayuda">

                        Una lectura del código de barras representa varias
                        unidades cuando el producto viene empaquetado por caja.

                    </div>


                    <div
                        id="contenedorCaja"
                        style="<?php echo $productoEsCaja ? '' : 'display:none;'; ?>"
                    >


                        <div class="form-group">

                            <label for="caja">
                                Unidades que contiene cada caja
                            </label>


                            <input
                                type="number"
                                class="form-control"
                                name="caja"
                                id="caja"
                                value="<?php echo $cantidadCajaActual; ?>"
                                min="1"
                                step="1"
                                <?php echo $productoEsCaja ? 'required' : ''; ?>
                            >


                            <div class="caja-ejemplo">

                                <i class="bi bi-info-circle"></i>

                                Ejemplo: si la caja contiene
                                <strong>10 galletas</strong>,
                                ingresa <strong>10</strong>.

                            </div>

                        </div>

                    </div>


                </div>



                <!-- IMAGEN -->

                <div
                    class="form-group"
                    style="margin-top:18px;"
                >

                    <label for="imagenProducto">
                        Imagen del Producto
                    </label>


                    <input
                        type="file"
                        class="form-control"
                        name="imagenProducto"
                        id="imagenProducto"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                    >


                    <small class="text-muted">
                        Deja este campo vacío para conservar la imagen actual.
                    </small>


                    <?php

                    $rutaImagen = !empty($vte->imagenProducto)
                        ? 'img/productos/' . $vte->imagenProducto
                        : 'img/no-image.png';

                    ?>


                    <div class="preview-box">

                        <div class="img-actual-label">
                            Imagen actual
                        </div>

                        <br>


                        <img
                            id="previewImagen"
                            src="<?php echo htmlspecialchars($rutaImagen); ?>"
                            alt="Imagen del producto"
                            onerror="
                                this.onerror=null;
                                this.src='img/no-image.png';
                            "
                        >

                    </div>

                </div>



                <!-- EXISTENCIA -->

                <input
                    type="hidden"
                    name="existenciaProducto"
                    id="existenciaProducto"
                    value="<?php echo htmlspecialchars($vte->existenciaProducto); ?>"
                >



                <!-- FECHA -->

                <input
                    type="hidden"
                    name="fechaIngreso"
                    id="fechaIngreso"
                    value="<?php echo htmlspecialchars($vte->fechaIngreso); ?>"
                >



                <!-- GUARDAR -->

                <div class="acciones">

                    <button
                        type="submit"
                        id="Guardar"
                        class="btn btn-success btn-guardar"
                    >

                        <i class="fas fa-save"></i>

                        Actualizar Producto

                    </button>

                </div>


            </form>


        </div>

    </div>

</div>

</div>

</div>



<script>

$(document).ready(function(){


    /*
    ==========================================================
    CONFIGURACION CAJA
    ==========================================================
    */

    $('#productoCaja').on('change', function(){

        if ($(this).is(':checked')) {

            $('#contenedorCaja').slideDown(180);

            $('#caja')
                .prop('required', true)
                .focus();

        } else {

            $('#contenedorCaja').slideUp(180);

            $('#caja')
                .val(1)
                .prop('required', false);

        }

    });



    /*
    ==========================================================
    VALIDACION
    ==========================================================
    */

    $('#form1').on('submit', function(e){

        if ($('#productoCaja').is(':checked')) {

            let cantidadCaja = parseInt(
                $('#caja').val(),
                10
            );

            if (
                isNaN(cantidadCaja) ||
                cantidadCaja <= 1
            ) {

                e.preventDefault();

                alert(
                    'Si el producto viene por caja, debe ingresar una cantidad mayor a 1.'
                );

                $('#caja').focus();

                return false;
            }

        } else {

            $('#caja').val(1);

        }

    });



    /*
    ==========================================================
    PREVIEW IMAGEN
    ==========================================================
    */

    $('#imagenProducto').on('change', function(e){

        const archivo = e.target.files[0];

        if (!archivo) {
            return;
        }

        const tiposPermitidos = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/webp'
        ];

        if (
            $.inArray(
                archivo.type,
                tiposPermitidos
            ) === -1
        ) {

            alert(
                'Formato no permitido. Solo JPG, JPEG, PNG o WEBP.'
            );

            $(this).val('');

            return;
        }

        const reader = new FileReader();

        reader.onload = function(event) {

            $('#previewImagen')
                .attr(
                    'src',
                    event.target.result
                );

        };

        reader.readAsDataURL(archivo);

    });

});


function numeros(e)
{
    let key = e.keyCode || e.which;

    let tecla =
        String.fromCharCode(key);

    let numeros =
        "0123456789";

    if (
        numeros.indexOf(tecla) == -1 &&
        key != 8 &&
        key != 9 &&
        key != 13
    ) {
        return false;
    }
}

</script>


</div>