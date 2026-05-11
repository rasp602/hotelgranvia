<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="hospedaje/js/ajaxHE.js"></script>

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
                   if ($usuario->nivel == "E") 
                        {
                                echo "Hola empresa";
                                include_once 'menu_principal/vista/Menu_Empresa.php';   
                        }                         
               }               
         ?> 
<h2 class="titulos" align="center"> Hospedajes </h2>

     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Hospedaje registrado correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Hospedaje eliminado correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Hospedaje actulizado correctamente..</div>'; ?>


<div class="row">
    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">
     <input type="hidden" name="idEmpresa" id="idEmpresa" value="26">
<!--
    <div class="col-md-2">
        <h4>Rut, nombre, apellido</h4>
           <input type="text" class="form-control input-sm" id="descripcion" name="descripcion" placeholder="Buscar:">
    </div>
            -->
    <div class="col-md-1">
            <h4>Hotel</h4>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">

                 <option value="">Seleccione</option>
                 <option value="1">H1</option>
                 <option value="25">H1B</option>
                 <option value="2">H2</option>
                 <option value="3">H3</option>
                
                 


              <?php  /*foreach ($this->model->ListarHotel()as $a): ?>
                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach;*/ ?>  
            </select>
    </div>


    <div class="col-md-1">
            <h4>Habitacion</h4>

            <select name="idHabitacion" id="idHabitacion" class="form-control  input-sm">
                    
            </select>
    </div>


    <div class="col-md-1">
            <h4>Cama</h4>
            <select name="idCama" id="idCama" class="form-control  input-sm">
               
            </select>
    </div>

        
      


        <div class="col-md-1">
            <h4>Estado</h4>
            <select name="estado" id="estado" class="form-control input-sm">  
            <option value="">Todos</option>             
            <option value="A">ACTIVO</option>
            <option value="I">INACTIVO</option>            
            </select>
        </div>
    <!--
        <div class="col-md-2">
            <h4> Entraron Desde</h4>
          <div class="input-group">
               <input class="form-control" id="desde" name="desde"  type="date" value=""  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value=""  autocomplete="off" required/>

          </div>
        </div>-->

          <div class="col-md-1">
    <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar Hospedajes"><img src="img/pdf.png" width="50px" height="50px">
        <p>Pdf</p></a>
       </div>
      <!--<div class="col-md-1">
         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar Hospedajes"><img src="img/excel.png" width="50px" height="50px"><p>Excel</p></a>
      </div>-->

   <!-- <div class="col-md-1" align="center">
        <a href="javascript:cargaExcel();"  data-toggle="tooltip" title="Carga de datos"><img src="img/excel.png" width="50px" height="50px"><p>Carga de datos</p></a>
          </div>-->
     
    </div>

    <div class="row">

    	<div class="col-md-12">
    		<div class="outer_div"></div>
    	</div>

        <div id="result"></div>
    </div>

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
            url:'hospedaje/reportes/getHabitacion.php',
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
            url:'hospedaje/reportes/getCama.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idCama").html(data).fadeIn('fast');

             
            }
        })
      });
   
}


    </script> 

        