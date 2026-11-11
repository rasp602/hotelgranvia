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


<div class="container-fluid">
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
  <?php $cliente=$usuario->id_user;?>       

  <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">La persona que intenta ingresar ya se encuentra registrada...</div>';?> 

  <div class="row">
        <div class="col-md-4" align="center"><svg xmlns="http://www.w3.org/2000/svg" width="200" height="300" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
</svg>
<?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Persona registrada correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Persona eliminada correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Persona actulizada correctamente..</div>'; ?></div>
        <div class="col-md-4">

                        <h2 align="center" class="titulos">Nueva Persona</h2>

    <form id="form1" action="?c=persona&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
      <input type="hidden" class="form-control" id="idPersona" name="idPersona" value="<?php echo $vte->idPersona;?>"> 
                
                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Rut:</h4>
                    <input type="text" class="form-control" id="rutPersona" name="rutPersona" value="<?php echo $vte->rutPersona;?>" oninput="" maxlength="10"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Nombres:</h4>
                    <input type="text" class="form-control" id="nombresPersona" name="nombresPersona" value="<?php echo $vte->nombresPersona;?>" onkeypress="" style="text-transform:uppercase;"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Apellido Padre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona1" name="apellidoPersona1" value="<?php echo $vte->apellidoPersona1;?>" onkeypress="return sololetras(event)" style="text-transform:uppercase;"> 
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Apellido Madre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona2" name="apellidoPersona2" value="<?php echo $vte->apellidoPersona2;?>" onkeypress="return sololetras(event)" style="text-transform:uppercase;"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12"> 
                 
                    <input type="hidden" class="form-control" id="fechaCreado" name="fechaCreado" placeholder="fechaCreado" value="<?php echo date("Y-m-d");?>">
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">                  
                    <input type="hidden" class="form-control" id="qrPersona" name="qrPersona" placeholder="qrPersona" value="" maxlength="8">
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">                  
                    <input type="hidden" class="form-control" id="card" name="card" placeholder="card" value="" maxlength="8">
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
            <select name="idEmpresa" id="idEmpresa" class="form-control  input-sm">

               
              <?php  foreach ($this->model->ListarEmpresas()as $a): ?>
                 <option  <?php echo $a->idEmpresa == "" ? 'selected' : ''; ?> value="<?php echo "$a->idEmpresa" ;?>"><?php echo $a->nombreEmpresa;?></option>
                                  <?php endforeach; ?>  
            </select>
          </div>
         </div>                      
                       
                
                  <div class="row">
                    <div class="col-md-12">
              
                      <input type="hidden" class="form-control" id="imagen" name="imagen" placeholder="Imagen" value="<?php echo $vte->imagen; ?>"  >
                    
                    </div>

                        <!--   
                <div class="col-md-2" align="right">
                      <h4 name="imagen" id="imagen"></h4>
                      <input name="Subir Imagen" type="button" class="btn btn-info" id="Subir Imagen" onclick="javascript:subirimagen();" value="Subir Imagen" />
                    </div>
                  </div>                                    
          
              -->

                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Registrar" class="btn btn-success" value='Registrar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">             
                    </div>
                 </div>                          
          
              </form>



</div>
       


</div>
       
</div>

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
           especiales="13-9-8-37-38-46";
           
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

 <script>
       
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
       
       </script> 

<script type="text/javascript">
// Campos Nombres
$(document).ready(function () {
        $("#rutPersona").keyup(function () {
            var value = $(this).val();
            $("#qrPersona").val(value);
             $("#card").val(value);
        });
});

</script>

