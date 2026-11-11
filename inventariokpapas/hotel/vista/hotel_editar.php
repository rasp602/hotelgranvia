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


  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>   
  <?php $cliente=$usuario->id_user;?>       

  <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">La empresa que intenta ingresar ya se encuentra registrada...</div>';?> 

<div class="container-fluid">

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">

                <h2 align="center" class="titulos">Modificar Hotel</h2>

                <form id="form1" action="?c=hotel&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                 <input type="hidden" class="form-control" id="idHotel" name="idHotel" value="<?php echo $vte->idHotel;?>"> 

                     <div class="row">     
                        <div class="col-md-12">
                        <h4>Rut Hotel</h4>
                        <input type="text" class="form-control" id="rutHotel" name="rutHotel" value="<?php echo $vte->rutHotel;?>"oninput="checkRut(this)" maxlength="10" onkeypress="return numeros(event)">
                        </div>              
                      </div>
                    
                      <div class="row">     
                        <div class="col-md-12">
                        <h4>Nombre Hotel</h4>
                        <input type="text" class="form-control" id="nombreHotel" name="nombreHotel" value="<?php echo $vte->nombreHotel;?>" onkeypress="">
                        </div>              
                      </div>

                      <div class="row">     
                        <div class="col-md-12">   
                        <h4>Capacidad:</h4>
                        <input type="text" class="form-control" id="capacidadHotel" name="capacidadHotel" value="<?php echo $vte->capacidadHotel;?>"> 
                        </div>              
                      </div>


                      <div class="row">     
                        <div class="col-md-12">   
                        <h4>Dirección:</h4>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $vte->capacidadHotel;?>"> 
                        </div>              
                      </div>                  


                     <div class="row">
                        <div class="col-md-12" align="center">
                              <br><br>
                              <input type="submit"  id="Registrar" class="btn btn-success" value='Actualizar'/>
                              <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">             
                        </div>
                     </div>                          
              
                </form>


            </div>
            <div class="col-md-2"></div>

       </div>
</div>

<br>
</div>




 <script>
    function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [9,13,8,37,39,46,38,46,164];
 
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