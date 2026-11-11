

<div class="container-fluid">
<?php 
          $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                               
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                              
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
                        if ($usuario->nivel == "I") 
                        {
                                
                                include_once 'menu_principal/vista/Menu_Inventario.php';   
                        } 
               }  
               $id = $_REQUEST["id"];        
         ?> 
         
    <h3  class="page-header" align="center"><i class="bi bi-clipboard"></i> Órden de entrega N° <?php echo  $id ?></h3>
    <h3  class="page-header" align="center"><i class="bi bi-calendar-date"></i> Fecha de orden </h3>
        <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Orden registrada correctamente..</div>'; ?> 
        
        <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Ordeneliminada correctamente..</div>'; ?>  
    <div class="row">


<!--
        <div class="col-md-2">
            <div class="titulos2"><h4>Persona</h4>
               <input type="text" class="form-control input-sm" id="persona" name="persona" placeholder="Persona:">
            </div>
        </div>
              -->

        
        <!--
          <div class="col-md-1">
    
    <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar actividad"><img src="img/pdf.png" width="50px" height="50px">
    <p> Reporte Pdf</p></a>
       </div>
 <div class="col-md-1">


         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar actividad"><img src="img/excel.png" width="50px" height="50px"> 
    <p> Reporte Excel</p></a>

    
   </div>-->
    
<div class="col-md-1"></div>

    </div>
        <div class="row">
            <div class="col-md-2"></div>
        	<div class="col-md-8">
        		<div class=""><?php
    error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en PHP.
    include 'bd/conexionLocal.php'; // Incluir el archivo de conexión

        // Parámetros de filtro
        $id = $_REQUEST["id"];
        // Consulta principal para recuperar los datos
        $query = mysqli_query($con, "
           SELECT productos_preparados.id,productos_preparados.cantidad,productos_preparados.precio,productos_preparados.idProductoPreparado,productos_preparados.idVenta_Preparado
,producto_prepa.idProductoPreparado,producto_prepa.nombreProducto,ventas_preparada.id,ventas_preparada.fecha,ventas_preparada.total,ventas_preparada.idUsuario,ventas_preparada.idHotel,ventas_preparada.tipoEntrega,ventas_preparada.gananciaG,tblusuario.idUsuario,tblusuario.nombre,tblusuario.apellido
FROM `productos_preparados`
INNER JOIN producto_prepa ON productos_preparados.idProductoPreparado = producto_prepa.idProductoPreparado

INNER JOIN ventas_preparada ON productos_preparados.idVenta_Preparado = ventas_preparada.id
INNER JOIN tblusuario ON ventas_preparada.idUsuario = tblusuario.idUsuario

WHERE ventas_preparada.id =  $id");

        // Mostrar los resultados
        if (mysqli_num_rows($query) > 0) {
?>
<div class="container-fluid background-image">
    <div class="row">
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
                <thead>
                    <tr class="bg-primary">
                        <th>Cantidad</th>
                        <th>Descripción del Producto <i class="bi bi-box-seam"></i></th> 
                    
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo utf8_encode($row['cantidad']); ?></td>
                            <td><?php echo utf8_encode($row['nombreProducto']); ?></td>
                  
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .background-image {
        background-image: url('ruta_de_tu_imagen.jpg');
        background-size: cover; /* O usa 'contain' si prefieres que la imagen se ajuste sin recortarse */
        background-position: center;
        background-repeat: no-repeat;
        padding: 20px; /* Para crear un espacio adecuado alrededor del contenido */
        border: 2px solid #ddd; /* Simula un cuadro */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Añade una sombra para efecto cuadro */
    }
</style>

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
    
?>
</div>
        	</div>
					
            <div id="result"></div>

            <div class="col-md-2"></div>
        </div>
</div>
