<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
    
	
?>


<?php
include_once '../modelo/alumno.php';
session_start();
$usuario = null;
if (isset($_SESSION["usuarioInventario"])) {
    $usuario = $_SESSION["usuarioInventario"];
} else {
    header("Location: index.php");
}
?>


<div class="container">


<ol class="breadcrumb">
  <li><a href="?c=Alumno">Alumnos</a></li>
  <li class="active"></li>
</ol>

<div class="container-fluid" >
<div class="row">
<div class="col-md-4">

<form id="frm-alumno" action="?c=Alumno&a=Guardar" method="post" enctype="multipart/form-data">
<h3><span class="glyphicon glyphicon-user"></span> Datos Personales: </h3>


<div class="row">

        <div class="form-group col-xs-4 col-sm-3 col-md-3">
            <select name="Tipo" id="option" class="form-control">
                <option value="Venezolano">V</option>
                <option value="Gobierno">G</option>
                <option value="Extrajero">E</option>
                <option value="Juridico">J</option>
            </select>
        </div>
        
        <div class=" col-xs-8 col-sm-9 col-md-9">
        <input type="text" class="form-control" name="Cedula" placeholder="Cedula:" >
        </div>
</div> 


       <input type='text'  class='form-control' name='Nombre' placeholder="Nombre:" /><br>
       <input type='text'  class='form-control' name='Apellido' placeholder="Apellido:" /><br>
       
       <input type='text'  class='form-control' name="Rif" placeholder="Rif:"/>

        <input type="hidden" class='form-control' name="Fechacrea" value="<?php echo date("Y-m-d");?>"><br>
        <input type="date" class='form-control'   name="FechaNacimiento"><br>


<div class="row">
      <div class="form-group col-xs-12 col-sm-12 col-md-12">
            <select name="Genero" id="option" class="form-control">
                <option value="#">GENERO:</option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
                       </select>
      </div>
</div>



<h3><span class="glyphicon glyphicon-road"></span> Dirección: </h3>
        <input type="text" class="form-control" name="Av" placeholder="Av:"><br>
        <input type="text" class="form-control" name="Calle" placeholder="Calle:"><br>
        <input type="text" class="form-control" name="Casa" placeholder="Casa:"><br>
        <input type="text" class="form-control" name="Numero" placeholder="Nro:"><br>
    
</div>

<div class="col-md-4">



<h3><span class="glyphicon glyphicon-user"></span> Usuario: </h3>


                        <select name="Nivel" id="2" class="form-control" >
                        <option value="#">Nivel:</option>
                        <option value="U">Usuario</option>
                        <option value="A">Administrador</option>
                        </select>
                        <br>
                      

                           
                        <input type='text' id='email' class='form-control' name='Email' placeholder="E-mail:"><br>
                        <input type='password' id='password' class='form-control' name='Password' placeholder="Clave:" /><br>

                



        

                        <select name="Activo" id="1" class="form-control">
                        <option value="#">Estatus:</option>
                        <option value="A">Activo</option>
                        <option value="I">Inactivo</option>
                        </select>
                         <br>
                      

<h3><span class="glyphicon glyphicon-user"></span> Telefonos: </h3>
        <input type="text" class="form-control" name="casa" placeholder="casa:"><br>
        <input type="text" class="form-control" name="movil" placeholder="movil:"><br>
        <input type="text" class="form-control" name="oficina" placeholder="oficina:"><br> 

</div>

<div class="form-group col-md-4">
<h3><span class="glyphicon glyphicon-user"></span> Foto: </h3>
<div class="container" >
    <script type="text/javascript" src="webcam.js"></script>
    <script language="JavaScript">
		webcam.set_api_url( 'test.php' );
		webcam.set_quality( 100 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
		<script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>





		<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function take_snapshot() {

			
			// take snapshot and upload to server
			//document.getElementById('upload_results').innerHTML = '<h1>Uploading...</h1>';
			webcam.snap();
		}
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {

				var image_url = RegExp.$1;

				$('#imagen').val(image_url);
				// show JPEG image in page
				//document.getElementById('upload_results').innerHTML = document.cookie =''+image_url+';';				
				
				// reset camera for another shot
				webcam.reset();
			}
			else alert("PHP Error: " + msg);
		}
	</script>

	</div>
<br>
<br>

        <input type="text" class='form-control' id='imagen'  name="Imagen" ><br>

	<div id="upload_results" style="background-color:#eee;"></div>

        	<input type=button value="Configure..." onClick="webcam.configure()">
		&nbsp;&nbsp;
		<input type=button value="Take Snapshot" onClick="take_snapshot()">
                       
  </div>

<div class="col-md-12" align="center">

    <input type="submit"  class="btn btn-primary" value='Aceptar'  id='agregar_nuevo'/>
    <input type="submit"  class="btn btn-danger" value='Cancelar' id='close' /></div>  

</div>

</form>

<script>
    $(document).ready(function(){
        $("#frm-alumno").submit(function(){
            return $(this).validate();
        });
    })
</script>




 
</div>
       


<?php include ('footer.php'); ?>


