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


<!-- select con buscador -->

<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>



<div class="">
  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>   
  <?php $cliente=$usuario->id_user;?>       

  <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">La persona que intenta ingresar ya se encuentra registrada y con una habitacion ocupada</div>';?> 
        <div class="col-md-2"></div>
        <div class="col-md-8">

                        <h2 align="center" class="titulos">Editar Hospedaje</h2>

    <form id="form1" action="?c=hospedaje&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
      <input type="hidden" class="form-control" id="idHospedaje" name="idHospedaje" value="<?php echo $vte->idHospedaje;?>"> 
       <input type="hidden" class="form-control" id="estado" name="estado" value="A">          




    <div class="row">
      <div class="col-md-12">
   <h4>Persona</h4>
      <select  name="idPersona" id="idPersona" class="form-control  input-sm selectpicker" data-show-subtext="true" data-live-search="true">

<?php
include "../../bd/db.php";
$con = connect();
if (!$con->set_charset("utf8")) {//asignamos la codificación comprobando que no falle
       die("Error cargando el conjunto de caracteres utf8");
}
$consulta = "SELECT * FROM persona";
$resultado = mysqli_query($con , $consulta);
$contador=0;

while($misdatos = mysqli_fetch_assoc($resultado)){ $contador++;?>
<option value="<?php echo $misdatos["idPersona"]; ?>"data-subtext=""><?php echo $misdatos["nombresPersona"]." ".$misdatos["apellidoPersona1"]; ?></option>
<?php }?>          
</select>

    </div>



 </div>



                <div class="row">     
                       <div class="col-md-12">
            <h4>Hotel</h4>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">
               <option value="">Selecciona un hotel</option>
            <?php  foreach ($this->model->ListarHotel()as $a): ?>
                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach; ?>  
            </select>
             </div>            
                  </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Habitacion</h4>
                    <select name="idHabitacion" id="idHabitacion" class="form-control  input-sm">

                   </select>
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Cama</h4>
                      <select name="idCama" id="idCama" class="form-control  input-sm">
               
                     </select>
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Desde</h4>
                    <input type="date" class="form-control" id="desde" name="desde" placeholder="desde" value="<?php echo date("Y-m-d");?>">
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Hasta</h4>
                    <input type="date" class="form-control" id="hasta" name="hasta" placeholder="hasta" value="<?php echo date("Y-m-d");?>">
                    </div>              
                  </div>                  

                                 
      
                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Hospedar" class="btn btn-success" value='Registrar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">             
                    </div>
                 </div>                          
          
              </form>


</div>
        <div class="col-md-2"></div>
</div>
       
</div>

 <!-- div del menu -->
</div>

    <script>
    $(document).ready(function(){
        load88();
    });

    function load88(){
        $("#idHotel").change(function(e){
        e.preventDefault();  
        $("#idHabitacion").empty();
        $("#idCama").empty();
        var id = $("#idHotel").val();        
        var parametros = {"id":id};  
        $.ajax({
            url:'hospedaje/reportes/getHabitacionDisponible.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idHabitacion").html(data).fadeIn('fast');

             
            }
        })
      });
   
}

    </script> 

        <script>
    $(document).ready(function(){
        load89();
    });

    function load89(){
        $("#idHabitacion").change(function(e){
        e.preventDefault();  
        $("#idCama").empty();
        var id = $("#idHabitacion").val();        
        var parametros = {"id":id};  
        $.ajax({
            url:'hospedaje/reportes/getCamaDisponible.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idCama").html(data).fadeIn('fast');

             
            }
        })
      });
   
}
    </script>    
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> 