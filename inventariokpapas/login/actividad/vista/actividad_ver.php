<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<div class="container-fluid fondoInscripcion">
  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>         
<div class="row">
     <h4 align="center" class="titulos">Detalles de Actividad:</h4><br>
  <div class="col-md-2"> 
       <label>Linea:</label><?php echo $vte->nLinea;?><br>
       <label>Maquina:</label><?php echo $vte->nMaquina;?><br>
       <label>Fecha:</label><?php echo $vte->fechaA;?><br>
       <label for="">Actividad:</label><?php echo $vte->tipoA;?><br>
       <label>Descripción:</label><?php echo $vte->descripcion;?><br>
  </div>
  <div class="col-md-5">
      <img src="actividad/imagenes/<?php echo $vte->imagen;?>" alt="" class="img-thumbnail">   
  </div>

  <div class="col-md-5">
      <img src="actividad/imagenes/<?php echo $vte->imagen2;?>" alt="" class="img-thumbnail">   
  </div>
</div>
<br><br>
  <div class="row">
    <div class="col-md-12" align="center">                     
      <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=actividad&a=menuActividad'">             
    </div>
  </div>                          
</div>
</div>
       





