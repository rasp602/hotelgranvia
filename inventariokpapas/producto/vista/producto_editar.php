<?php
error_reporting(E_ERROR | E_PARSE);
?>

<script
    type="text/javascript"
    src="https://code.jquery.com/jquery-1.11.3.min.js">
</script>

<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js">
</script>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"
/>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
/>

<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js">
</script>


<div class="container-fluid">

<?php

$usuario = null;

if(isset($_SESSION["usuarioInventario"]))
{
    $usuario =
        $_SESSION["usuarioInventario"];


    if($usuario->nivel == "U")
    {
        include_once
            'menu_principal/vista/Menu_Usuarios.php';
    }


    if($usuario->nivel == "F")
    {
        include_once
            'menu_principal/vista/Menu_Fiscalizador.php';
    }


    if($usuario->nivel == "I")
    {
        include_once
            'menu_principal/vista/Menu_Inventario.php';
    }
}

?>


<style>

.producto-page{
    padding:20px 0 35px;
}

.producto-shell{
    max-width:900px;
    margin:0 auto;
}

.producto-card{
    background:#fff;
    border-radius:18px;
    box-shadow:0 8px 24px rgba(0,0,0,.10);
    overflow:hidden;
    border:1px solid #e9ecef;
}

.producto-header{
    background:linear-gradient(
        135deg,
        #0d6efd,
        #0a58ca
    );

    color:#fff;

    padding:22px 18px;

    text-align:center;
}

.producto-header h2{
    margin:0;
    font-size:28px;
    font-weight:700;
}

.producto-header p{
    margin:8px 0 0;
    font-size:14px;
    opacity:.95;
}

.producto-body{
    background:#f8fafc;
    padding:24px;
}

.form-panel{
    background:#fff;
    border:1px solid #eef2f6;
    border-radius:16px;
    padding:22px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    font-weight:700;
    color:#344054;
    margin-bottom:8px;
}

.form-control{
    min-height:44px;
    border-radius:10px;
    border:1px solid #d0d5dd;
    box-shadow:none;
}

.form-control:focus{
    border-color:#0d6efd;
    box-shadow:
        0 0 0 .15rem
        rgba(13,110,253,.15);
}


/*
====================================================
CAJA
====================================================
*/

.caja-config{
    margin-top:18px;
    background:#f8fbff;
    border:1px solid #dbeafe;
    border-radius:14px;
    padding:16px;
}

.caja-switch{
    display:flex;
    align-items:center;
    gap:12px;
}

.caja-switch input{
    width:20px;
    height:20px;
    cursor:pointer;
}

.caja-switch label{
    margin:0;
    font-size:15px;
    font-weight:700;
    color:#344054;
    cursor:pointer;
}

.caja-ayuda{
    color:#667085;
    font-size:13px;
    margin-top:7px;
}

#contenedorCaja{
    display:none;
    margin-top:15px;
    padding-top:15px;
    border-top:1px solid #dbeafe;
}

.caja-ejemplo{
    background:#e8f1ff;
    color:#0d6efd;
    border-radius:10px;
    padding:10px 12px;
    font-size:13px;
    margin-top:10px;
}


/*
====================================================
IMAGEN
====================================================
*/

.preview-box{
    margin-top:12px;
    border:2px dashed #d0d5dd;
    border-radius:14px;
    background:#fff;
    padding:15px;
    text-align:center;
}

.preview-box img{
    max-width:100%;
    max-height:220px;
    object-fit:contain;
    border-radius:10px;
    display:none;
    margin:0 auto;
}

.preview-placeholder{
    color:#667085;
    font-size:14px;
}

.btn-guardar{
    min-height:46px;
    border-radius:10px;
    font-weight:700;
    min-width:180px;
}

.acciones{
    text-align:center;
    margin-top:25px;
}


@media(max-width:767px){

    .producto-page{
        padding:10px 0 25px;
    }

    .producto-shell{
        padding-left:8px;
        padding-right:8px;
    }

    .producto-header h2{
        font-size:22px;
    }

    .producto-body{
        padding:14px;
    }

    .form-panel{
        padding:16px;
    }

    .btn-guardar{
        width:100%;
    }

}

</style>



<div class="producto-page">

<div class="producto-shell">

<div class="producto-card">


<div class="producto-header">

    <h2>

        <i class="fas fa-plus-circle"></i>

        Registrar Producto

    </h2>

    <p>
        Completa los datos del producto.
    </p>

</div>


<div class="producto-body">

<div class="form-panel">


<form
    id="form1"
    action="?c=producto&a=Guardar"
    name="form1"
    method="post"
    enctype="multipart/form-data"
>


<input
    type="hidden"
    id="idProducto"
    name="idProducto"
    value=""
>


<!-- =================================================
TIPO PRODUCTO
================================================= -->

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
foreach(
    $this->model->ListarTipoProducto()
    as $a
):
?>

<option
    value="<?php echo $a->idTipoProducto; ?>"
>

<?php
echo $a->nombreTipoProducto;
?>

</option>

<?php endforeach; ?>


</select>

</div>



<!-- =================================================
NOMBRE
================================================= -->

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
    required
>

</div>



<!-- =================================================
CODIGO
================================================= -->

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
>

</div>



<!-- =================================================
CONFIGURACION CAJA
================================================= -->

<div class="caja-config">


<div class="caja-switch">

<input
    type="checkbox"
    id="productoCaja"
>


<label for="productoCaja">

    <i class="bi bi-box-seam"></i>

    Este producto viene por caja

</label>

</div>


<div class="caja-ayuda">

Activa esta opción cuando una lectura del código de barras
represente varias unidades del producto.

</div>



<div id="contenedorCaja">


<div class="form-group">

<label for="caja">

    Unidades que contiene cada caja

</label>


<input
    type="number"
    class="form-control"
    name="caja"
    id="caja"
    value="1"
    min="1"
    step="1"
>


<div class="caja-ejemplo">

    <i class="bi bi-info-circle"></i>

    Ejemplo:
    si una caja contiene 10 paquetes de galletas,
    ingresa <strong>10</strong>.

</div>


</div>


</div>


</div>



<!-- =================================================
IMAGEN
================================================= -->

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
    accept="
        image/png,
        image/jpeg,
        image/jpg,
        image/webp
    "
>


<small class="text-muted">

Formatos permitidos:
JPG, JPEG, PNG, WEBP

</small>


<div class="preview-box">

<img
    id="previewImagen"
    src=""
    alt="Vista previa"
>


<div
    id="previewTexto"
    class="preview-placeholder"
>

Aquí se mostrará la vista previa de la imagen

</div>


</div>

</div>



<input
    type="hidden"
    name="precioProducto"
    id="precioProducto"
    value="1000"
>


<input
    type="hidden"
    name="existenciaProducto"
    id="existenciaProducto"
    value="0"
>


<input
    type="hidden"
    name="fechaIngreso"
    id="fechaIngreso"
    value="<?php echo date("Y-m-d"); ?>"
>



<div class="acciones">

<button
    type="submit"
    id="Guardar"
    class="btn btn-success btn-guardar"
>

<i class="fas fa-save"></i>

Guardar Producto

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
    =================================================
    PRODUCTO POR CAJA
    =================================================
    */

    $('#productoCaja').on(
        'change',
        function()
        {

            if($(this).is(':checked'))
            {
                $('#contenedorCaja')
                    .slideDown(180);

                $('#caja')
                    .prop('required', true)
                    .focus();
            }
            else
            {
                $('#contenedorCaja')
                    .slideUp(180);

                $('#caja')
                    .val(1)
                    .prop('required', false);
            }

        }
    );


    /*
    =================================================
    VALIDACION FORMULARIO
    =================================================
    */

    $('#form1').on(
        'submit',
        function(e)
        {

            if(
                $('#productoCaja').is(':checked')
            )
            {
                let cantidadCaja =
                    parseInt(
                        $('#caja').val(),
                        10
                    );


                if(
                    isNaN(cantidadCaja) ||
                    cantidadCaja <= 1
                )
                {
                    e.preventDefault();

                    alert(
                        'Si el producto viene por caja, ingresa una cantidad mayor a 1.'
                    );

                    $('#caja')
                        .focus();

                    return false;
                }
            }
            else
            {
                $('#caja').val(1);
            }

        }
    );


    /*
    =================================================
    IMAGEN
    =================================================
    */

    $('#imagenProducto').on(
        'change',
        function(e)
        {

            const archivo =
                e.target.files[0];


            if(!archivo)
            {
                $('#previewImagen')
                    .hide()
                    .attr('src','');

                $('#previewTexto')
                    .show();

                return;
            }


            const tiposPermitidos = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/webp'
            ];


            if(
                $.inArray(
                    archivo.type,
                    tiposPermitidos
                ) === -1
            )
            {
                alert(
                    'Formato no permitido.'
                );

                $(this).val('');

                return;
            }


            const reader =
                new FileReader();


            reader.onload =
                function(event)
                {
                    $('#previewImagen')
                        .attr(
                            'src',
                            event.target.result
                        )
                        .show();

                    $('#previewTexto')
                        .hide();
                };


            reader.readAsDataURL(
                archivo
            );

        }
    );

});

</script>


</div>