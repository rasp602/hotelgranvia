<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<?php

    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
        include 'pagination_comidaServida.php'; //incluir el archivo de paginación

        //las variables de paginación
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //la cantidad de registros que desea mostrar
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
        
        if ($idHotel==5) {
            include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
            
          
          }


$tipoComida = $_REQUEST["tipoComida"];


$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');

$where="";
if ($idHotel!="" && $tipoComida!="") {
    $where="where tipoComida LIKE'%".$tipoComida."%'";

}

if ($idHotel!="" && $tipoComida!="" && $desde!="" && $hasta!="") {
    $where="where tipoComida LIKE'%".$tipoComida."%' AND fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
 
}


if ($idHotel!="" && $desde!="" && $hasta=="") {
    $where="where fechaComida BETWEEN '".$desde."' AND '".$fecha1."'";

}



        $count_query1 = mysqli_query($con,"SELECT 

            count(*) AS numrows1 FROM comidaservida

             $where");
            if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT *
      
         FROM comidaservida

         $where ORDER by idComidaservida LIMIT $offset,$per_page");

    
        
        if (mysqli_num_rows($query) > 0){
            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>
                                <tr class="bg-primary">               
                                 <th>Fecha</th>
                                 <th>Hotel</th>  
                                  <th>Tipo Comida</th>
                                 
                                 <th>Cantidad</th>
                                 <th>Acciones</th>
                                 
                                 
                                                                               
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>      
                       
                       <td class=""><?php echo utf8_encode($row['fechaComida']);?></td>
                       <td class=""><?php echo utf8_encode($row['idHotel']);?></td>
                                         
                       
                   
                       <td class=""><?php echo utf8_encode($row['tipoComida']);?></td>
                       <td class=""><?php echo utf8_encode($row['cantidad']);?></td>
                       

                        <td><a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=comidaservida&a=Eliminar&idComidaservida=<?php echo $row['idComidaservida']?>" class="glyphicon glyphicon-remove"></a></td>
                      
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
