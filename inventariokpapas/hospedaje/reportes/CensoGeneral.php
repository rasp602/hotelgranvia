<?php     error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php. ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  
<?php
include 'tabla.php';
include '../../bd/conexionLocal.php'; //incluir el archivo de conexion

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include 'pagination_tipoA.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 50; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="";

$idHotel = $_REQUEST["idHotel"];


$estadoHabitacion = $_REQUEST['estadoHabitacion'];


$fecha1= Date('3000-01-01');

$fechaActual=date("Y-m-d");
/*
echo "idMaquina:". $idMaquina;
echo "tipoA". $tipoA;  


$fecha2= Date('3000-12-31');

echo "fecha 1:".$fecha1;
echo "fecha 2:".$fecha2;
*/  



		//consulta principal para recuperar los datos



/*SEGUNDA CONSULTA*/
  /*CONSULTA PARA CAPACIDAD TOTAL*/ 
$query = mysqli_query($con,"
  SELECT 
        hotel.idHotel,
        hotel.nombreHotel,
        hotel.capacidadHotel,
        hotel.direccion,

        habitacion.idHabitacion,
        habitacion.idHotel,
        habitacion.nHabitacion,
        habitacion.capacidadHabitacion,
        habitacion.estado,
        
        cama.idCama,
        cama.idHabitacion,
        cama.nCama,
        cama.estadoCama,
        
        count(*) AS numrows1

         FROM hotel  

        INNER JOIN habitacion ON hotel.idHotel=habitacion.idHotel
        INNER JOIN cama ON habitacion.idHabitacion=cama.idHabitacion  
        
        WHERE cama.estadoCama = 'I' GROUP BY hotel.idHotel" );

		if (mysqli_num_rows($query) > 0){
			?>
		
            
    


<div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
        



            </div>
          </div>
</div>


<?=$tabla_html?>




		
			<?php
			
		} else {
			?>
			<div class="container-fluid"><br>
			<div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              
              <h4>Aviso!!!</h4> No hay datos para mostrar..!!!!!
			</div>
            </div>
			<?php

		}
	}
    
?>
</body>
</html>