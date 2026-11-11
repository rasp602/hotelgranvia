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

    

<div class="container-fluid fondoInscripcion">
  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>   
    



<h2>Agregar codigo Qr</h2>

            <div class="col-md-6">
                  <form id="form1" action="?c=persona&a=GuardarQR" name="form1" method="post" enctype="multipart/form-data">
              <input type="hidden" class="form-control" id="idPersona" name="idPersona" value="<?php echo $vte->idPersona;?>"> 
                
                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Rut:</h4>
                    <input type="text" class="form-control" id="rutPersona" name="rutPersona" value="<?php echo $vte->rutPersona;?>" readonly=»readonly»> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Nombres:</h4>
                    <input type="text" class="form-control" id="nombresPersona" name="nombresPersona" value="<?php echo $vte->nombresPersona;?>" readonly=»readonly»> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Apellido Padre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona1" name="apellidoPersona1" value="<?php echo $vte->apellidoPersona1;?>" readonly=»readonly»> 
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Apellido Madre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona2" name="apellidoPersona2" value="<?php echo $vte->apellidoPersona2;?>"readonly=»readonly»> 
                    </div>              
                  </div>

       

          
                  <div class="row">
                    <div class="col-md-12">
                        <h4 for="">Codigo Qr:</h4> 
                      <input type="text" class="form-control" id="qrPersona" name="qrPersona" placeholder="Codigo Qr" required onkeyup="showHint(this.value)" value="<?php echo $vte->qrPersona; ?>" autofocus onkeypress="return numeros(event)" maxlength="8">
                    
                    </div>         
                  </div>

                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Actualizar" class="btn btn-success" value='Actualizar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=persona&a=menuPersona'">             
                    </div>
                 </div>                          
              
              </form>

              </div>

</div>
       

 <script>
    function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = [];
 
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}
    </script>








