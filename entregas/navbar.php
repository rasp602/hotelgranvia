<?php
include_once "encabezado.php";
include_once "funciones.php";
session_start();
if(empty($_SESSION['usuario'])) header("location: login.php");
?>

<style>
:root{
    --jumbo-1:#2e7d32;
    --jumbo-2:#43a047;
    --jumbo-3:#66bb6a;
    --jumbo-light:#e8f5e9;
}

/* NAVBAR BASE */
.navbar-jumbo{
    background: linear-gradient(135deg, var(--jumbo-1), var(--jumbo-2));
    border-radius: 0 0 18px 18px;
    box-shadow: 0 12px 30px rgba(46,125,50,.25);
    padding: 10px 15px;
}

/* LOGO */
.navbar-brand img{
    border-radius: 8px;
}

/* LINKS */
.nav-link{
    color: #ffffff !important;
    font-weight: 600;
    padding: 10px 14px !important;
    border-radius: 10px;
    transition: all .2s ease;
}

.nav-link:hover{
    background: rgba(255,255,255,0.15);
    transform: translateY(-1px);
}

/* ITEM ACTIVO */
.nav-link.active{
    background: rgba(255,255,255,0.2);
}

/* SALUDO */
.usuario-box{
    background: rgba(255,255,255,0.15);
    padding: 8px 14px;
    border-radius: 999px;
    color: #fff;
    font-weight: 600;
    margin-right: 10px;
}

/* FECHA */
.fecha-box{
    background: rgba(255,255,255,0.1);
    padding: 8px 14px;
    border-radius: 999px;
    color: #fff;
    font-weight: 700;
    margin-right: 10px;
}

/* BOTON SALIR */
.btn-salir{
    background: #ffca28;
    color: #000;
    border: none;
    border-radius: 999px;
    padding: 8px 16px;
    font-weight: 700;
    transition: all .2s ease;
}

.btn-salir:hover{
    background: #ffc107;
    transform: translateY(-1px);
}

/* RESPONSIVE */
@media (max-width: 768px){
    .usuario-box, .fecha-box{
        margin-bottom: 8px;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-jumbo mb-3">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand" href="#">
      <img src="img/granvia.png" width="55" height="40">
    </a>

    <!-- BOTON MOVIL -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="navbar">

        <!-- IZQUIERDA -->
        <ul class="navbar-nav me-auto">

            <li class="nav-item">
                <a class="nav-link active" href="vender.php">
                    <i class="fa fa-truck"></i> Orden de entrega
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="venderPreparado.php">
                    <i class="fa fa-box"></i> Entrega preparado
                </a>
            </li>

        </ul>

        <!-- DERECHA -->
        <div class="d-flex align-items-center flex-wrap">

            <div class="usuario-box">
                <i class="fa fa-user"></i>
                <?= $_SESSION['usuario'] ?>
            </div>

            <div class="fecha-box">
                <i class="fa fa-clock"></i>
                <?php 
                    date_default_timezone_set("America/Santiago");
                    echo date("d-m-Y H:i");
                ?>
            </div>

            <a href="cerrar_sesion.php" class="btn btn-salir">
                <i class="fa fa-sign-out-alt"></i> Salir
            </a>

        </div>

    </div>
  </div>
</nav>