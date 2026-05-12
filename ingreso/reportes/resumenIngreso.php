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
$where="where trabajador.estado LIKE 'A' and entradat.Fecha BETWEEN '".$fecha."' AND '".$fecha."'";

if ($nombreTrabajador!="") {
    $where="where trabajador.estado LIKE 'A' and trabajador.nombreTrabajador LIKE'%".$nombreTrabajador."%'";
 
}

if ($idHotel!="") {
    $where="where trabajador.estado LIKE 'A' and trabajador.idHotel LIKE'%".$idHotel."%'";
 
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

if ($idHotel!="" && $desde!="" && $hasta!="") {
    $where="where trabajador.estado LIKE 'A' and trabajador.idHotel LIKE'%".$idHotel."%' and entradat.Fecha BETWEEN '".$desde."' AND '".$hasta."'";
  
}


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
        IF(entradat.fechaEntradaT>0, 'SI', 'NO') as pregunta,
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
        group by trabajador.idTrabajador
       
        
         LIMIT $offset,$per_page");

    
        
        if (mysqli_num_rows($query) > 0){
                   $fecha2=array(); 
                while($row = mysqli_fetch_array($query)){    
        

           $fecha2[]= $row['Fecha'];
             $trabajador[]= $row['idTrabajador'];
              $pre[]= $row['pregunta'];
            
            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>                   
                                  
                                   <tr class='bg-primary'>

                                  <?php   while($row = mysqli_fetch_array($query)){
                                     

                                     echo "<th>" . $row['Fecha'] . "</th> ";
                                

                                  } ?>
                                

</tr>
                                                                                                                 
                               
                            </thead>
            <tbody>
                <br>
            <?php

                while($row = mysqli_fetch_array($query)){  
            
                  
                      ?>
                <tr>          
                    <td class="contenidoTabla"><?php echo utf8_encode($row['idTrabajador']);?></td>
                      
          


                </tr>
            <?php
            }
 }


            ?>
            </tbody>
        </table>
        </div>












        <?php echo "<div align='center'> <b>Total de Registros encontrados :</b>"; echo"&nbsp".$numrows1 ; echo "</div>"; ?>

            </div>


                <br>
                 <div class="row">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover" id="tabla1">
                            <thead>
                                <tr class="bg-primary"> 
                                <th class="contenidoTabla">Horas Trabajadas</th>
                                <th class="contenidoTabla">Horas Extras</th>       
                                </tr>
                            </thead>
                    <tbody>
     
                       <td class="contenidoTabla"><?php echo utf8_encode($horasTrabajadas);?></td>
                       <td class="contenidoTabla"><?php echo utf8_encode($Extras);?></td>

 
                    </tbody>
                </table>
            </div>
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
