<?php
include_once "funciones.php";
include_once "navbar.php";
include_once "encabezado.php";

?>
<div class="container">
<h1>Ingresar numero de venta</h1>
    <form action="impresion.php" method="post" class="row">
        <div class="col-8">
            <input class="form-control form-control-lg" name="codigo" autofocus id="codigo" type="text" placeholder="Código de barras del producto" aria-label="codigoBarras">
        </div>
        <div class="col-4">
            <input type="submit" value="imprimir" name="imprimir" class="btn btn-success mt-2">
             
        </div>
        </form>
</div>