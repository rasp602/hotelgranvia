<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<?php

    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
        include 'pagination_producto.php'; //incluir el archivo de paginación

        //las variables de paginación
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 30; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = 10;
       
         $idHotel = $_REQUEST["idHotel"];
  
          include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
       
$codigoBarra = $_REQUEST["codigoBarra"];
$idTipoProducto = $_REQUEST["idTipoProducto"];
$nombreProducto = $_REQUEST["nombreProducto"];

$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');

$where="";
if ($idTipoProducto!="") {
    $where="where tipoproducto.idTipoProducto LIKE'%".$idTipoProducto."%'";

}

if ($tipoProducto!="" && $desde!="" && $hasta!="") {
    $where="where tipoProducto LIKE'%".$tipoProducto."%' AND fechaIngreso BETWEEN '".$desde."' AND '".$hasta."'";
 
}
if ($nombreProducto!="") {
    $where="where nombreProducto LIKE'%".$nombreProducto."%'";

}
if ($codigoBarra!="") {
    $where="where codigoBarra LIKE'%".$codigoBarra."%'";

}

if ($desde!="" && $hasta=="") {
    $where="where fechaIngreso BETWEEN '".$desde."' AND '".$fecha1."'";

}

        $count_query1 = mysqli_query($con,"SELECT inventario.idInventario,inventario.fechaRegistro,inventario.horaRegistro,
        inventario.cantRegistro,inventario.tipoRegistro,inventario.ultimoStock,producto.idProducto,producto.nombreProducto,producto.imagenProducto,producto.existenciaProducto,
        producto.idTipoProducto,
        count(*) AS numrows1 FROM inventario
        INNER JOIN producto ON inventario.idProducto = producto.idProducto LIMIT 20");
        
            if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT inventario.idInventario,inventario.fechaRegistro,inventario.horaRegistro,
        inventario.cantRegistro,inventario.tipoRegistro,inventario.ultimoStock,producto.idProducto,producto.nombreProducto,producto.existenciaProducto,
        producto.idTipoProducto FROM inventario 
        INNER JOIN producto ON inventario.idProducto = producto.idProducto
        ORDER by inventario.idInventario desc LIMIT 20");

    
        
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
                                <th>Descripción de Producto</th> 
                                <th>Cantidad</th>                
                                <th>Tipo de Registro</th> 
                                <th>Stock</th>                                
                                                             
                    
                                                                         
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>      
                       <td class=""><?php echo utf8_encode($row['fechaRegistro']);?></td>
                       <td class=""><?php echo utf8_encode($row['horaRegistro']);?></td>
                       <td class=""><?php echo utf8_encode($row['nombreProducto']);?></td>
                       <td class="" align="center"><?php echo utf8_encode($row['cantRegistro']);?></td>                                         
                       <td class="" align="center">
                    
                       <?php if ($row['tipoRegistro'] == "I"):
                                            echo "Ingreso" ?>
                                        <?php endif ?>

                                        <?php if ($row['tipoRegistro'] == "E"):
                                            echo "Egreso" ?>
                                        <?php endif ?>
                                    
                                    </td>                        
                       
                       <td class="" align="center"><?php echo utf8_encode($row['ultimoStock']);?></td>                
                    
                       
                      
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
