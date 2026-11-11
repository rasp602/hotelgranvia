<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="hospedaje/js/ajaxDisponibilidad.js"></script>

<div class="container-fluid">
     <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
<h2 class="titulos" align="center"> Disponiblidad </h2>

<div class="row">
    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">


    <div class="col-md-1">
            <h4>Hotel</h4>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">


              <?php  foreach ($this->model->ListarHotel()as $a): ?>
                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach; ?>  
            </select>
    </div>


  <div class="col-md-1">
            <h4>Estado</h4>
            <select name="estado" id="estado" class="form-control input-sm">  
            <option value="">Todas</option>             
            <option value="A">Disponible</option>
            <option value="I">Ocupado</option>            
            </select>
        </div>
    
 

     
    </div>

    <div class="row">
        <div class="col-md-2"></div>
    	<div class="col-md-8">
    		<div class="outer_div"></div>
    	</div>
  <div class="col-md-2"></div>
        <div id="result"></div>
    </div>

</div>




        