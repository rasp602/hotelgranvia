<script src="producto/js/ajaxPedidos.js"></script>

<?php
include 'bd/conexionLocal.php';

// Traer usuarios + departamento
$usuarios = mysqli_query($con, "
    SELECT u.idUsuario, u.nombre, u.apellido, d.nombreDepartamento
    FROM tblusuario u
    LEFT JOIN departamento d ON u.idDepartamento = d.idDepartamento
");
?>

<style>
    .card-pedidos {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        padding: 20px;
        margin-top: 20px;
    }

    .header-pedidos {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: white;
        padding: 20px;
        border-radius: 15px 15px 0 0;
        text-align: center;
        margin-bottom: 20px;
    }

    .header-pedidos h3 {
        margin: 0;
        font-weight: bold;
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
        margin-bottom: 10px;
    }

    .btn-buscar {
        margin-top: 25px;
        width: 100%;
    }

    .outer_div {
        margin-top: 20px;
    }
</style>

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

<div class="row">
    <div class="col-md-1"></div>

    <div class="col-md-10">

        <div class="card-pedidos">

            <div class="header-pedidos">
                <h3><i class="bi bi-clipboard-data"></i> Pedidos de Cocina</h3>
            </div>

            <?php if (isset($_GET["success"])): ?>
                <div class="alert alert-success text-center">
                    Pedido registrado correctamente.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET["delete"])): ?>
                <div class="alert alert-danger text-center">
                    Pedido eliminado correctamente.
                </div>
            <?php endif; ?>

            <!-- FILTROS -->
            <div class="filtro-box">
                <div class="row">

                    <!-- Usuario -->
                    <div class="col-md-3">
                        <h5><i class="bi bi-person"></i> Usuario</h5>
                        <select id="idUsuario" class="form-control">
                            <option value="">Todos</option>
                            <?php while($u = mysqli_fetch_assoc($usuarios)) { ?>
                                <option value="<?php echo $u["idUsuario"]; ?>">
                                    <?php echo utf8_encode($u["nombre"] . " " . $u["apellido"] . " - " . $u["nombreDepartamento"]); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Tipo Pedido -->
                    <div class="col-md-3">
                        <h5><i class="bi bi-exclamation-circle"></i> Tipo</h5>
                        <select id="tipoPedido" class="form-control">
                            <option value="">Todos</option>
                            <option value="1">Urgente</option>
                        </select>
                    </div>

                    <!-- Desde -->
                    <div class="col-md-2">
                        <h5><i class="bi bi-calendar"></i> Desde</h5>
                        <input type="date" id="desde" class="form-control">
                    </div>

                    <!-- Hasta -->
                    <div class="col-md-2">
                        <h5><i class="bi bi-calendar"></i> Hasta</h5>
                        <input type="date" id="hasta" class="form-control">
                    </div>

                    <!-- Botón -->
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-buscar" onclick="load(1)">
                            <i class="bi bi-search"></i> Buscar
                        </button>
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