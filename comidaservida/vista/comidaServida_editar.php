<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.	
?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>     

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
  
 

 
 
<script>
  toastr.info('Bienvenido')
</script>
  



    <div class="row"> 
        <div class="col-md-12" align="center">
          <h2>Registrar Comida Servida</h2>
        </div>
    </div>

 <div class="col-md-5"></div>
              <div class="col-md-2" align="center">
                  <form id="form1" action="?c=comidaservida&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="idComidaservida" name="idComidaservida" value="<?php echo $vte->idComidaservida;?>" placeholder=""> 
           
              <input type="hidden" class="form-control" name="idHotel" id="idHotel" placeholder="Hotel" value="5">
                
        

                    <div class="row">     
                      <div class="col-md-12">
              <h4>Tipo de Comida: </h4>
              <select  name="tipoComida" id="tipoComida" class="form-control  input-sm">                            
                                <option value="Desayuno">Desayuno</option>
                                <option value="Almuerzo">Almuerzo</option>
                                <option value="Cena">Cena</option>
                                <option value="fria">Colación Fria</option>
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
                        <h4>Cantidad </h4>
                           <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="cantidad">
                        </div>             
                    </div>
                    <div class="row">     
                      <div class="col-md-12">
                            
                            <input type="hidden" class="form-control" name="fechaComida"   id="fechaComida" onkeyup="" placeholder=""  value="<?php echo date("Y-m-d")?>"> 
                        </div>              
                    </div>

       
</div>
 
 <div class="col-md-5"></div>




           
                    <div class="col-md-12" align="center">
                    <br>
                      <input type="submit"  id="Guardar" class="btn btn-success" value='Solicitar'/>

                      <!--
                          <input type="button" id="cancelar" class="btn btn-danger" name="Recargar" value="Cancelar" onClick="location.href='?c=comidaextra&a=menuComidaExtra'">  -->           
                    </div>
          
                


</div>
                                    
   
              </form>


              
<script src="jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#Guardar').click(function(){

        var id = $("#persona").val();
        var tipoComida = $("#tipoComida").val();        
        var parametros = {"id":id,"tipoComida":tipoComida}; 
           $.ajax({
               url: 'ticketComidaExtra.php',
               type: 'POST',
               data: parametros, 


               success: function(data){
                   if(data==1){
                       alert('Imprimiendo....');

                   }else{
                          location.reload();
                   }
               }
           }); 
        });
    });


</script>

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



</div>
       


</div>


       

<!---->

