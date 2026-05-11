<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
/*  date_default_timezone_set("America/caracas");
  $hora=date("H:i:s");
  echo $hora;*/
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

     

  <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">El trabajador que intenta ingresar ya se encuentra registrado...</div>';?> 

 <div class="container-fluid">   <h2 align="center" class="titulos">NuevoTrabajador</h2>
        <div class="col-md-2"></div>

        <div class="col-md-4">

                      

    <form id="form1" action="?c=trabajador&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
      <input type="hidden" class="form-control" id="idTrabajador" name="idTrabajador" value="<?php echo $vte->idTrabajador;?>"> 

        <input type="hidden" name="estado" id="estado" value="A">
        <input type="hidden" name="condicion" id="condicion" value="1">
                
                  <div class="row">     
                    <div class="col-md-12">
                    <h4>R.u.t :</h4>
                    <input type="text" class="form-control" id="rutTrabajador" name="rutTrabajador" value="<?php echo $vte->rutTrabajador;?>" maxlength="10" required> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Nombre:</h4>
                    <input type="text" class="form-control" id="nombreTrabajador" name="nombreTrabajador" value="<?php echo $vte->nombreTrabajador;?>" maxlength="10" required onkeypress="return sololetras(event)" style="text-transform:uppercase;"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Apellido Padre:</h4>
                    <input type="text" class="form-control" id="apellidoTrabajador1" name="apellidoTrabajador1" value="<?php echo $vte->apellidoTrabajador1;?>" maxlength="10" required onkeypress="return sololetras(event)" style="text-transform:uppercase;"> 
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Apellido Madre:</h4>
                    <input type="text" class="form-control" id="apellidoTrabajador2" name="apellidoTrabajador2" value="<?php echo $vte->apellidoTrabajador2;?>" maxlength="10" required onkeypress="return sololetras(event)" style="text-transform:uppercase;"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12"> 
                 
                    <input type="hidden" class="form-control" id="fechaCreado" name="fechaCreado" placeholder="fechaCreado" value="<?php echo date("Y-m-d");?>">
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12"> 
                 
                    <input type="hidden" class="form-control" id="qrTrabajador" name="qrTrabajador" placeholder="qrTrabajador" value="">
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12"> 
            
                    <input type="hidden" class="form-control" id="horaCreado" name="horaCreado" placeholder="horaCreado" value="<?php
                    date_default_timezone_set("America/caracas"); 
                    echo date("H:i:s");?>">
                    </div>              
                  </div>
                  <div class="row">     
                    <div class="col-md-12">                   
                     <h4 for="">Genero:</h4>
                          <select name="genero" id="genero" class="col-md-12 form-control" required="">   
                            <option value="M">MASCULINO</option>
                              <option value="F">FEMENINO</option>                            
                          </select>
                    </div>              
                  </div>                                 
      

                <div class="row">
            <div class="col-md-12">
              <h4>Empresa</h4>
                <select name="idHotel" id="idHotel" class="form-control  input-sm" required>    
                   <?php  foreach ($this->model->ListarHotel()as $a): ?>
                             <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                    <?php endforeach; ?> 
                </select>
            </div>
          </div> 

                  <div class="row">
                    <div class="col-md-10">              
                      <input type="hidden" class="form-control" id="imagen" name="imagen" placeholder="Imagen" value="<?php echo $vte->imagen; ?>"  >
                    
                    </div>

            </div>
        
</div>
      <div class="col-md-4">

          <div class="row">
            <div class="col-md-12">
              <h4>Fecha de Ingreso</h4>
                <input type="date" class="form-control" name="fechaIngreso" id="fechaIngreso" required>
            </div>
          </div> 
          <div class="row">
            <div class="col-md-12">
              <h4>Labor</h4>
                <input type="text" class="form-control" name="labor" id="labor" required maxlength="20">
            </div>
          </div> 

          <div class="row">
            <div class="col-md-12">
              <h4>Jornada</h4>
                <select name="jornada" id="jornada" class="form-control  input-sm" required>   
                 
                             <option value="1">8:00-16:00</option>
                             <option value="2">8:00-17:00</option>
                             <option value="3">14:00-22:00</option>
                             <option value="4">00:00-8:00</option>
                             <option value="5">15:00-23:00</option>
                             <option value="6">8:00-18:00</option>
                             <option value="7">8:00-22:00 7x7</option>                         
                             <option value="8">22:00-08:00 7x7</option>
                             <option value="9">06:00-18:00 7x7</option> 
                             <option value="10">7x7</option>     
                             <option value="11">2:00-10:00 7x7</option>  
                             <option value="12">08:00-20:00 7x7</option> 
                             <option value="13">10:00-22:00 7x7</option> 
                             <option value="14">16:00-1:00 5X2</option>
                             <option value="15">17:00-2:00 5X2</option> 
                             <option value="16">15:00-01:00</option> 
                             <option value="17">10:00-02:00 (L)</option> 
                             

                </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h4>Dias de Trabajo</h4>
                <input type="text" class="form-control" name="diasTrabajo" id="diasTrabajo" required onkeypress="return numeros(event)" maxlength="2">
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h4>Sueldo</h4>
                <input type="text" class="form-control" name="sueldo" id="sueldo" maxlength="6">
            </div>
          </div>


      </div>




      <div class="col-md-2"></div> 
</div>


                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Registrar" class="btn btn-success" value='Registrar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=trabajador&a=menuTrabajador'">             
                    </div>
                 </div>                          
          
              </form>



 <!-- div del menu -->
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


      <script>
       
       function sololetras(e){
           key= e.keyCode || e.which;
           teclado= String .fromCharCode(key).toLowerCase();
           letras="abcdefghijklmnñopqrstuvwxyz"
           especiales="13-9-8-37-38-46-164";
           
           teclado_especial=false;
           
           for(var i in especiales){
               
               if(key==especiales[i]){
                   teclado_especial=true;break;
                   
                   }
               }
           if(letras.indexOf(teclado)==-1 && !teclado_especial){
               
               return false;
               
               }
           
           }
       
       
       </script> 