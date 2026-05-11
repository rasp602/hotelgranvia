<script src="producto/js/ajaxProducto.js"></script>

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
    .card-productos {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        padding: 20px;
        margin-top: 20px;
    }

    .header-productos {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: white;
        padding: 22px;
        border-radius: 16px 16px 0 0;
        text-align: center;
        margin: -20px -20px 20px -20px;
    }

    .header-productos h3 {
        margin: 0;
        font-weight: bold;
        font-size: 22px;
    }

    .header-productos small {
        display: block;
        margin-top: 5px;
        font-size: 13px;
        opacity: 0.9;
    }

    .filtro-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .filtro-box h5 {
        font-weight: bold;
        color: #0d6efd;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .btn-accion {
        border-radius: 10px;
        font-weight: bold;
        width: 100%;
        margin-top: 22px;
    }

    .btn-nuevo {
        background: #0d6efd;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px;
        text-decoration: none;
    }

    .btn-nuevo:hover {
        background: #0b5ed7;
        color: white;
    }

    .icon-box {
        text-align: center;
    }

    .icon-box img {
        width: 40px;
        margin-bottom: 5px;
    }

    .outer_div {
        margin-top: 20px;
    }
</style>

<div class="row">


    <div class="col-md-12">

        <div class="card-productos">

            <!-- HEADER -->
            <div class="header-productos">
                <h3><i class="bi bi-box-seam"></i> Productos</h3>
                <small>Gestión de inventario</small>
            </div>

            <?php if (isset($_GET["success"])): ?>
                <div class="alert alert-success text-center">
                    Producto registrado correctamente.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET["delete"])): ?>
                <div class="alert alert-danger text-center">
                    Producto eliminado correctamente.
                </div>
            <?php endif; ?>

            <!-- FILTROS -->
            <div class="filtro-box">
                <div class="row">

                    <!-- Tipo -->
                    <div class="col-md-3">
                        <h5>Tipo Producto</h5>
                        <select id="idTipoProducto" class="form-control">
                            <option value="">Todos</option>
                            <?php foreach ($this->model->ListarTipoProducto() as $a): ?>
                                <option value="<?php echo $a->idTipoProducto; ?>">
                                    <?php echo $a->nombreTipoProducto; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Nombre -->
                    <div class="col-md-3">
                        <h5>Nombre</h5>
                        <input type="text" class="form-control" id="nombreProducto" placeholder="Buscar producto">
                    </div>

                    <!-- Código -->
                    <div class="col-md-2">
                        <h5>Código</h5>
                        <input type="text" class="form-control" id="codigoBarra" placeholder="Código">
                    </div>

                    <!-- Mes -->
                    <div class="col-md-2">
                        <h5>Mes</h5>
                        <select id="mes" class="form-control">
                            <?php
                            $meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
                            $mesActual = date('n');

                            foreach ($meses as $i => $mesNombre) {
                                $num = $i + 1;
                                $selected = ($num == $mesActual) ? 'selected' : '';
                                echo "<option $selected>$mesNombre</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- BOTONES -->
              <div class="col-md-1">
                    <a href="?c=producto&a=Crud1" class="btn-nuevo">
                        <i class="bi bi-plus-square"></i>
                        Nuevo Producto
                    </a>
                </div>
                            <div class="row mb-3">

                <div class="col-md-4 icon-box">
                    <a href="javascript:reportePDFmes();">
                        <img src="img/pdf.png">
                        <div>PDF</div>
                    </a>
                </div>

                <div class="col-md-4 icon-box">
                    <a href="javascript:reporteExcel();">
                        <img src="img/excel.png">
                        <div>Excel</div>
                    </a>
                </div>

      
            </div>


                </div>
            </div>

            <!-- ICONOS -->


            <!-- RESULTADO -->
            <div class="outer_div"></div>

        </div>

    </div>

    <div class="col-md-2"></div>
</div>

<div id="result"></div>
</div>