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
include '../../bd/conexionLocal.php'; //incluir el archivo de conexion

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include 'pagination_Diario.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
  
$descripcion = $_REQUEST["descripcion"];
$idHotel = $_REQUEST["idHotel"];
$idHabitacion = $_REQUEST["idHabitacion"];
$idCama = $_REQUEST["idCama"];
$estado = $_REQUEST["estado"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$idEmpresa = $_REQUEST["idEmpresa"];
$fecha1= Date('3000-01-01');

$fechaActual=date("Y-m-d");

$where="where FechaR BETWEEN '".$desde."' AND '".$hasta."'";
if ($idHotel!="" && $desde!="" && $hasta!="") {
    $where="where hotel.idHotel ='".$idHotel."' and FechaR BETWEEN '".$desde."' AND '".$hasta."'  ";
  echo "Busca hotel"; 
}


if ($idEmpresa!="" && $desde!="" && $hasta!="") {
    $where="where persona.idEmpresa ='".$idEmpresa."'";
  echo "Busca Empresa "; 
}


if ($idHotel!="" && $idEmpresa!="" && $desde!="" && $hasta!="") {
    $where="where persona.idEmpresa ='".$idEmpresa."' and hotel.idHotel ='".$idHotel."' and FechaR BETWEEN '".$desde."' AND '".$hasta."'  ";
  echo "Busca Empresa con hotel"; 
}

/*
echo "idMaquina:". $idMaquina;
echo "tipoA". $tipoA;  


$fecha2= Date('3000-12-31');

echo "fecha 1:".$fecha1;
echo "fecha 2:".$fecha2;
*/  
      	$count_query1 = mysqli_query($con,"SELECT        
        hospedaje.idHospedaje,
        hospedaje.idPersona,
        hospedaje.idHotel,
        hospedaje.idHabitacion,
        hospedaje.idCama,
        hospedaje.desde,
        hospedaje.hasta,
        hospedaje.estado,
        resumenhospedaje.idResumen,
        resumenhospedaje.idHospedaje,
        resumenhospedaje.FechaR,
        resumenhospedaje.Act,

        hotel.idHotel,
        hotel.nombreHotel,
        hotel.capacidadHotel,
        hotel.direccion,

        habitacion.idHabitacion,
        habitacion.idHotel,
        habitacion.nHabitacion,
        habitacion.capacidadHabitacion,
       
        
        cama.idCama,
        cama.idHabitacion,
        cama.nCama,
        cama.estadoCama,

        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.rutPersona,

        empresa.idEmpresa,
        empresa.nombreEmpresa,
        
        count(*) AS numrows1 FROM resumenhospedaje 
        INNER JOIN hospedaje ON hospedaje.idHospedaje=resumenhospedaje.idHospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa   
         $where ");

    		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
    		$total_pages = ceil($numrows1/$per_page);
    		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

$query = mysqli_query($con,"SELECT        
        hospedaje.idHospedaje,
        hospedaje.idPersona,
        hospedaje.idHotel,
        hospedaje.idHabitacion,
        hospedaje.idCama,
        hospedaje.desde,
        hospedaje.hasta,
        hospedaje.estado,
        resumenhospedaje.idResumen,
        resumenhospedaje.idHospedaje,
        resumenhospedaje.FechaR,
        resumenhospedaje.Act,

        hotel.idHotel,
        hotel.nombreHotel,
        hotel.capacidadHotel,
        hotel.direccion,

        habitacion.idHabitacion,
        habitacion.idHotel,
        habitacion.nHabitacion,
        habitacion.capacidadHabitacion,
       
        
        cama.idCama,
        cama.idHabitacion,
        cama.nCama,
        cama.estadoCama,

        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.rutPersona,

        empresa.idEmpresa,
        empresa.nombreEmpresa        
        FROM resumenhospedaje
        INNER JOIN hospedaje ON hospedaje.idHospedaje=resumenhospedaje.idHospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa        
        $where ORDER by hospedaje.idHospedaje LIMIT $offset,$per_page");


	
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>
                                <tr class="bg-primary">              
                                 <th>Fecha</th>
                                 <th>Hotel</th>
                                 <th>Habitación</th> 
                                 <th>Apelldio Paterno</th>
                                 <th>Apellido Materno</th>
                                 <th>Nombre</th>
                                 <th>R.u.t</th>                                 
                                 <th>Alojamiento</th> 
                                 <th>Desayuno</th>
                                 <th>Almuerzo</th>
                                 <th>Cena</th>
                                                     
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){  
               


            ?>
				<tr>
            <td class="contenidoTabla"><?php echo utf8_encode($row['FechaR']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombreHotel']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nHabitacion']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoPersona1']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoPersona2']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombresPersona']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['rutPersona']);?></td>			
            <td class="contenidoTabla"><?php echo utf8_encode($row['Act']);?></td>
            <td class="contenidoTabla"></td>
            <td class="contenidoTabla"></td>
            <td class="contenidoTabla"></td>  
              
          
     			</tr>
			<?php
			 }
			?>
			</tbody>
		</table>
		</div>
		<?php echo "<div align='center'> <b>Total de Registros encontrados :</b>"; echo"&nbsp".$numrows1 ; echo "</div>"; ?>
            </div>
        </div>
			<div class="table-pagination pull" align="center">
				<?php echo paginate($reload, $page, $total_pages, $adjacents);?><br><br>
			</div>
		
			<?php
			
		} else {
			?>
			<div class="container"><br>
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