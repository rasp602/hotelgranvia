<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="empresa/js/ajaxE.js"></script>

<div class="container-fluid">
     <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  


     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Contrato registrado correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Contrato eliminado correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Contrato actulizado correctamente..</div>'; ?>


<div class="row">
    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">
</div>

    <!--<div class="row">
        <div class="col-md-1"></div>
    	<div class="col-md-10">
    		<div class="outer_div"></div>
    	</div>
  <div class="col-md-1"></div>
        <div id="result"></div>
    </div>-->
    <?php include_once 'contrato/vista/contrato.php'; ?>

</div>



