<?php
error_reporting(E_ERROR | E_PARSE);
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

<script>
    toastr.info('Bienvenido');
</script>

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
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
    }

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
        display: none;
        margin: 0 auto;
    }

    .preview-placeholder {
        color: #667085;
        font-size: 14px;
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
            padding: 10px 0 25px 0;
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
                <h2><i class="fas fa-plus-circle"></i> Registrar Producto</h2>
                <p>Completa los datos del producto y sube una imagen si corresponde.</p>
            </div>

            <div class="producto-body">
                <div class="form-panel">
                    <form id="form1" action="?c=producto&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" class="form-control" id="idProducto" name="idProducto" value="<?php echo $vte->idProducto; ?>">

                        <div class="form-group">
                            <label for="idTipoProducto">Tipo de Producto</label>
                            <select name="idTipoProducto" id="idTipoProducto" class="form-control" required>
                                <option value="">Seleccionar tipo producto</option>
                                <?php foreach ($this->model->ListarTipoProducto() as $a): ?>
                                    <option value="<?php echo $a->idTipoProducto; ?>" <?php echo $a->idTipoProducto == "" ? 'selected' : ''; ?>>
                                        <?php echo $a->nombreTipoProducto; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nombreProducto">Nombre de Producto</label>
                            <input type="text" class="form-control" name="nombreProducto" id="nombreProducto" placeholder="Nombre del Producto" value="<?php echo $vte->nombreProducto; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="codigoBarra">Código de Barra</label>
                            <input type="text" class="form-control" name="codigoBarra" id="codigoBarra" placeholder="Código de Barra" value="<?php echo $vte->codigoBarra; ?>">
                        </div>

                        <!-- CAMPO NUEVO PARA IMAGEN -->
                        <div class="form-group">
                            <label for="imagenProducto">Imagen del Producto</label>
                            <input 
                                type="file" 
                                class="form-control" 
                                name="imagenProducto" 
                                id="imagenProducto"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                            >

                            <small class="text-muted">
                                Formatos permitidos: JPG, JPEG, PNG, WEBP
                            </small>

                            <div class="preview-box">
                                <img id="previewImagen" src="" alt="Vista previa de la imagen">
                                <div id="previewTexto" class="preview-placeholder">
                                    Aquí se mostrará la vista previa de la imagen
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" name="precioProducto" id="precioProducto" value="1000" required>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" name="existenciaProducto" id="existenciaProducto" value="0" required>
                        </div>

                        <input type="hidden" name="fechaIngreso" id="fechaIngreso" value="<?php echo date("Y-m-d"); ?>">

                        <div class="acciones">
                            <button type="submit" id="Guardar" class="btn btn-success btn-guardar">
                                <i class="fas fa-save"></i> Guardar Producto
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

        $('#imagenProducto').on('change', function(e){
            const archivo = e.target.files[0];

            if (!archivo) {
                $('#previewImagen').hide().attr('src', '');
                $('#previewTexto').show();
                return;
            }

            const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            if ($.inArray(archivo.type, tiposPermitidos) === -1) {
                alert('Formato no permitido. Solo JPG, JPEG, PNG o WEBP.');
                $(this).val('');
                $('#previewImagen').hide().attr('src', '');
                $('#previewTexto').show();
                return;
            }

            const reader = new FileReader();

            reader.onload = function(event) {
                $('#previewImagen').attr('src', event.target.result).show();
                $('#previewTexto').hide();
            };

            reader.readAsDataURL(archivo);
        });

    });
</script>

<script>
    function numeros(e){
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = "0123456789";
        especiales = [];

        tecla_especial = false;
        for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            } 
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial)
            return false;
    }
</script>