<script src="comida/js/ajaxComidasEmpresas.js"></script>

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
                    if ($usuario->nivel == "I") 
                        {
                                echo "hola Inventario";
                                include_once 'menu_principal/vista/Menu_Inventario.php';   
                        }                       
               }               
         ?> 
    <h3  class="page-header" align="center">COMIDAS</h3>
        <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Comida registrada correctamente..</div>'; ?> 
        
        <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Comida eliminada correctamente..</div>'; ?>  
  
     <input type="hidden" name="idEmpresa" id="idEmpresa" value="26">
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
            <div class="titulos2"><h4>T.Comida</h4>
            <select name="tipoComida" id="tipoComida" class="form-control  input-sm">
                    <option value="">Todas</option>
                    <option value="Desayuno">Desayuno</option>
                    <option value="Almuerzo">Almuerzo</option>
                    <option value="Cena">Cena</option>
            </select>
            </div>
        </div>

        
    <?php $fecha=date('Y-m-d') ?> 
        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group">
               <input class="form-control" id="desde" name="desde"  type="date" value="<?php echo $fecha=date('Y-m-d') ?>"/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value="<?php echo $fecha=date('Y-m-d') ?>"  autocomplete="off" required/>

          </div>
        </div>        
      
             <div class="col-md-1">
            <a href="javascript:reportePDF1();"  data-toggle="tooltip" data-placement="top" title="Descargar pdf"><img src="img/pdf.png" width="50px" height="50px">
                <p>Reporte</p></a>
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

    