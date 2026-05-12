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
		include 'pagination_persona.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="";
$rutPersona = $_REQUEST["rutPersona"];
$nombresPersona = $_REQUEST["nombresPersona"];
$genero = $_REQUEST["genero"];
$estado = $_REQUEST["estado"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$idEmpresa = $_REQUEST["idEmpresa"];
$fecha1= Date('3000-01-01');
/*
echo "idMaquina:". $idMaquina;
echo "tipoA". $tipoA;  


$fecha2= Date('3000-12-31');

echo "fecha 1:".$fecha1;
echo "fecha 2:".$fecha2;
*/

if ($rutPersona!="") {
    $where="where persona.rutPersona LIKE'%".$rutPersona."%'";
 // echo "Busca Rut"; 
}
list($nombre, $apellido) = explode(" ", $nombresPersona);
if ($nombresPersona!="") {
       $where="where persona.nombresPersona LIKE'%".$nombre."%' and apellidoPersona1 LIKE'%".$apellido."%'";
 // echo "Busca nombre y apellido"; 
}

if ($genero!="" && $rutPersona=="" && $idEmpresa=="" ) {
    $where="where genero ='".$genero."'";
  //echo "Busca genero solo"; 
}


if ($desde!="" && $hasta=="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$fecha1."'";
  //echo "Busca fechas"; 
}

if ($desde!="" && $hasta!="" && $rutPersona=="" && $nombresPersona=="" && $idEmpresa=="" && $genero=="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."'";
 // echo "Busca fechas"; 
}

if ($desde!="" && $hasta!="" && $genero!="" && $idEmpresa!="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."' AND genero ='".$genero."' AND empresa.idEmpresa = '".$idEmpresa."'";
 // echo "Busca fechas con genero y empresa"; 
}

if ($desde!="" && $hasta!="" && $genero!="" && $idEmpresa=="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."' AND genero ='".$genero."'";
  //echo "Busca fechas con genero"; 
}

if ($desde!="" && $hasta!="" && $idEmpresa!="" ) {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."' AND persona.idEmpresa = '".$idEmpresa."'";
 // echo "Busca fechas con empresa"; 
}

if ($idEmpresa!=""  && $genero==""&& $desde=="" && $hasta=="") {
    $where="where persona.idEmpresa = '".$idEmpresa."'";
 // echo "Busca eMPRESA"; 
}

if ($idEmpresa!="" && $genero!="" && $desde=="" && $hasta=="") {
    $where="where persona.idEmpresa = '".$idEmpresa."' and persona.genero ='".$genero."'";
// echo "Busca empresa y genero"; 
}  


      	$count_query1 = mysqli_query($con,"SELECT  

        persona.idPersona,
        persona.rutPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.genero,
        persona.fechaCreado,
        persona.horaCreado,
        persona.fotoPersona,
        persona.qrPersona,
        persona.idEmpresa,

        empresa.idEmpresa,
        empresa.nombreEmpresa,
        count(*) AS numrows1 FROM persona
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
         	$where");

    		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
    		$total_pages = ceil($numrows1/$per_page);
    		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

$query = mysqli_query($con,"SELECT 

persona.idPersona,
persona.rutPersona,
persona.nombresPersona,
persona.apellidoPersona1,
persona.apellidoPersona2,
persona.genero,
persona.fechaCreado,
persona.horaCreado,
persona.fotoPersona,
persona.qrPersona,
persona.idEmpresa,
persona.idContrato,

empresa.idEmpresa,
empresa.nombreEmpresa,
contrato.idContrato,
contrato.nombreContrato,
contrato.idEmpresa

FROM persona 
INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
LEFT JOIN contrato ON persona.idContrato=contrato.idContrato
 $where ORDER by persona.idPersona LIMIT $offset,$per_page");

	
		
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>
                                <tr class="bg-primary">              
                                 
                                 <th>Rut</th>
                                 <th>Nombres</th>
                                 <th>Apellido P</th>
                                 <th>Apellido M</th> 
                                 <th>Fecha Creado</th>
                                 <th>Hora Creado</th>
                                 <th>Genero</th>
                                 <th>Empresa</th>
                                 <th>Contrato</th>
                                 <th>Qr</th>
                                                          
                                 <th>Acciones</th>                              
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){    	 
                
                $newDate = date("d-m-Y", strtotime($row['fechaCreado']));          
                $newhora = date("g:i a",strtotime($row['horaCreado']));

            ?>
				<tr>

     
            <td class="contenidoTabla"><?php echo utf8_encode($row['rutPersona']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombresPersona']);?></td>
			<td class="contenidoTabla"><?php echo utf8_encode($row['apellidoPersona1']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoPersona2']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($newDate);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($newhora);?></td> 	                    
                    <td class="contenidoTabla">
                      <?php if ($row['genero']=="M"): ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-male" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2H9.5zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                    </svg>
                      <?php endif ?>
                      <?php if ($row['genero']=="F"): ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-female" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                    </svg>
                      <?php endif ?>
                    </td>            
            

              <td class="contenidoTabla"><?php echo utf8_encode($row['nombreEmpresa']);?></td>
              <td class="contenidoTabla"><?php echo utf8_encode($row['nombreContrato']);?></td>

              <td class="contenidoTabla"><?php echo utf8_encode($row['qrPersona']);?></td>
              <td><a href="?c=persona&a=Crud1&idPersona=<?php echo $row['idPersona']?>" class="glyphicon glyphicon-pencil"></a> 

                <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=persona&a=Eliminar&idPersona=<?php echo $row['idPersona']?>" class="glyphicon glyphicon-remove"></a></td>
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