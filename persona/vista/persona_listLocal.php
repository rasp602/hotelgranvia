<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="persona/js/ajaxA.js"></script>

<div class="container-fluid">
     <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
<h2 class="titulos" align="center"> Lista de Personas </h2>

     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Persona registrada correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Persona eliminada correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Persona actulizada correctamente..</div>'; ?>


<div class="row">
    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">

    <div class="col-md-2">
        <h4>Rut:</h4>
           <input type="text" class="form-control input-sm" id="rutPersona" name="rutPersona" placeholder="Buscar:">
    </div>

    <div class="col-md-2">
        <h4>Nombre:</h4>
           <input type="text" class="form-control input-sm" id="nombresPersona" name="nombresPersona" placeholder="Buscar:">
    </div>

    <div class="col-md-1">
            <h4>Genero</h4>
            <select name="genero" id="genero" class="form-control  input-sm">
                    <option value="">Genero</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
            </select>
    </div>

        
        <div class="col-md-1">
            <h4>Estado</h4>
            <select name="estado" id="estado" class="form-control input-sm">  
            <option value="">Estado</option>             
            <option value="A">ACTIVO</option>
            <option value="I">INACTIVO</option>            
            </select>
        </div>

                <div class="col-md-1">
            <h4>Empresa</h4>
            <select name="idEmpresa" id="idEmpresa" class="form-control  input-sm">

               
              <?php  foreach ($this->model->ListarEmpresas()as $a): ?>
                 <option  <?php echo $a->idEmpresa == "" ? 'selected' : ''; ?> value="<?php echo "$a->idEmpresa" ;?>"><?php echo $a->nombreEmpresa;?></option>
                                  <?php endforeach; ?>  
            </select>
        </div>

        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group">
               <input class="form-control" id="desde" name="desde"  type="date" value=""  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value=""  autocomplete="off" required/>

          </div>
        </div>

          <div class="col-md-1">
          <br>
    <a href="javascript:reportePDF11();"  data-toggle="tooltip" title="descargar Personas"><img src="img/pdf.png" width="50px" height="50px"></a>
     

         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar actividad"><img src="img/excel.png" width="50px" height="50px"></a>
      </div>
     
    </div>

    <div class="row">
        <div class="col-md-1"></div>
    	<div class="col-md-10">
    		<div class="outer_div"></div>
    	</div>
  <div class="col-md-1"></div>
        <div id="result"></div>
    </div>

</div>



