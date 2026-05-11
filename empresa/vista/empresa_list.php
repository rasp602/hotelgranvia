<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="empresa/js/ajaxE.js"></script>

<div class="container-fluid">
     <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
	<h2 class="titulos" align="center"> Empresas </h2>

	     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Empresa registrada correctamente..</div>'; ?> 

	     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Empresa eliminada correctamente..</div>'; ?> 
	        
	     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Empresa actulizada correctamente..</div>'; ?>


	<div class="row">
	    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">
	 <div class="col-md-1">
	           </div>

	    <div class="col-md-2">
	        <p>Nombre Empresa:</p>
	           <input type="text" class="form-control input-sm" id="nombreEmpresa" name="nombreEmpresa" placeholder="Buscar:">
	    </div>
	<div class="col-md-1" align="center">
	             <a href="?c=empresa&a=Crud"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-building-add" viewBox="0 0 16 16">
	  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Z"/>
	  <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1V1Z"/>
	  <path d="M4.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
	</svg>
	 <p>Agregar Empresa</p></a>
	</div>


	          <div class="col-md-1" align="center">
	            <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar actividad"><img src="img/pdf.png" width="50px" height="50px">
	           <p>Pdf</p>
	            
	        </a>
	          </div>


	<div class="col-md-1" align="center">
	        <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar empresas"><img src="img/excel.png" width="50px" height="50px"><p>Excel</p></a>
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
    <?php /*include_once 'empresa/vista/empresa.php'; */?>

</div>



