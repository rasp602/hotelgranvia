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
        $per_page = 30; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
        
$fecha = date('Y-m-d');   



$idUsuario = $_REQUEST["idUsuario"];
$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$idHotel = $_REQUEST["idHotel"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');
$fecha2= Date('2023-01-01');
/*
echo $id;
echo $idLinea;*/
/*echo $sim;
echo $maquina;*/


      $trabajador = mysqli_query($con,"SELECT 
        trabajador.idTrabajador,
        usuario.id_user,
        usuario.idTrabajador

        FROM usuario  
        INNER JOIN trabajador ON usuario.idTrabajador=trabajador.idTrabajador
        where usuario.id_user='".$idUsuario."'");
            
            if ($row1= mysqli_fetch_array($trabajador))
                {
                    $idTrabajador = $row1['idTrabajador'];                    


                }



$where="where trabajador.idTrabajador = $idTrabajador and entradat.Fecha BETWEEN '".$fecha2."' AND '".$fecha."'";

/*if ($nombreTrabajador!="") {
    $where="where trabajador.estado LIKE 'A' and trabajador.nombreTrabajador LIKE'%".$nombreTrabajador."%'";
 
}


if ($desde!="" && $hasta=="") {
    $where="where trabajador.estado LIKE 'A' and entradat.Fecha BETWEEN '".$desde."' AND '".$fecha1."'";

}

if ($desde!="" && $hasta!="") {
    $where="where trabajador.estado LIKE 'A' and entradat.Fecha BETWEEN '".$desde."' AND '".$hasta."'";
  
}
if ($nombreTrabajador!="" && $desde!="" && $hasta!="") {
    $where="where trabajador.estado LIKE 'A' and trabajador.nombreTrabajador LIKE'%".$nombreTrabajador."%' and entradat.Fecha BETWEEN '".$desde."' AND '".$hasta."'";

}

*/



      $contarExtras = mysqli_query($con,"SELECT 
        entradat.idEntradaT,
        entradat.Fecha,
        entradat.idTrabajador,
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,
        entradat.validacion,


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
        trabajador.condicion,
        hotel.idHotel,
        hotel.nombreHotel,
  
            sum(horasExtras) AS Extras
            FROM entradat
  
        right JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
         inner JOIN hotel ON trabajador.idHotel=hotel.idHotel
             $where and entradat.validacion='0'");
            if ($row= mysqli_fetch_array($contarExtras))
                {
                    $Extras = $row['Extras'];
                    

                }


      $contarTrabajadas = mysqli_query($con,"SELECT 
        entradat.idEntradaT,
        entradat.Fecha,
        entradat.idTrabajador,
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,
        entradat.validacion,


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
        trabajador.condicion,
        hotel.idHotel,
        hotel.nombreHotel,
  
        sum(horasTrabajadas) AS horasTrabajadas FROM entradat
  
        right JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
         inner JOIN hotel ON trabajador.idHotel=hotel.idHotel
             $where");
            if ($row= mysqli_fetch_array($contarTrabajadas))
                {
                   
                    $horasTrabajadas = $row['horasTrabajadas'];

                }


        $count_query1 = mysqli_query($con,"SELECT 
        entradat.idEntradaT,
        entradat.Fecha,
        entradat.idTrabajador,
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,
        entradat.validacion,


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
        trabajador.jornada,
        trabajador.idHotel,
        trabajador.condicion,
        hotel.idHotel,
        hotel.nombreHotel,
  
            count(*) AS numrows1 FROM entradat
  
        right JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
         inner JOIN hotel ON trabajador.idHotel=hotel.idHotel
             $where");
            if ($row= mysqli_fetch_array($count_query1))
                {$numrows1 = $row['numrows1'];}

            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT 
        entradat.idEntradaT,
        entradat.Fecha,
        entradat.idTrabajador,
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,
        entradat.validacion,

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
        trabajador.jornada,
        trabajador.labor,
        trabajador.condicion,
        hotel.idHotel,
        hotel.nombreHotel      
        FROM entradat
        right JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
        inner JOIN hotel ON trabajador.idHotel=hotel.idHotel
        $where ORDER by entradat.fechaEntradaT DESC LIMIT $offset,$per_page");

    
        
        if (mysqli_num_rows($query) > 0){
            ?>
        <div class="container-fluid">

            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>
                                 <tr class="bg-primary"> 

                                 <th class="contenidoTabla">Jornada</th>              
                                 <th class="contenidoTabla">Fecha</th>
                                 <th class="contenidoTabla">Hora Entrada</th>
                                 <th class="contenidoTabla">Hora Salida</th>
                                                                                                              
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>      
    


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
                       <td class="contenidoTabla"><?php echo utf8_encode($row['Fecha']);?></td>
                       <td class="contenidoTabla">
                            
                            <?php if ($row['horaEntrada']=="00:00:00"|| $row['horaSalida']=="null"): ?>
                            <?php echo '<p class="alert-success">Pendiente</p>' ?>      
                            <?php endif ?>
                            <?php if ($row['horaEntrada']!="00:00:00"): ?>
                            <?php echo utf8_encode($row['horaEntrada']);?>
                            <?php endif ?>

                       </td>
                       



                       <td class="contenidoTabla">
                            <?php if ($row['horaSalida']=="00:00:00"): ?>
                            <?php echo '<p class="alert-danger">Pendiente</p>' ?>      
                            <?php endif ?>
                            <?php if ($row['horaSalida']!="00:00:00"): ?>
                            <?php echo utf8_encode($row['horaSalida']);?>
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


                <br>

    



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
