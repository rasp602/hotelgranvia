

<?php
	
include '../../bd/conexion.php'; //incluir el archivo de conexion


	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include 'pagination_descripcion.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		$query = mysqli_query($con,"SELECT 
			usuario.id_user,
            usuario.email,
            usuario.password,
            usuario.nivel,
            usuario.idUsuario,
            
            tblusuario.idUsuario,
            tblusuario.rut,
            tblusuario.nombre,
            tblusuario.apellido,
            tblusuario.fechacrea,
            tblusuario.genero


            
		FROM usuario
        INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario");

		//ID QUE TRAE LA id
		$id = $_REQUEST["nombre"];		
		$count_query1 = mysqli_query($con,"SELECT 
			usuario.id_user,
            usuario.email,
            usuario.password,
            usuario.nivel,
            usuario.idUsuario,
            
            tblusuario.idUsuario,
            tblusuario.rut,
            tblusuario.nombre,
            tblusuario.apellido,
            tblusuario.fechacrea,
            tblusuario.genero,

      
		count(*) AS numrows1 FROM usuario
        INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario
		WHERE tblusuario.nombre LIKE '%".$id."%'");
		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
		$total_pages = ceil($numrows1/$per_page);
		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

		$query = mysqli_query($con,"SELECT 
			usuario.id_user,
            usuario.email,
            usuario.password,
            usuario.nivel,
            usuario.idUsuario,
            
            tblusuario.idUsuario,
            tblusuario.rut,
            tblusuario.nombre,
            tblusuario.apellido,
            tblusuario.fechacrea,
            tblusuario.genero

            
            
		FROM usuario
        INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario
		WHERE tblusuario.nombre LIKE '%".$id."%' ORDER BY usuario.idUsuario LIMIT $offset,$per_page");

	
		
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>

                                <tr class="bg-primary">
                                <th>Rut</th>  
                                <th>Nombre de usuario</th>     
                                <th>Fecha Registro</th>  
                                <th>Genero</th>  
                                <th>Correo</th>
                                <th>Nivel</th>       
                                </tr>
                            </thead>
			<tbody><br>
			<?php
			while($row = mysqli_fetch_array($query)){
		$originalDate = $row['fechacrea'];
        $newDate = date("d-m-Y", strtotime($originalDate));
				?>
				<tr>
					<td class="tablaContenido"><?php echo $row['rut'];?></td>
					<td class="tablaContenido"><?php echo utf8_encode($row['nombre']); echo utf8_encode("\n".$row['apellido'])?></td>
					<td class="tablaContenido"><?php echo $newDate;?></td>
					<td class="tablaContenido"><?php echo $row['genero'];?></td>
					<td class="tablaContenido"><?php echo $row['email'];?></td>
					<td class="tablaContenido"><?php echo $row['nivel'];?></td>
							

					 
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
			<div class="container">
			<div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
			</div>
            </div>
			<?php

		}
	}
?>
