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
		include 'pagination_empresa.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="";
$nombreEmpresa = $_REQUEST["nombreEmpresa"];
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

if ($nombreEmpresa!="") {
    $where="where nombreEmpresa LIKE'%".$nombreEmpresa."%'";
  echo "Busca empresa"; 
}


      	$count_query1 = mysqli_query($con,"SELECT count(*) AS numrows1 FROM empresa	$where");

    		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
    		$total_pages = ceil($numrows1/$per_page);
    		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

$query = mysqli_query($con,"SELECT * FROM empresa $where
ORDER by idEmpresa LIMIT $offset,$per_page");

	
		
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>
                                <tr class="bg-primary">              
                                 <th>#</th>
                                 <th>Rut</th>  
                                 <th>Nombre Empresa</th>
                                 <th>Valor Simple</th>
                                 <th>Valor Doble</th>
                                 <th>Hora de Salida</th>
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

            <td class="contenidoTabla"><?php echo utf8_encode($row['idEmpresa']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['rutEmpresa']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombreEmpresa']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['ContratoEmpresa']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['contratoEmpresa1']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['horaSalida']);?></td>
                
            <td><a href="?c=empresa&a=Crud1&idEmpresa=<?php echo $row['idEmpresa']?>" class="glyphicon glyphicon-pencil"></a> 


            	<!--<a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=empresa&a=Eliminar&idEmpresa=<?php echo $row['idEmpresa']?>" class="glyphicon glyphicon-remove"></a>-->


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