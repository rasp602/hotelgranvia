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

 <div class="container-fluid">   <h2 align="center" class="titulos">Actualizar Trabajador</h2>
        <div class="col-md-2"></div>

        <div class="col-md-4">

                      

    <form id="form1" action="?c=trabajador&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
      <input type="text" class="form-control" id="idTrabajador" name="idTrabajador" value="<?php echo $vte->idTrabajador;?>"> 

        <input type="hidden" name="estado" id="estado" value="A">
                
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
            
                    <input type="hidden" class="form-control" id="horaCreado" name="horaCreado" placeholder="horaCreado" value="<?php
                    date_default_timezone_set("America/caracas"); 
                    echo date("H:i:s");?>">
                    </div>              
                  </div>
                  <div class="row">     
                    <div class="col-md-12">                   
                     <h4 for="">Genero:</h4>
                          <select name="genero" id="genero" class="col-md-12 form-control" required="">   
                            <option <?php echo $vte->genero==='M'?"selected='selected'":""?> value="M">MASCULINO</option>
                            <option <?php echo $vte->genero==='F'?"selected='selected'":""?> value="F">FEMENINO</option>                          
                          </select>
                    </div>              
                  </div>                                 
      

                <div class="row">
            <div class="col-md-12">
              <h4>Empresa</h4>
                <select name="idHotel" id="idHotel" class="form-control  input-sm" required>    
                            <option <?php echo $vte->idHotel==='1'?"selected='selected'":""?> value="1">H1</option>
                            <option <?php echo $vte->idHotel==='2'?"selected='selected'":""?> value="2">H2</option>
                            <option <?php echo $vte->idHotel==='3'?"selected='selected'":""?> value="3">H3</option>
                            <option <?php echo $vte->idHotel==='4'?"selected='selected'":""?> value="4">H4</option>
                            <option <?php echo $vte->idHotel==='5'?"selected='selected'":""?> value="5">H5</option>
                            <option <?php echo $vte->idHotel==='5'?"selected='selected'":""?> value="6">H6</option>
                            <option <?php echo $vte->idHotel==='5'?"selected='selected'":""?> value="7">H7</option>
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
                <input type="date" class="form-control" name="fechaIngreso" id="fechaIngreso" required value="<?php echo $vte->fechaIngreso; ?>">
            </div>
          </div> 
          <div class="row">
            <div class="col-md-12">
              <h4>Labor</h4>
                <input type="text" class="form-control" name="labor" id="labor" required maxlength="20" value="<?php echo $vte->labor; ?>">
            </div>
          </div> 

          <div class="row">
            <div class="col-md-12">
              <h4>Jornada</h4>
                <select name="jornada" id="jornada" class="form-control  input-sm" required>   
                <option <?php echo $vte->jornada==='1'?"selected='selected'":""?> value="1">8:00-16:00</option>
                <option <?php echo $vte->jornada==='2'?"selected='selected'":""?>value="2">8:00-17:00</option>
                <option <?php echo $vte->jornada==='3'?"selected='selected'":""?>value="3">14:00-22:00</option>
                <option <?php echo $vte->jornada==='4'?"selected='selected'":""?>value="4">00:00-8:00</option>
                <option <?php echo $vte->jornada==='5'?"selected='selected'":""?>value="5">15:00-23:00</option>
                <option <?php echo $vte->jornada==='6'?"selected='selected'":""?>value="6">8:00-18:00</option> 
                <option <?php echo $vte->jornada==='7'?"selected='selected'":""?>value="7">8:00-22:00</option>
                <option <?php echo $vte->jornada==='8'?"selected='selected'":""?>value="8">22:00-08:00 7x7</option> 
                <option <?php echo $vte->jornada==='9'?"selected='selected'":""?>value="9">06:00-18:00 7x7</option>
                <option <?php echo $vte->jornada==='10'?"selected='selected'":""?>value="10">7x7</option>
                <option <?php echo $vte->jornada==='11'?"selected='selected'":""?>value="11">2:00-10:00 7x7</option>
                <option <?php echo $vte->jornada==='12'?"selected='selected'":""?>value="12">8:00-20:00 7x7</option>
                <option <?php echo $vte->jornada==='13'?"selected='selected'":""?>value="13">10:00-22:00 7x7</option>
                <option <?php echo $vte->jornada==='14'?"selected='selected'":""?>value="14">16:00-1:00 5x2</option>                
                <option <?php echo $vte->jornada==='15'?"selected='selected'":""?>value="15">17:00-2:00 5x2</option>
                <option <?php echo $vte->jornada==='16'?"selected='selected'":""?>value="16">15:00-1:00</option> 
                <option <?php echo $vte->jornada==='17'?"selected='selected'":""?>value="17">10:00-2:00 (L)</option>                  
           
                </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h4>Dias de Trabajo</h4>
                <input type="text" class="form-control" name="diasTrabajo" id="diasTrabajo" required onkeypress="return numeros(event)" maxlength="2" value="<?php echo $vte->diasTrabajo; ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h4>Sueldo</h4>
                <input type="text" class="form-control" name="sueldo" id="sueldo" maxlength="6" value="<?php echo $vte->sueldo; ?>">
            </div>
          </div>

                             <div class="row">     
                    <div class="col-md-12">                   
                     <h4 for="">Estatus:</h4>
                          <select class="form-control" name="estado" id="estado">
                          
                            <option <?php echo $vte->estado==='A'?"selected='selected'":""?> value="A">Activo</option>
                            <option <?php echo $vte->estado==='I'?"selected='selected'":""?> value="I">Inactivo</option>                            
                          </select>
                    </div>              
                  </div> 


      </div>


        <div class="row">     
                    <div class="col-md-12"> 
                 
                    <input type="hidden" class="form-control" id="qrTrabajador" name="qrTrabajador" placeholder="qrTrabajador" value="<?php echo $vte->qrTrabajador;?>">
                    </div>              
                  </div>



      <div class="col-md-2"></div> 
</div>


                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Actualizar" class="btn btn-success" value='Actualizar'/>
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


