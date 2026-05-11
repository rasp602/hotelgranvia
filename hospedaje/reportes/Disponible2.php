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
		include 'pagination_Disponible2.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 300; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$idUsuario = $_REQUEST['idUsuario'];


$idHotel = $_REQUEST["idHotel"];


$estadoHabitacion = $_REQUEST['estadoHabitacion'];


$fecha1= Date('3000-01-01');

$fechaActual=date("Y-m-d");
$where="";
  if ($idHotel!="") {
    $where="where hotel.idHotel ='".$idHotel."'";


}

      	$count_query1 = mysqli_query($con,"SELECT   
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
        
        count(*) AS numrows1  FROM hotel  

        INNER JOIN habitacion ON hotel.idHotel=habitacion.idHotel
        INNER JOIN cama ON habitacion.idHabitacion=cama.idHabitacion 


         $where order by habitacion.nHabitacion");

    		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
    		$total_pages = ceil($numrows1/$per_page);
    		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

$query = mysqli_query($con,"SELECT 
        
        habitacion.idHabitacion,
        habitacion.idHotel,
        habitacion.nHabitacion,
        habitacion.capacidadHabitacion,
        habitacion.capacidadReal,
        habitacion.estado,
        hotel.idHotel,
        hotel.nombreHotel,
        hotel.capacidadHotel,
        hotel.direccion,
        hospedaje.idHospedaje,
        hospedaje.idPersona,
        hospedaje.idHotel,
        hospedaje.idHabitacion,
        hospedaje.idCama,
        hospedaje.estado,
        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.rutPersona,
        empresa.idEmpresa,
        empresa.nombreEmpresa,
        cama.idCama,
        cama.idHabitacion,
        cama.nCama,
        cama.estadoCama,
        COUNT(cama.idCama)AS Cuenta

        FROM habitacion 
        LEFT JOIN hotel ON habitacion.idHotel=hotel.idHotel
        inner JOIN cama ON cama.idHabitacion=habitacion.idHabitacion
        LEFT JOIN hospedaje ON habitacion.idHabitacion=hospedaje.idHabitacion
        left JOIN persona ON hospedaje.idPersona=persona.idPersona
        left JOIN empresa ON empresa.idEmpresa=persona.idEmpresa
        $where group by hotel.idHotel,habitacion.idHabitacion order by habitacion.nHabitacion LIMIT $offset,$per_page");


	
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover table-primary" id="tabla">
							<thead>
                                <tr class="bg-primary">              
                          
                                 <th>Hotel</th>
                                 <th>Habitación</th>
                                 <th>Capacidad</th>
                                 <th>Ocupados</th>
                                 <th>Empresa</th>
                                 <th>Disponibles</th>
                          
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){  
                  $habitacion=$row['idHabitacion'];
                  $capacidad=$row['capacidadReal'];
                  $disponibles=$row['capacidadHabitacion'];
                  $ocupados=$capacidad-$disponibles;

            ?>
				<tr>
        
            <td class="contenidoTabla" align="center"><?php echo utf8_encode($row['nombreHotel']);?></td>
            <td class="contenidoTabla" align="center"><?php echo utf8_encode($row['nHabitacion']);?></td>
            <td class="contenidoTabla" align="center"><?php echo utf8_encode($row['capacidadReal']);?></td>
            
            <td class="contenidoTabla" align="center">
                <?php  
                $ocup = mysqli_query($con,"SELECT hospedaje.idHospedaje,hospedaje.estado,
                COUNT(hospedaje.idHospedaje)AS Cuenta  FROM `hospedaje` WHERE hospedaje.estado = 'A' and hospedaje.idHabitacion = $habitacion");

                while($rowOcup = mysqli_fetch_array($ocup))
                {  
                  
                   $ocupado=$rowOcup['Cuenta'];
                  
                   echo utf8_encode($ocupado);
                }

                ?>               
            </td>

            <td class="contenidoTabla" align="center">
                <?php 
                $empresa = mysqli_query($con,"SELECT 
        
                habitacion.idHabitacion,
                habitacion.idHotel,
                habitacion.nHabitacion,
                habitacion.capacidadHabitacion,
                habitacion.capacidadReal,
                habitacion.estado,
                hotel.idHotel,
                hotel.nombreHotel,
                hotel.capacidadHotel,
                hotel.direccion,
                hospedaje.idHospedaje,
                hospedaje.idPersona,
                hospedaje.idHotel,
                hospedaje.idHabitacion,
                hospedaje.idCama,
                hospedaje.estado,
                persona.idPersona,
                persona.nombresPersona,
                persona.apellidoPersona1,
                persona.rutPersona,
                empresa.idEmpresa,
                empresa.nombreEmpresa,
                cama.idCama,
                cama.idHabitacion,
                cama.nCama,
                cama.estadoCama

                FROM habitacion 
                LEFT JOIN hotel ON habitacion.idHotel=hotel.idHotel
                inner JOIN cama ON cama.idHabitacion=habitacion.idHabitacion
                LEFT JOIN hospedaje ON habitacion.idHabitacion=hospedaje.idHabitacion
                left JOIN persona ON hospedaje.idPersona=persona.idPersona
                left JOIN empresa ON empresa.idEmpresa=persona.idEmpresa
                WHERE habitacion.idHabitacion=$habitacion AND hospedaje.estado='A' AND cama.nCama=1 group by empresa.nombreEmpresa");


                while($rowEmpresa = mysqli_fetch_array($empresa))
                {   
                    if ($row['capacidadHabitacion']==$row['capacidadReal']) 
                        {
                            echo " ";
                        } 
                    else
                        {
                            echo utf8_encode($rowEmpresa['nombreEmpresa']." ");
                        }
                }
                ?>   
            </td>
            
             <td class="contenidoTabla" align="center">

                <?php  
                $disponible = mysqli_query($con,"SELECT hospedaje.idHospedaje,hospedaje.estado,
                COUNT(hospedaje.idHospedaje)AS Cuenta  FROM `hospedaje` WHERE hospedaje.estado = 'A' and hospedaje.idHabitacion = $habitacion");

                while($rowDisponible = mysqli_fetch_array($disponible))
                {  
                  
                   $ocupado=$rowDisponible['Cuenta'];
                   $totalDisponible=$capacidad-$ocupado;
                   echo utf8_encode($totalDisponible);
                }

                ?>
             </td>        

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