<?php
include_once "funciones.php";
include_once "encabezado.php";
session_start(); 
?>

<?php


           
echo "
<script type='text/javascript'>
    window.location.href='cancelar_venta.php'
    alert('Venta realizada con éxito N° .$ultimoId')
</script>";
  

?>