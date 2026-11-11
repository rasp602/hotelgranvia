<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script src="actividad/js/ajaxA.js"></script>

<div class="container-fluid">

<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
     <h2 class="titulos" align="center"> Actividades </h2>
     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Actividad registrada correctamente..</div>'; ?> 
        <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Actividad eliminada correctamente..</div>'; ?> 
         <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Actividad actulizada correctamente..</div>'; ?>  
	<div class="row">
        <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">
        <div class="col-md-2 titulos2"><h4>Descripción / Maquina</h4>
           <input type="text" class="form-control input-sm" id="descripcion" name="descripcion" placeholder="Buscar:">
        </div>
        <div class="col-md-2 titulos2"><h4>Tipo de Actividad</h4>
           <select name="tipoA" id="tipoA" class="form-control  input-sm">
               <option value="">Todas</option>
               <option value="GPS">GPS</option>
               <option value="CAMARAS">CAMARAS</option>
               <option value="SISTEMAS">SISTEMAS</option>            
           </select>
        </div>

        <div class="col-md-2 titulos2"><h4>Seleccione una linea</h4>
            <select name="idLineaA" id="idLineaA" class="form-control input-sm">
                <option value="">Todas</option>
                <?php  foreach ($this->model->ListarLineas()as $a): ?>
                <option  <?php echo $a->idLinea == "" ? 'selected' : ''; ?> value="<?php echo "$a->idLinea" ;?>"><?php echo $a->nLinea;?></option>
                <?php endforeach; ?>
            </select>
        </div> 

    
        
        <div class="col-md-2 titulos2"><h4>Estado</h4>
            <select name="estado" id="estado" class="form-control input-sm">   
            <option value="">--</option>    
            <option value="Pendiente">Pendiente</option>
            <option value="Aprobado" >Aprobado</option>            
            </select>
        </div>

        <script>
          $(document).ready(function(){
              var date_input=$('input[name="desde"]'); //our date input has the name "date"
              var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
              date_input.datepicker({
                  format: 'yyyy/mm/dd',
                  container: container,
                  todayHighlight: true,
                  autoclose: true,
              })
          })
        </script>
        <script>
          $(document).ready(function(){
              var date_input=$('input[name="hasta"]'); //our date input has the name "date"
              var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
              date_input.datepicker({
                  format: 'yyyy/mm/dd',
                  container: container,
                  todayHighlight: true,
                  autoclose: true,
              })
          })
        </script> 

                <div class="col-md-2 titulos2"><h4>Desde</h4>
                  <div class="input-group">
                   <input class="form-control input-xs" id="desde" name="desde"  type="text" value="" required/>
                      <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </div>
                  </div>
                </div>  


                <div class="col-md-2 titulos2"><h4>Hasta</h4>
                  <div class="input-group">
                   <input class="form-control input-xs" id="hasta" name="hasta"  type="text" value="" required/>
                      <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </div>
                  </div>
                </div>

          <div class="col-md-1 titulos2">
          <br>
    <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar actividad"><img src="img/pdf.png" width="50px" height="50px" "></a>
     
        </div>
      <div class="col-md-1 titulos2">
      <br>
         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar actividad"><img src="img/excel.png" width="50px" height="50px" "></a>
      </div>
     
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="outer_div"></div>
    	</div>

        <div id="result"></div>
    </div>

</div>
