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
$idHotel = $_REQUEST["idHotel"];

if ($idHotel=="") {
  include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
  

}
if ($idHotel==1) {
  include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
  

}

if ($idHotel==2) {
  include '../../bd/conexionLocalh2.php'; //incluir el archivo de conexion
  

}
if ($idHotel==3) {
  include '../../bd/conexionLocalh3.php'; //incluir el archivo de conexion
  

}
if ($idHotel==4) {
  include '../../bd/conexionLocalh4.php'; //incluir el archivo de conexion
  

}
if ($idHotel==5) {
  include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
  

}

if ($idHotel==25) {
  include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
  

}

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include 'pagination_hospedaje.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="";
$descripcion = $_REQUEST["descripcion"];
//$idHotel = $_REQUEST["idHotel"];
$idHabitacion = $_REQUEST["idHabitacion"];
$idCama = $_REQUEST["idCama"];
$estado = $_REQUEST["estado"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$idEmpresa = $_REQUEST["idEmpresa"];
$fecha1= Date('3000-01-01');

$fechaActual=date("Y-m-d");
/*
echo "idMaquina:". $idMaquina;
echo "tipoA". $tipoA;  


$fecha2= Date('3000-12-31');

echo "fecha 1:".$fecha1;
echo "fecha 2:".$fecha2;
*/  


$where = "WHERE 1=1"; // Condición base


/*
// Condición de descripción para búsqueda por nombre o apellido
if ($descripcion != "") {
    list($nombre, $apellido) = explode(" ", $descripcion);
    $where .= " AND (persona.rutPersona LIKE '%$descripcion%' 
                OR persona.nombresPersona LIKE '%$nombre%' 
                OR apellidoPersona1 LIKE '%$apellido%' 
                OR CONCAT(persona.nombresPersona, ' ', apellidoPersona1) LIKE '%$descripcion%')";
}

// Condiciones opcionales según los valores de las variables
if ($idHotel != "") {
    $where .= " AND hotel.idHotel = '$idHotel'";
}
if ($idEmpresa != "") {
    $where .= " AND persona.idEmpresa = '$idEmpresa'";
}
if ($idHabitacion != "") {
    $where .= " AND habitacion.idHabitacion = '$idHabitacion'";
}
if ($idCama != "") {
    $where .= " AND cama.idCama = '$idCama'";
}
if ($estado != "") {
    $where .= " AND hospedaje.estado = '$estado'";
}
if ($desde != "" && $hasta != "") {
    $where .= " AND hospedaje.desde BETWEEN '$desde' AND '$hasta'";
}*/



if ($descripcion!="") {

     $where="where persona.nombresPersona LIKE'%".$nombre."%' and apellidoPersona1 LIKE'%".$apellido."%' OR persona.rutPersona LIKE'%".$descripcion."%' OR apellidoPersona1 LIKE'%".$descripcion."%'";
   // echo "1.-Busca  por descripcion"; 
}

if ($idHotel!=""  && $idEmpresa!="" && $idHabitacion==""&& $idCama=="") {
    $where="where hotel.idHotel ='".$idHotel."'";
    // echo "2.-Busca Hotel,empresa "; 

  }

if ($idHotel!="" && $idHabitacion!=""&& $idCama=="" && $idEmpresa!="") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' ";
    // echo "3.-Busca Hotel,Habitacion y empresa "; 

  }

 
  if ($idHotel!="" && $idHabitacion!="" && $idCama!="" && $idEmpresa!="" && $estado=="") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' AND cama.idCama ='".$idCama."' and persona.idEmpresa ='".$idEmpresa."' ";
//echo "7.-Busca hotel, habitacion,Cama y empresa"; 
}

  if ($idHotel!="" && $idHabitacion!="" && $idCama!="" && $idEmpresa!="" && $estado!="") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' AND cama.idCama ='".$idCama."' and persona.idEmpresa ='".$idEmpresa."' and hospedaje.estado ='$estado'";
  //echo "8.-.-Busca hotel, habitacion,Cama,empresa y estado"; 
}

   if ($idHotel!="" && $idEmpresa!=""  && $estado!="") {
    $where="where hotel.idHotel ='".$idHotel."' and hospedaje.estado ='$estado' and persona.idEmpresa ='".$idEmpresa."'";
  //echo "9.-Busca hotel ,empresa y  Estado"; 
}



   /******************************************************************************************************* */
/*


  
    if ($idHotel!="" && $idHabitacion!="" && $idEmpresa!="" && $estado==!"") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' and persona.idEmpresa ='".$idEmpresa."' and hospedaje.estado ='$estado'";
     //echo "Busca Habitacion sola"; 

  }

    if ($idHotel!="" && $idHabitacion!="" && $idEmpresa="" && $estado==!"") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' and hospedaje.estado ='$estado'";
     //echo "Busca prueba"; 

  }



if ($idHotel!="" && $idEmpresa!="" && $estado=="" && $desde=="" && $hasta=="") {
    $where="where persona.idEmpresa ='".$idEmpresa."' and hotel.idHotel ='".$idHotel."' ";
 // echo "Busca Empresa con hotel"; 
}

if ($idHotel=="" && $idEmpresa!="" && $estado=="" && $desde=="" && $hasta=="") {
    $where="where persona.idEmpresa ='".$idEmpresa."' ";
 // echo "Busca Empresa sin hotel"; 
}

if ($idHotel!="" && $estado!="" && $idEmpresa=="") {
    $where="where hospedaje.estado ='$estado' and hotel.idHotel ='".$idHotel."'";
 // echo "Busca Estado con hotel"; 
}



if ($idHotel=="" && $idEmpresa!="" && $estado!="") {
    $where="where persona.idEmpresa ='".$idEmpresa."' and hospedaje.estado ='".$estado."'";
  //  echo "Busca empresa y estado sin hotel"; 
}

if ($idHotel!="" && $idEmpresa!="" && $estado!="") {
    $where="where persona.idEmpresa ='".$idEmpresa."' and hospedaje.estado ='".$estado."' and hotel.idHotel ='".$idHotel."'";
  //  echo "Busca empresa y estado con hotel"; 
}


if ($idHotel=="" && $desde!="" && $hasta!="" && $idEmpresa!="") {
    $where="where hospedaje.desde BETWEEN '".$desde."' AND '".$hasta."' and persona.idEmpresa ='".$idEmpresa."'";
 // echo "Busca fechas2 y empresa sin hotel";
}


if ($idHotel!="" && $desde!="" && $hasta!="" && $idEmpresa!="") {
    $where="where hospedaje.desde BETWEEN '".$desde."' AND '".$hasta."' and persona.idEmpresa ='".$idEmpresa."' and hotel.idHotel ='".$idHotel."'";
 // echo "Busca fechas2 y empresa con hotel";
}




if ($idHotel=="" && $desde!="" && $hasta!="" && $idEmpresa=="" && $estado=="" ) {
    $where="where desde BETWEEN '".$desde."' AND '".$hasta."'";
  //echo "Busca fechas2 sin hotel";
}


if ($idHotel!="" && $desde!="" && $hasta!="" && $idEmpresa=="" && $estado=="" ) {
    $where="where desde BETWEEN '".$desde."' AND '".$hasta."' and hotel.idHotel ='".$idHotel."'";
 // echo "Busca fechas2 con hotel";
}

*/


// Consulta final usando el WHERE construido
$count_query1 = mysqli_query($con, "SELECT 
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
        persona.idContrato,
          persona.idEmpresa,

        empresa.idEmpresa,
        empresa.nombreEmpresa,

        count(*) AS numrows1 
    FROM hospedaje 
    INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
    INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
    INNER JOIN cama ON hospedaje.idCama=cama.idCama 
    INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
    INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa 
    $where AND persona.idEmpresa= 26");


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
        hospedaje.fechaDespedida,
        hospedaje.horaDespedida,

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
        persona.idContrato,

        empresa.idEmpresa,
        empresa.nombreEmpresa

        FROM hospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa 
      
        $where AND persona.idEmpresa= 26 ORDER by habitacion.nHabitacion asc LIMIT $offset,$per_page");


	
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>
                                <tr class="bg-primary">              
                               
                                 <th>Hotel</th>
                                 <th>Habitación</th> 
                                 <th>Cama</th>                                
                                 <th>Apelldio Paterno</th>
                                 <th>Apellido Materno</th>
                                 <th>Nombre</th>
                                 <th>R.u.t</th>                                 
                                 <th>Empresa</th> 
                                 <th>Contrato</th>
                                 <th>Fecha entrada</th>
                                 <th>Salida estimada</th>
                                 <th>Fecha salida</th>
                                 <th>Hora salida</th>
                                 <th>Estado</th>
                                                           
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){  
                           ?>
				<tr>         
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombreHotel']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nHabitacion']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nCama']);?></td>            
            <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoPersona1']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['apellidoPersona2']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombresPersona']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['rutPersona']);?></td>			
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombreEmpresa']);?></td>
            <td class="contenidoTabla">         

            <?php 
              $idContrato=$row['idContrato'];
              $queryContrato = mysqli_query($con,"SELECT * FROM contrato                    
              where idContrato = $idContrato");		            
                while($rowContrato = mysqli_fetch_array($queryContrato))
                    {      
                        $nombreContrato=$rowContrato['nombreContrato'];                     
                        if ($rowContrato['nombreContrato']=="null"):
                        echo "Pendiente"  ;  
                         endif           ;        
                        if ($rowContrato['nombreContrato']!=""):
                          echo $nombreContrato;
                        endif;

                    }                    
                ?>         
          
          </td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['desde']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['hasta']);?></td>
            <td class="contenidoTabla">    
                             <?php if ($row['fechaDespedida']==""): ?>
                            <?php echo '<p class="alert-success">Pendiente</p>' ?>      
                            <?php endif ?>                    
                            <?php if ($row['fechaDespedida']=="0000-00-00"): ?>
                            <?php echo '<p class="alert-success">Pendiente</p>' ?>      
                            <?php endif ?>
                            <?php if ($row['fechaDespedida']!="0000-00-00"): ?>
                            <?php echo utf8_encode($row['fechaDespedida']);?>
                            <?php endif ?>
          
          
          </td>
            <td class="contenidoTabla">
                            <?php if ($row['horaDespedida']==""): ?>
                            <?php echo '<p class="alert-success">Pendiente</p>' ?>      
                            <?php endif ?>                    
                            <?php if ($row['horaDespedida']=="00:00:00"): ?>
                            <?php echo '<p class="alert-success">Pendiente</p>' ?>      
                            <?php endif ?>
                            <?php if ($row['horaDespedida']!="00:00:00"): ?>
                            <?php echo utf8_encode($row['horaDespedida']);?>
                            <?php endif ?>

            </td>
                            
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