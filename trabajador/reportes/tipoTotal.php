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
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="where usuario.id_user = '".$usuario."'";
$tipoA = $_REQUEST["tipoA"];
$idLinea = $_REQUEST["idLineaA"];
$estado = $_REQUEST["estado"];
$descripcion = $_REQUEST["descripcion"];
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];
$idMaquina = $_REQUEST["idMaquina"];




if ($idMaquina!=112) {
    $where="where maquina.idMaquina='".$idMaquina."' AND usuario.id_user = '".$usuario."'";
  echo "if MAQUINA (1) listo"; 
}






		$count_query1 = mysqli_query($con,"SELECT 
			actividad.idActividad,
            actividad.descripcion,
            actividad.tipoA,
            actividad.idMaquina,
            actividad.fechaA,
            actividad.horaA,
            actividad.id_user,
            actividad.statusA,
            actividad.imagen,
            actividad.imagen2,

            maquina.idMaquina,
            maquina.nMaquina,
            maquina.idLinea,
            maquina.patente,

            linea.idLinea,
            linea.nLinea,
            
            usuario.id_user,
            usuario.email,
            usuario.password,
            usuario.nivel,
            usuario.idUsuario,

            tblusuario.idUsuario,
            tblusuario.rut,
            tblusuario.nombre,
            tblusuario.apellido,
            tblusuario.fechaCrea,
            tblusuario.genero,
		          count(actividad.idActividad) AS numrows1 FROM actividad
            INNER JOIN maquina ON maquina.idMaquina=actividad.idMaquina  
            INNER JOIN linea ON linea.idLinea=maquina.idLinea
            INNER JOIN usuario ON actividad.id_user=usuario.id_user
            INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario
    		$where");
    		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
    		$total_pages = ceil($numrows1/$per_page);
    		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

		$query = mysqli_query($con,"SELECT 
     		actividad.idActividad,
            actividad.descripcion,
            actividad.tipoA,
            actividad.idMaquina,
            actividad.fechaA,
            actividad.horaA,
            actividad.id_user,
            actividad.statusA,
            actividad.imagen,
            actividad.imagen2,

            maquina.idMaquina,
            maquina.nMaquina,
            maquina.idLinea,
            maquina.patente,

            linea.idLinea,
            linea.nLinea,
             usuario.id_user,
            usuario.email,
            usuario.password,
            usuario.nivel,
            usuario.idUsuario,

            tblusuario.idUsuario,
            tblusuario.rut,
            tblusuario.nombre,
            tblusuario.apellido,
            tblusuario.fechaCrea,
            tblusuario.genero
               count(actividad.idActividad) AS numrows2 FROM actividad
		    FROM actividad
		    INNER JOIN maquina ON maquina.idMaquina=actividad.idMaquina  
            INNER JOIN linea ON linea.idLinea=maquina.idLinea
            INNER JOIN usuario ON actividad.id_user=usuario.id_user
            INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario
		        $where ORDER by actividad.fechaA LIMIT $offset,$per_page");

	       if ($row= mysqli_fetch_array($count_query1)){$numrows2 = $row['numrows2'];}
		
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>

                                <tr class="bg-primary">                                
                                 <th>Fecha</th>  
                                 <th>Linea</th>
          
                                 
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){    	 
            

            ?>
				<tr>

				
            <td class="contenidoTabla"><?php echo utf8_encode($row['nMaquina']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($numrows2);?></td>
					
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