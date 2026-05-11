<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="hospedaje/js/ajaxHDiario.js"></script>

<div class="container-fluid">
     <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
<h2 class="titulos" align="center">Resumen de Hospedajes </h2>

     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Hospedaje registrado correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Hospedaje eliminado correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Hospedaje actulizado correctamente..</div>'; ?>


<div class="row">
    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">



    <div class="col-md-1">
            <h4>Hotel</h4>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">

                 <option value="">Todos</option>
              <?php  foreach ($this->model->ListarHotel()as $a): ?>
                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach; ?>  
            </select>
    </div>
        
      
 <div class="col-md-1">
<h4>Empresa</h4>
            <select name="idEmpresa" id="idEmpresa" class="form-control  input-sm"> 
             <option value="">Todas</option>              
              <?php  foreach ($this->model->ListarEmpresas()as $a): ?>
                 <option  <?php echo $a->idEmpresa == "" ? 'selected' : ''; ?> value="<?php echo "$a->idEmpresa" ;?>"><?php echo $a->nombreEmpresa;?></option>
                                  <?php endforeach; ?>  
            </select>

    </div>
 <?php $fecha=date('Y-m-d') ?>
    
        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group">
               <input class="form-control" id="desde" name="desde"  type="date" value="<?php echo $fecha; ?>"  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value="<?php echo $fecha; ?>"  autocomplete="off" required/>

          </div>
        </div>

          <!--<div class="col-md-1">
    <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar Hospedajes"><img src="img/pdf.png" width="50px" height="50px">
        <p>Pdf</p></a>
       </div>-->
      <div class="col-md-1">

         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar Hospedajes"><img src="img/excel.png" width="50px" height="50px"><p>Excel</p></a>
      </div>




     
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

        