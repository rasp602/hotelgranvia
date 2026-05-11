<?php
include_once "encabezado.php";

include_once "funciones.php";
session_start();
if(empty($_SESSION['usuario'])) header("location: login.php");
?>
<style>
.date-time {
    color: white;
    margin-right: 1em; /* Ajusta el valor según la cantidad de espacio que desees */
}
</style>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2 shadow   rounded">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="img/granvia.png" alt="" width="60" height="40" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
            <a class="nav-link active" href="vender.php">
            <i class="fa fa-file-alt"></i>   
           Orden de entrega
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="venderPreparado.php">
            <i class="fa fa-file-alt"></i>   
           Orden de entrega Preparado
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="imprimir.php">
            <i class="fa fa-file-alt"></i> 
            Re-Imprimir
            </a>
        </li>
        </ul>

        <ul class="navbar-nav">
          <h6 class="date-time">  
        Hola, <?= $_SESSION['usuario']?></h6>
        </ul>
        <ul class="navbar-nav">
          <h3 class="date-time">
              <?php 
              date_default_timezone_set("America/Santiago");
              echo date("d-m-Y H:i");
              ?>
          </h3>
        </ul>
      
        <ul class="navbar-nav">
  
            &nbsp
            <li class="nav-item">
                <a href="cerrar_sesion.php" class="btn btn-warning">Salir</a>
            </li>
        </ul>
    </div>
  </div>
</nav>
