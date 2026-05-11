<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<div class="container-fluid">
  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  

  <h1 align="center" class="titulos">Credencial</h1>


<div class="row">
<div class="col-md-2"></div>
  <div class="col-md-2"> <img src="persona/imagenes/<?php echo $vte->fotoPersona;?>" alt="" class="img-thumbnail" width = "200px" height="200px"></div>
  <div class="col-md-3">     

       <h4 align="left"><label>Rut: </label> <?php echo $vte->rutPersona;?></h4>
       <h4 align="left"><label>Nombres: </label> <?php echo $vte->nombresPersona;?></h4>
       <h4 align="left"><label>Apellidos: </label> <?php echo $vte->apellidoPersona1." ".$vte->apellidoPersona2;?></h4>
       <h4 align="left"><label>Genero: </label> <?php echo $vte->genero;?></h4>    
       <h4 align="left"><label>Fecha Ingreso: </label> <?php echo $vte->fechaCreado;?></h4>

  </div>
 <div class="col-md-2"> <img src="persona/CodigosQR/qr_<?php echo $vte->qrPersona;?>.png" alt="" class="img-thumbnail" align="left">  
 </div>

<div class="col-md-2"></div>

</div>

<br>
  <div class="row">
    <div class="col-md-12" align="center">                     
      <input type="button" id="volver" class="btn btn-danger" name="volver" value="volver" onClick="location.href='?c=persona&a=menuPersona'">             
    </div>
  </div>                          
</div>
</div>
       





