<?php
  error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
function subirimagen()
{
  self.name = 'opener';
  remote = open('persona/vista/gestionimagen.php', 'remote', 'width=600,height=200,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=yes, status=yes');
  remote.focus();
  }

</script>

    <script src="trabajador/js/ajaxTrabajador.js"></script>

<div class="container-fluid fondoInscripcion">
         <?php 
            $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                                echo "hola usuario";
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                                echo "hola Fiscalizador";
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
               }               
         ?> 
    
<h2 align="center">Detalles del Trabajador</h2>

<div class="col-md-4" align="center">

<h2>Codigo Qr</h2>
<img class="img-thumbnail" src="trabajador/codigosQR/qr_<?php echo $vte->qrTrabajador;?>.png" />

</div>


            <div class="col-md-6">
                  <form id="form1" action="?c=Trabajador&a=GuardarQR" name="form1" method="post" enctype="multipart/form-data">
              <input type="hidden" class="form-control" id="idTrabajador" name="idTrabajador" value="<?php echo $vte->idTrabajador;?>"> 
                
                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Rut:</h4>
                    <input type="text" class="form-control" id="rutTrabajador" name="rutTrabajador" value="<?php echo $vte->rutTrabajador;?>" readonly=»readonly»> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Nombres:</h4>
                    <input type="text" class="form-control" id="nombreTrabajador" name="nombreTrabajador" value="<?php echo $vte->nombreTrabajador;?>" readonly=»readonly»> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Apellido Padre:</h4>
                    <input type="text" class="form-control" id="apellidoTrabajador1" name="apellidoTrabajador1" value="<?php echo $vte->apellidoTrabajador1;?>" readonly=»readonly»> 
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Apellido Madre:</h4>
                    <input type="text" class="form-control" id="apellidoTrabajador2" name="apellidoTrabajador2" value="<?php echo $vte->apellidoTrabajador2;?>"readonly=»readonly»> 
                    </div>              
                  </div>

                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>                      
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=trabajador&a=menuTrabajador'">             
                    </div>
                 </div>                          
              
              </form>

              </div>
                        <div class="col-md-1" align="center">
      
    <a href="javascript:reportePDF2();"  data-toggle="tooltip" title="descargar actividad"><img src="img/pdf.png" width="50px" height="50px">Imprimir</a>
     
      </div>

</div>
       
</div>


</div>






