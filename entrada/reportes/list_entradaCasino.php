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
        $per_page = 50; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
       
$fecha1= Date('3000-01-01');
$fecha2= Date('2000-01-01');



$idTrabajador = $_REQUEST["idTrabajador"];
echo $idTrabajador;
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$idHotel = $_REQUEST["idHotel"];
/*
echo $id;
echo $idLinea;*/
/*echo $sim;
echo $maquina;*/

$where="";

if ($idTrabajador!="") {
    $where="where trabajador.nombresTrabajador LIKE'%".$idTrabajador."%'";
  echo "Busca nombres"; 
}

if ($idHotel!="") {
    $where="where trabajador.idHotel LIKE'%".$idHotel."%'";
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

        rcasino.idRcasino,
        rcasino.idPersona,
        rcasino.fechaRegistro,
        rcasino.horaRegistro,
        rcasino.tipoRegistro,
        rcasino.nombrePequipo,
        rcasino.equipo,
        rcasino.cardEquipo,
        persona.card,
        persona.nombresPersona,
        persona.apellidoPersona1,

            count(*) AS numrows1 FROM rcasino
INNER JOIN persona ON rcasino.nombrePequipo=persona.card
             ");
            if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT    

        rcasino.idRcasino,
        rcasino.idPersona,
        rcasino.fechaRegistro,
        rcasino.horaRegistro,
        rcasino.tipoRegistro,
        rcasino.nombrePequipo,
        rcasino.equipo,
        rcasino.cardEquipo,
        persona.card,
        persona.nombresPersona,
        persona.apellidoPersona1

        FROM rcasino 
        INNER JOIN persona ON rcasino.nombrePequipo=persona.card
        ORDER by rcasino.fechaRegistro desc LIMIT $offset,$per_page");    
        
        if (mysqli_num_rows($query) > 0){
            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>
                                <tr class="bg-primary">  
                                 <th>Persona</th>
                                 <th>Tarjeta</th>
                                 <th>Fecha</th> 
                                 <th>Equipo</th>             
                                 <th>Hora</th>
                                 <th>Registro</th>         
                                 
                                 
                                                                               
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>    
                       <td class=""><?php echo utf8_encode($row['nombresPersona']." ".$row['apellidoPersona1']);?></td> 
                       <td class=""><?php echo utf8_encode($row['cardEquipo']);?></td>  
                       <td class=""><?php echo utf8_encode($row['fechaRegistro']);?></td>
                       <td class=""><?php echo utf8_encode($row['equipo']);?></td>                                        
                       <td class=""><?php echo utf8_encode($row['horaRegistro']);?></td>
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
