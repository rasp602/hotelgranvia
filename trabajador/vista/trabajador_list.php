<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


<script src="trabajador/js/ajaxTrabajador.js"></script>

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
<h2 class="titulos" align="center">Trabajadores </h2>

     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Trabajador registrado correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Trabajador eliminado correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Trabajador actulizado correctamente..</div>'; ?>


<div class="row">
    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">

    <div class="col-md-2">
        <h5>R.U.T/Nombre/Apellido</h5>
           <input type="text" class="form-control input-sm" id="nombreTrabajador" name="nombreTrabajador" placeholder="Buscar:">
    </div>

    <div class="col-md-1">
            <h5>Genero</h5>
            <select name="genero" id="genero" class="form-control  input-sm">
                    <option value="">Todos</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
            </select>
    </div>


                <div class="col-md-2">
            <h5>Hotel</h5>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">
            <option value="">Todos</option>
          <?php  foreach ($this->model->ListarHotel()as $a): ?>
                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach; ?>  
            </select>
        </div>
        <div class="col-md-1">
            <h5>Estado</h5>
            <select name="estado" id="estado" class="form-control  input-sm">
                    <option value="">Todos</option>
                    <option value="A" selected>Activos</option>
                    <option value="I">Inactivos</option>
            </select>
        </div>

        <div class="col-md-2">
            <h5>Desde</h5>
          <div class="input-group">
               <input class="form-control" id="desde" name="desde"  type="date" value=""  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h5>Hasta</h5>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value=""  autocomplete="off" required/>

          </div>
        </div>

          <div class="col-md-1" align="center">
      
    <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar trabajadores"><img src="img/pdf.png" width="50px" height="50px">
    <p>PDF</p></a>
     
      </div>

      <div class="col-md-1" align="center">
        <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar personas"><img src="img/excel.png" width="50px" height="50px"><p>Excel</p></a>
      </div>

      <!--<div class="col-md-1" align="center">
        <a href="?c=trabajador&a=Descanso"  data-toggle="tooltip" title="descargar personas"><img src="img/descanso.png" width="50px" height="50px"><p>Descanso</p></a>
      </div>-->
     
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



