<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<?php
   include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
        include 'pagination_camara.php'; //incluir el archivo de paginación

        //las variables de paginación
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
       
$fecha1= Date('3000-01-01');
$fecha2= Date('2000-01-01');



$idPersona = $_REQUEST["idPersona"];
echo $idPersona;
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$idEmpresa = $_REQUEST["idEmpresa"];
/*
echo $id;
echo $idLinea;*/
/*echo $sim;
echo $maquina;*/

$where="";

if ($idPersona!="") {
    $where="where persona.nombresPersona LIKE'%".$idPersona."%'";
  echo "Busca nombres"; 
}

if ($idEmpresa!="") {
    $where="where persona.idEmpresa LIKE'%".$idEmpresa."%'";
  echo "Busca empresa"; 
}

if ($desde!="" && $hasta=="") {
    $where="where entrada.fechaEntrada BETWEEN '".$desde."' AND '".$fecha1."'";
  echo "Busca fechas"; 
}

if ($desde!="" && $hasta!="") {
    $where="where entrada.fechaEntrada BETWEEN '".$desde."' AND '".$hasta."'";
  echo "Busca fechas 2"; 
}


        $count_query1 = mysqli_query($con,"SELECT 
        entrada.idEntrada,
        entrada.idPersona,
        entrada.fechaEntrada,
        entrada.fechaHora,

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

            count(*) AS numrows1 FROM entrada
        INNER JOIN persona ON entrada.idPersona=persona.idPersona
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
             $where");
            if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT 
        entrada.idEntrada,
        entrada.idPersona,
        entrada.fechaEntrada,
        entrada.fechaHora,
        entrada.tipoRegistro,

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
        habitacion.capacidadHabitacion
        FROM entrada 
        INNER JOIN persona ON entrada.idPersona=persona.idPersona
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa  
        
        INNER JOIN hospedaje ON hospedaje.idPersona=entrada.idPersona
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion     
         $where ORDER by idEntrada LIMIT $offset,$per_page");

    
        
        if (mysqli_num_rows($query) > 0){
            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>
                                <tr class="bg-primary">  
                                 <th>Hotel</th>
                                 <th>Hab</th>
                                 <th>Fecha</th>             
                                 <th>Hora</th>
                                 <th>Persona</th>
                                 <th>Empresa</th>
                                 <th>Registro</th>
                    
                                 
                                 
                                                                               
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>    
                       <td class=""><?php echo utf8_encode($row['nombreHotel']);?></td> 
                       <td class=""><?php echo utf8_encode($row['nHabitacion']);?></td>  
                       <td class=""><?php echo utf8_encode($row['fechaEntrada']);?></td>
                       <td class=""><?php echo utf8_encode($row['fechaHora']);?></td>                                        
                       <td class=""><?php echo utf8_encode($row['nombresPersona']." ".$row['apellidoPersona1']);?></td>
                       <td class=""><?php echo utf8_encode($row['nombreEmpresa']);?></td>
                       <td class="">
                            <?php if ($row['tipoRegistro']=="E"): ?>

                            <?php echo '<p class="alert-success"><i class="fa-solid fa-circle-up"> </i> Entrada</p>' ?>      
                            <?php endif ?>
                            <?php if ($row['tipoRegistro']=="S"): ?>
                            <?php echo '<p class="alert-danger"><i class="fa-solid fa-circle-down"></i> Salida</p>' ?>      
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
              <h4>Aviso!!!</h4> No hay datos para mostrar..!
            </div>
            </div>
            <?php

        }
    }
    
?>
