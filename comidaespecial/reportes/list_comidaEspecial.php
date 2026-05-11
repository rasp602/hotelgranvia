<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<?php
 
    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
        include 'pagination_comidasEspecial.php'; //incluir el archivo de paginación

        //las variables de paginación
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 20; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
       


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

$idHabitacion = $_REQUEST["idHabitacion"];
$tipoComida = $_REQUEST["tipoComida"];
$idPersona = $_REQUEST["idPersona"];
$idEmpresa = $_REQUEST["idEmpresa"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('yyyy-mm-dd');
$fecha3= Date('2023-01-01');
$fecha2= Date('2030-01-01');
/*
echo $id;
echo $idLinea;*/
/*echo $sim;
echo $maquina;*/
$where="";


if ($idPersona!="") {
    $where="where persona.nombresPersona LIKE'%".$idPersona."%'";
    
 // echo "1.- Busca nombre solo"; 
}
list($nombre, $apellido) = explode(" ", $idPersona);
if ($idPersona!="") {
    $where="where persona.nombresPersona LIKE'%".$nombre."%' and apellidoPersona1 LIKE'%".$apellido."%'";
    
 //echo "1.1- Busca nombre con apellido "; 
}



if ($idEmpresa!="" ) {
    $where="where empresa.idEmpresa = '".$idEmpresa."' ";
    
  //echo "3.- Busca empresa sola"; 
}


if ($tipoComida!="" ) {
    $where="where comidaespecial.tipoComida LIKE'%".$tipoComida."%'";
  //echo "4.- Busca tipo COMIDA con fechas"; 
}

if ($desde!="") {
    $where="where comidaespecial.fechaComida BETWEEN '".$desde."' AND '".$fecha2."'";
    
  //echo "5.- Busca fecha desde sola"; 
}
if ($idPersona!=""  && $desde!="" && $hasta!="") {
  $where="where persona.nombresPersona LIKE'%".$nombre."%' and apellidoPersona1 LIKE'%".$apellido."%' and comidaespecial.fechaComida BETWEEN '".$desde."' AND '".$hasta."' ";
  
//echo "Busca nombre con fechas"; 
}

if ($tipoComida!="" && $desde!="" && $hasta!="") {
    $where="where comidaespecial.tipoComida LIKE'%".$tipoComida."%' and comidaespecial.fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
  //echo "7.- Busca tipo COMIDA con fechas"; 
}


if ($desde!="" && $hasta!="") {
    $where="where comidaespecial.fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
    
  //echo "8.- Busca hotel con fechas"; 
}


if ($idEmpresa!="" && $desde!="" && $hasta!="") {
    $where="where empresa.idEmpresa = '".$idEmpresa."' and comidaespecial.fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
    
  //echo "11.- Busca empresa con fechas sola"; 
}

if ($idEmpresa!="" &&$tipoComida!="" && $desde!="" && $hasta!="") {
    $where="where comidaespecial.tipoComida LIKE'%".$tipoComida."%' and empresa.idEmpresa = '".$idEmpresa."' and comidaespecial.fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
  //echo "11.- Busca empresa con tipo de comida y fechas"; 
}




/*
        $count_query1 = mysqli_query($con,"SELECT 

        comida.idComida,
        comida.idPersona,
        comida.tipoComida,
        comida.fechaComida,
        comida.horaComida,

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
        hospedaje.idHabitacion,
        hospedaje.idPersona,
        hospedaje.idHotel,

        hotel.idHotel,
        hotel.nombreHotel,
        
        habitacion.idHabitacion,
        habitacion.nHabitacion,
            count(*) AS numrows1 FROM comida
         INNER JOIN persona ON comida.idPersona=persona.idPersona
         INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
         INNER JOIN hospedaje ON comida.idPersona=hospedaje.idPersona
         left JOIN hotel ON hospedaje.idHotel=hotel.idHotel
         INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
             $where  ");
*/

        $count_query1 = mysqli_query($con,"SELECT 

        comidaespecial.idComidaespecial,
        comidaespecial.idPersona,
        comidaespecial.tipoComida,
        comidaespecial.fechaComida,
        comidaespecial.horaComida,
       

        persona.idPersona,
        persona.rutPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.qrPersona,
        persona.idEmpresa,

  
        COUNT(*) AS numrows1
        FROM comidaespecial 
         INNER JOIN persona ON comidaespecial.idPersona=persona.idPersona
         INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa

        /* INNER JOIN habitacion ON hotel.idHotel=habitacion.idHotel*/
        $where
         ");

            if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT 

        comidaespecial.idComidaespecial,
        comidaespecial.idPersona,
        comidaespecial.tipoComida,
        comidaespecial.fechaComida,
        comidaespecial.horaComida,
       

        persona.idPersona,
        persona.rutPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.qrPersona,
        persona.idEmpresa,
        empresa.nombreEmpresa
        FROM comidaespecial 
         INNER JOIN persona ON comidaespecial.idPersona=persona.idPersona
         INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa


         $where  ORDER BY comidaespecial.idComidaespecial,comidaespecial.tipoComida,comidaespecial.horaComida LIMIT $offset,$per_page");

    
        
        if (mysqli_num_rows($query) > 0){
            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>
                                <tr class="bg-primary">               
                                 <th>Fecha</th>
                                 <th>Hora</th>  
                                  <th>Persona</th>
                          
                            
                                  <th>Empresa</th>
                                 <th>Tipo Comida</th>
                                <!-- <th>Acciones</th> -->                                    
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>                          
                       <td class=""><?php echo utf8_encode($row['fechaComida']);?></td>
                       <td class=""><?php echo utf8_encode($row['horaComida']);?></td>
                                         
                       <td class=""><?php echo utf8_encode($row['nombresPersona']." ".$row['apellidoPersona1']);?></td>
       

                        <td class=""><?php echo utf8_encode($row['nombreEmpresa']);?></td>
                       <td class=""><?php echo utf8_encode($row['tipoComida']);?></td>

                       <!--<td><a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=comida&a=Eliminar&idComida=<?php echo $row['idComida']?>" class="glyphicon glyphicon-remove"></a></td>
                -->
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
