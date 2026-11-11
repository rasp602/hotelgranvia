<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<?php
   include '../../bd/conexion.php'; //incluir el archivo de conexion
    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
        include 'pagination_camara.php'; //incluir el archivo de paginación

        //las variables de paginación
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
       

$where="";


$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$idHotel = $_REQUEST["idHotel"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');
/*
echo $id;
echo $idLinea;*/
/*echo $sim;
echo $maquina;*/



if ($nombreTrabajador!="") {
    $where="where trabajador.nombreTrabajador LIKE'%".$nombreTrabajador."%'";
  echo "Busca trabajador"; 
}

if ($idHotel!="") {
    $where="where trabajador.idHotel LIKE'%".$idHotel."%'";
  echo "Busca Hotel"; 
}


if ($desde!="" && $hasta=="") {
    $where="where fechaSalidaT BETWEEN '".$desde."' AND '".$fecha1."'";
  echo "Busca fechas"; 
}

if ($desde!="" && $hasta!="") {
    $where="where fechaSalidaT BETWEEN '".$desde."' AND '".$hasta."'";
  echo "Busca fechas 2"; 
}


        $count_query1 = mysqli_query($con,"SELECT 
        salidat.idSalidaT,
        salidat.idTrabajador,
        salidat.fechaSalidaT,
        salidat.horaSalida,

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
        trabajador.idHotel,
            count(*) AS numrows1 FROM salidat
        INNER JOIN trabajador ON salidat.idTrabajador=trabajador.idTrabajador
             $where");
            if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT 
        salidat.idSalidaT,
        salidat.idTrabajador,
        salidat.fechaSalidaT,
        salidat.horaSalida,

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
        trabajador.idHotel,
        hotel.idHotel,
        hotel.nombreHotel
      
        FROM salidat
        INNER JOIN trabajador ON salidat.idTrabajador=trabajador.idTrabajador
        INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
        $where ORDER by salidat.idSalidaT LIMIT $offset,$per_page");

    
        
        if (mysqli_num_rows($query) > 0){
            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>
                                <tr class="bg-primary"> 
                                <th>Trabajador</th>
                                <th>Hotel</th>              
                                 <th>Fecha Salida</th>
                                 <th>Hora Salida</th>  
                                  
                                                  
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>      
                       <td class=""><?php echo utf8_encode($row['nombreTrabajador']." ".$row['apellidoTrabajador1']);?></td>

                       <td class=""><?php echo utf8_encode($row['nombreHotel']);?></td>
                       <td class=""><?php echo utf8_encode($row['fechaSalidaT']);?></td>
                       <td class=""><?php echo utf8_encode($row['horaSalida']);?></td>
                    
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
