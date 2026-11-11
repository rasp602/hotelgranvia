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
include '../../bd/conexion.php'; //incluir el archivo de conexion

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include 'pagination_tipoA.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="where trabajador.estado='A'";
$rutTrabajador = $_REQUEST["rutTrabajador"];
$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$genero = $_REQUEST["genero"];
$estado = $_REQUEST["estado"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$idHotel = $_REQUEST["idHotel"];
$fecha1= Date('3000-01-01');
/*
echo "idMaquina:". $idMaquina;
echo "tipoA". $tipoA;  


$fecha2= Date('3000-12-31');

echo "fecha 1:".$fecha1;
echo "fecha 2:".$fecha2;
*/

if ($rutTrabajador!="") {
    $where="where trabajador.estado LIKE 'A' and rutTrabajador LIKE'%".$rutTrabajador."%'";

}

if ($nombreTrabajador!="") {
    $where="where trabajador.estado LIKE 'A' and trabajador.nombreTrabajador LIKE'%".$nombreTrabajador."%' OR trabajador.apellidoTrabajador1 LIKE'%".$nombreTrabajador."%' OR trabajador.rutTrabajador LIKE'%".$nombreTrabajador."%'";

}

if ($idHotel!="") {
    $where="where trabajador.estado LIKE 'A' and hotel.idHotel LIKE'%".$idHotel."%'";

}

if ($rutTrabajador=="" && $genero=="M") {
    $where="where trabajador.genero ='".$genero."'";

}
elseif ($rutTrabajador=="" && $genero=="F") {
    $where="where trabajador.genero ='".$genero."'";

}

if ($desde!="" && $hasta=="") {
    $where="where trabajador.estado LIKE 'A' and fechaIngreso BETWEEN '".$desde."' AND '".$fecha1."'";

}

if ($desde!="" && $hasta!="") {
    $where="where trabajador.estado LIKE 'A' and fechaIngreso BETWEEN '".$desde."' AND '".$hasta."'";

}




      	$count_query1 = mysqli_query($con,"SELECT 

        trabajador.idTrabajador,
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
        trabajador.fechaCreado,
        trabajador.horaCreado,
        trabajador.fotoTrabajador,
        trabajador.qrTrabajador,
        trabajador.idhotel,
        trabajador.estado,
        trabajador.fechaIngreso,
        trabajador.jornada,
        trabajador.labor,
        trabajador.diasTrabajo,
        trabajador.sueldo,

        hotel.idhotel,
        hotel.nombreHotel,
        count(*) AS numrows1 FROM trabajador
       INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel

          $where and trabajador.estado='A'");

    		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
    		$total_pages = ceil($numrows1/$per_page);
    		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

$query = mysqli_query($con,"SELECT 

        trabajador.idTrabajador,
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
        trabajador.fechaCreado,
        trabajador.horaCreado,
        trabajador.fotoTrabajador,
        trabajador.qrTrabajador,
        trabajador.idhotel,
        trabajador.estado,
        trabajador.fechaIngreso,
        trabajador.jornada,
        trabajador.labor,
        trabajador.diasTrabajo,
        trabajador.sueldo,
        hotel.idhotel,
        hotel.nombreHotel


 FROM trabajador 
 INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
 $where and trabajador.estado LIKE 'A' ORDER by hotel.idHotel,trabajador.labor LIMIT $offset,$per_page");

	
		
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>
                                <tr class="bg-primary">              
                                  
                                 <th class="contenidoTabla">R.u.t</th>
                                 <th class="contenidoTabla">Nombre</th>
                                 <th class="contenidoTabla">Apellido P</th>
                                 <th class="contenidoTabla">Apellido M</th> 
                                 <th class="contenidoTabla">Fecha Ingreso</th>
                                  <th class="contenidoTabla">Jornada</th> 
                                <th class="contenidoTabla">Labor</th>
                                                                
                                 <th class="contenidoTabla">Hotel</th>
                                 <th class="contenidoTabla">C.Qr</th>                          
                                 <th>Acciones</th>                              
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){    	 
                
                $newDate = date("d-m-Y", strtotime($row['fechaIngreso']));          
                $newhora = date("g:i a",strtotime($row['horaCreado']));

            ?>
				<tr>

       
            <td class="contenidoTabla"><?php echo utf8_encode($row['rutTrabajador']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombreTrabajador']);?></td>
			<td class="contenidoTabla"><?php echo utf8_encode($row['apellidoTrabajador1']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoTrabajador2']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($newDate);?></td>
                    <td class="contenidoTabla">
                      <?php if ($row['jornada']=="1"):echo "8:00-16:00" ?>
                      <?php endif ?>
                      <?php if ($row['jornada']=="2"):echo "8:00-17:00"?>
                      <?php endif ?>
                      <?php if ($row['jornada']=="3"):echo "14:00-22:00" ?>
                      <?php endif ?>
                      <?php if ($row['jornada']=="4"):echo "00:00-8:00" ?>
                      <?php endif ?>  
                      <?php if ($row['jornada']=="5"): echo "15:00-23:00" ?>
                      <?php endif ?>       
                      <?php if ($row['jornada']=="6"): echo "8:00-18:00" ?>
                      <?php endif ?>        
                      <?php if ($row['jornada']=="7"): echo "8:00-22:00"?>
                      <?php endif ?>         
                      <?php if ($row['jornada']=="8"): echo "22:00-08:00"?>
                      <?php endif ?>   
                      <?php if ($row['jornada']=="9"): echo "06:00-18:00" ?>
                      <?php endif ?>    
                      <?php if ($row['jornada']=="10"):echo "7x7"?>
                      <?php endif ?> 
                      <?php if ($row['jornada']=="11"):echo "2:00-10:00"?>
                      <?php endif ?> 
                      <?php if ($row['jornada']=="12"):echo "08:00-20:00"?>
                      <?php endif ?>
                      <?php if ($row['jornada']=="13"):echo "10:00-22:00"?>
                      <?php endif ?>
                      <?php if ($row['jornada']=="14"):echo "16:00-1:00"?>
                      <?php endif ?>  
                      <?php if ($row['jornada']=="15"):echo "17:00-2:00"?>
                      <?php endif ?>                               
                    </td>  
            <td class="contenidoTabla"><?php echo utf8_encode($row['labor']);?></td>
              <td class="contenidoTabla"><?php echo utf8_encode($row['nombreHotel']);?></td>

              <td class="contenidoTabla"><a href="?c=trabajador&a=crud2&idTrabajador=<?php echo $row['idTrabajador'];?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code" viewBox="0 0 16 16">
  <path d="M2 2h2v2H2V2Z"/>
  <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z"/>
  <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z"/>
  <path d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z"/>
  <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z"/>
</svg></a>

</td>


              <td class="contenidoTabla">
                <a href="?c=trabajador&a=Descanso&idTrabajador=<?php echo $row['idTrabajador']?>" class=""><img src="img/descanso.png" width="30px" height="30px"></a> 

                <a href="?c=trabajador&a=Crud1&idTrabajador=<?php echo $row['idTrabajador']?>" class=""><i class="fa-sharp fa-solid fa-pen-to-square"></i></a> 
                   
                <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=trabajador&a=Eliminar&idTrabajador=<?php echo $row['idTrabajador']?>"><i class="fa-sharp fa-solid fa-trash-can"></i></a>

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