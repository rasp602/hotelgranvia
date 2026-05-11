<?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
<?php

    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
        include 'pagination_comidaExtraEmpresa.php'; //incluir el archivo de paginación

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
        


        $tipoComida = $_REQUEST["tipoComida"] ?? "";
        $persona = $_REQUEST["persona"] ?? "";
        $idEmpresa = $_REQUEST["idEmpresa"] ?? "";
        $desde = $_REQUEST["desde"] ?? "";
        $hasta = $_REQUEST["hasta"] ?? "";
        $idHotel = $_REQUEST["idHotel"] ?? "";
        $fecha1 = "3000-01-01";
        
        $whereClauses = [];
        
        if (!empty($idHotel)) {
            if (!empty($tipoComida) && empty($desde) && empty($hasta) && empty($idEmpresa)) {
                $whereClauses[] = "comidaextra.tipoComida LIKE '%" . addslashes($tipoComida) . "%'";
            }
            
            if (!empty($idEmpresa) && empty($tipoComida) && empty($desde) && empty($hasta)) {
                $whereClauses[] = "empresa.idEmpresa LIKE '%" . addslashes($idEmpresa) . "%'";
            }
            
            if (!empty($persona) && empty($tipoComida) && empty($idEmpresa)) {
                $whereClauses[] = "comidaextra.persona LIKE '%" . addslashes($persona) . "%'";
            }
            
            if (!empty($desde) && empty($hasta) && empty($idEmpresa)) {
                $whereClauses[] = "comidaextra.fechaComida BETWEEN '" . addslashes($desde) . "' AND '" . addslashes($fecha1) . "'";
            }
            
            if (!empty($idHotel) && !empty($tipoComida) && !empty($idEmpresa) && !empty($desde) && !empty($hasta)) {
                $whereClauses[] = "comidaextra.tipoComida LIKE '%" . addslashes($tipoComida) . "%' AND comidaextra.fechaComida BETWEEN '" . addslashes($desde) . "' AND '" . addslashes($hasta) . "' AND empresa.idEmpresa LIKE '%" . addslashes($idEmpresa) . "%'";
            }
            
                    
            if (!empty($idHotel) && !empty($tipoComida) && empty($idEmpresa) && !empty($desde) && !empty($hasta)) {
                $whereClauses[] = "comidaextra.tipoComida LIKE '%" . addslashes($tipoComida) . "%' AND comidaextra.fechaComida BETWEEN '" . addslashes($desde) . "' AND '" . addslashes($hasta) . "'";
            }
            
            if (!empty($tipoComida) && !empty($idEmpresa) && empty($desde) && empty($hasta)) {
                $whereClauses[] = "comidaextra.tipoComida LIKE '%" . addslashes($tipoComida) . "%' AND comidaextra.idEmpresa = '" . addslashes($idEmpresa) . "'";
            }

            if (!empty($idHotel) && !empty($desde) && !empty($hasta)) {
                $whereClauses[] = "comidaextra.fechaComida BETWEEN '" . addslashes($desde) . "' AND '" . addslashes($hasta) . "'";
            }
        }
        
        $where = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";




        $count_query1 = mysqli_query($con,"SELECT comidaextra.idComidaExtra,comidaextra.fechaComida,comidaextra.horaComida,comidaextra.tipoComida,comidaextra.persona,comidaextra.observacion,comidaextra.idEmpresa,empresa.idEmpresa,
            empresa.nombreEmpresa,comidaextra.idHotel,hotel.idHotel,hotel.nombreHotel,
            count(*) AS numrows1 FROM comidaextra
INNER JOIN empresa ON comidaextra.idEmpresa = empresa.idEmpresa
INNER JOIN hotel ON comidaextra.idHotel = hotel.idHotel
             $where");
            if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
            $total_pages = ceil($numrows1/$per_page);
            $reload = 'index.php';
    
        //consulta principal para recuperar los datos

        $query = mysqli_query($con,"SELECT comidaextra.idComidaExtra,comidaextra.fechaComida,comidaextra.horaComida,comidaextra.tipoComida,comidaextra.persona,comidaextra.observacion,comidaextra.idEmpresa,empresa.idEmpresa,
            empresa.nombreEmpresa,comidaextra.idHotel,hotel.idHotel,hotel.nombreHotel     
             FROM comidaextra
             INNER JOIN empresa ON comidaextra.idEmpresa = empresa.idEmpresa
             INNER JOIN hotel ON comidaextra.idHotel = hotel.idHotel

         $where ORDER by idComidaExtra LIMIT $offset,$per_page");

    
        
        if (mysqli_num_rows($query) > 0){
            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">

                            <thead>
                                <tr class="bg-primary">
                                <th>Hotel</th>               
                                 <th>Fecha</th>
                                 <th>Hora</th>  
                                  <th>Persona</th>
                                  <th>Empresa</th>                               
                                 <th>Tipo Comida</th>
                                              
                                </tr>
                            </thead>
            <tbody>
                <br>
            <?php
                while($row = mysqli_fetch_array($query)){        
                      ?>
                <tr>      
                <td class=""><?php echo utf8_encode($row['nombreHotel']);?></td>
                       <td class=""><?php echo utf8_encode($row['fechaComida']);?></td>
                       <td class=""><?php echo utf8_encode($row['horaComida']);?></td>
                                         
                       <td class=""><?php echo utf8_encode($row['persona']);?></td>
                       <td class=""><?php echo utf8_encode($row['nombreEmpresa']);?></td>
                   
                       <td class=""><?php echo utf8_encode($row['tipoComida']);?></td>

                       
                      
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
