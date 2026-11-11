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
		include 'pagination_tipoA.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="";
$descripcion = $_REQUEST["descripcion"];
$idHotel = $_REQUEST["idHotel"];
$idHabitacion = $_REQUEST["idHabitacion"];
$idCama = $_REQUEST["idCama"];
$estado = $_REQUEST["estado"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');
/*
echo "idMaquina:". $idMaquina;
echo "tipoA". $tipoA;  


$fecha2= Date('3000-12-31');

echo "fecha 1:".$fecha1;
echo "fecha 2:".$fecha2;
*/  

if ($idHotel!="") {
    $where="where hotel.idHotel ='".$idHotel."%'";
  echo "Busca Hotel solo"; 
}


        $count_query1 = mysqli_query($con,"SELECT 
        
        hospedaje.idHospedaje,
        hospedaje.idPersona,
        hospedaje.idHotel,
        hospedaje.idHabitacion,
        hospedaje.idCama,
        hospedaje.desde,
        hospedaje.hasta,
        hospedaje.estado,

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

        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.rutPersona, 

        empresa.idEmpresa,
        empresa.nombreEmpresa
        
        count(*) AS numrows1 FROM hospedaje 
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa 
         $where");

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
        persona.rutPersona,

        empresa.idEmpresa,
        empresa.nombreEmpresa

        
        FROM hospedaje
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
                                 <th>#</th>  
                                 <th>Hotel</th>
                                 <th>Rut</th>
                                 <th>Persona</th>
                                 <th>Habitación</th>
                                 <th>Cama</th>
                                 <th>Empresa</th> 
                                 <th>Entrada</th>
                                 <th>Salida</th>
                                 <th>Estado</th>
                                 <th>Acciones</th>                              
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){                 
         
            ?>
				<tr>
            <td class="contenidoTabla"><?php echo utf8_encode($row['idHospedaje']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombreHotel']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['rutPersona']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombresPersona']." ".$row['apellidoPersona1']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nHabitacion']);?></td>
			<td class="contenidoTabla"><?php echo utf8_encode($row['nCama']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombreEmpresa']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['desde']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['hasta']);?></td>
                            
                    <td class="contenidoTabla">
                      <?php if ($row['estado']=="A"): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                          <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                      <?php endif ?>
                      <?php if ($row['estado']=="I"): ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                      <?php endif ?>
                    </td>            

              <td><a href="?c=hospedaje&a=Crud1&idHospedaje=<?php echo $row['idHospedaje']?>" class="glyphicon glyphicon-pencil"></a> <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=hospedaje&a=Eliminar&idHospedaje=<?php echo $row['idHospedaje']?>" class="glyphicon glyphicon-remove"></a></td>
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