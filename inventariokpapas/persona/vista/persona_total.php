<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="actividad/js/ajaxTotal.js"></script>

<div class="container-fluid">

<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
     <h2 class="titulos" align="center"> Falla Totales </h2>
     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Falla registrada correctamente..</div>'; ?> 
        <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Falla eliminada correctamente..</div>'; ?> 
         <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Falla actulizada correctamente..</div>'; ?>  
	<div class="row">
        <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">
   <script>
    $(document).ready(function(){
        load();
    });

    function load(){      
      
        var id = $("#idLinea").val();        
        var parametros = {"id":id};  
        $.ajax({
            url:'actividad/reportes/getLinea.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idMaquina").html(data).fadeIn('slow');
              
            }
        })
      ;
    
}
    </script>
                    <div class="col-md-2 titulos2">
                    <h4>Maquina</h4>
                          <select name="idMaquina" id="idMaquina" class="col-md-2 form-control"> 
                                                         
                          </select>
                    </div>              
            






        <input type="hidden" name="idLinea" id="idLinea" value="3">


   
                              
           
        

   
     

    <!--
      <div class="col-md-1 titulos2">
      <br>
         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar actividad"><img src="img/excel.png" width="50px" height="50px" "></a>
      </div>-->
     
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="outer_div"></div>
    	</div>

        <div id="result"></div>
    </div>

</div>
