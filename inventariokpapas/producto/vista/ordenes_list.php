<script src="producto/js/ajaxOrdenes.js"></script>

<div class="container-fluid">
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
}
?>

<style>
    .card-ordenes {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        padding: 20px;
        margin-top: 20px;
    }

    .header-ordenes {
        background: linear-gradient(135deg, #33a532, #238b2d); /* VERDE JUMBO */
        color: white;
        padding: 22px;
        border-radius: 16px 16px 0 0;
        text-align: center;
        margin: -20px -20px 20px -20px;
    }

    .header-ordenes h3 {
        margin: 0;
        font-weight: bold;
        font-size: 22px;
    }

    .header-ordenes small {
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
        color: #2f9e44;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .btn-buscar {
        margin-top: 24px;
        width: 100%;
        border-radius: 10px;
    }

    .btn-nueva-orden {
        margin-top: 24px;
        width: 100%;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: bold;
    }

    .btn-success {
        background: #2f9e44;
        border: none;
    }

    .btn-success:hover {
        background: #24883a;
    }

    .outer_div {
        margin-top: 20px;
    }
</style>

<div class="row">
    <div class="col-md-1"></div>

    <div class="col-md-10">
        <div class="card-ordenes">

            <!-- HEADER -->
            <div class="header-ordenes">
                <h3><i class="bi bi-truck"></i> Órdenes de Entrega</h3>
                <small>Gestión y seguimiento de entregas</small>
            </div>

            <?php if (isset($_GET["success"])): ?>
                <div class="alert alert-success text-center">
                    Orden registrada correctamente.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET["delete"])): ?>
                <div class="alert alert-danger text-center">
                    Orden eliminada correctamente.
                </div>
            <?php endif; ?>

            <!-- FILTROS -->
            <div class="filtro-box">
                <div class="row">

                    <!-- HOTEL -->
                    <div class="col-md-3">
                        <h5><i class="bi bi-building"></i> Hotel</h5>
                        <select name="idHotel" id="idHotel" class="form-control">
                            <option value="">Todos</option>
                            <?php foreach ($this->model->ListarHotel() as $a): ?>
                                <option value="<?php echo $a->idHotel; ?>">
                                    <?php echo $a->nombreHotel; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                   <div class="col-md-3">
                        <h5><i class="bi bi-building"></i> Estado</h5>
                        <select name="estado" id="estado" class="form-control">
                            <option value="">Todos</option>
                            <option value="">Pediente</option>
                            <option value="">Entregado</option>
                          
                        </select>
                    </div>


                    <!-- DESDE -->
                    <div class="col-md-2">
                        <h5><i class="bi bi-calendar"></i> Desde</h5>
                        <input type="date" id="desde" class="form-control">
                    </div>

                    <!-- HASTA -->
                    <div class="col-md-2">
                        <h5><i class="bi bi-calendar"></i> Hasta</h5>
                        <input type="date" id="hasta" class="form-control">
                    </div>

                    <!-- BUSCAR -->
                    <div class="col-md-2">
                      
                     
                    </div>

 

                </div>
            </div>

            <!-- RESULTADOS -->
            <div class="outer_div"></div>

        </div>
    </div>

    <div class="col-md-2"></div>
</div>

<div id="result"></div>
</div>