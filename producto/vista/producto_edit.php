<?php
error_reporting(E_ERROR | E_PARSE);

require_once 'bd/conexionLocal.php';
$sql_producto = "SELECT * FROM tipoProducto";
$result_producto = $conn->query($sql_producto);
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
        margin: 0 auto;
        display: block;
    }

    .preview-placeholder {
        color: #667085;
        font-size: 14px;
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
                <h2><i class="fas fa-edit"></i> Editar Producto</h2>
                <p>Actualiza los datos del producto y cambia la imagen si es necesario.</p>
            </div>

            <div class="producto-body">
                <div class="form-panel">
                    <form id="form1" action="?c=producto&a=Guardar" name="form1" method="post" enctype="multipart/form-data">

                        <input type="hidden" class="form-control" id="idProducto" name="idProducto" value="<?php echo $vte->idProducto; ?>">
                        <input type="hidden" name="imagenActual" value="<?php echo $vte->imagenProducto; ?>">

                        <div class="form-group">
                            <label for="idTipoProducto">Tipo de Producto</label>
                            <select name="idTipoProducto" id="idTipoProducto" class="form-control" required>
                                <option value="">Seleccionar tipo producto</option>
                                <?php
                                while ($row_producto = $result_producto->fetch_assoc()) {
                                    $selected = ($row_producto['idTipoProducto'] == $vte->idTipoProducto) ? 'selected' : '';
                                    echo "<option value='" . $row_producto['idTipoProducto'] . "' $selected>" . $row_producto['nombreTipoProducto'] . "</option>";
                                }
                                ?>
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

                        <div class="form-group">
                            <label for="precioProducto">Precio del Producto</label>
                            <input type="text" class="form-control" name="precioProducto" id="precioProducto" placeholder="Precio del Producto" value="<?php echo $vte->precioProducto; ?>" required onkeypress="return numeros(event);">
                        </div>

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
                                <?php
                                    $rutaImagen = !empty($vte->imagenProducto)
                                        ? 'img/productos/' . $vte->imagenProducto
                                        : 'img/no-image.png';
                                ?>
                                <div class="img-actual-label">Imagen actual</div>
                                <img 
                                    id="previewImagen" 
                                    src="<?php echo $rutaImagen; ?>" 
                                    alt="Vista previa de la imagen"
                                    onerror="this.onerror=null;this.src='img/no-image.png';"
                                >
                                <div id="previewTexto" class="preview-placeholder" style="display:none;">
                                    Aquí se mostrará la vista previa de la imagen
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" name="existenciaProducto" id="existenciaProducto" value="<?php echo $vte->existenciaProducto; ?>" required>
                        </div>

                        <input type="hidden" name="fechaIngreso" id="fechaIngreso" value="<?php echo date("Y-m-d"); ?>">

                        <div class="acciones">
                            <button type="submit" id="Guardar" class="btn btn-success btn-guardar">
                                <i class="fas fa-save"></i> Actualizar Producto
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
                return;
            }

            const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            if ($.inArray(archivo.type, tiposPermitidos) === -1) {
                alert('Formato no permitido. Solo JPG, JPEG, PNG o WEBP.');
                $(this).val('');
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

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
</script>

</div>