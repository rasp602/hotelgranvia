<script src="ingreso/js/ajaxMIngreso.js"></script>
<?php/*
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=nombre_archivo.xls');*/
?>
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
                   if ($usuario->nivel == "T") 
                        {
                                
                                include_once 'menu_principal/vista/Menu_Trabajador.php';   
                        }                         
               }               
         ?>
  <?php $cliente=$usuario->id_user;?>  

 <?php $idTrabajador=$usuario->idTrabajador;?> 
    <h3  class="page-header" align="center">Ingreso de Trabajadores</h3>

    <div class="row">

    
               <input type="hidden" class="form-control input-sm" id="idUsuario" name="idUsuario" value="<?php echo $cliente; ?>" placeholder="usuario:">
         
       
               <input type="hidden" class="form-control input-sm" id="idTrabajador" name="idTrabajador" value="<?php echo $idTrabajador; ?>" placeholder="usuario:">

        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group">

            <?php $fecha=date('Y-m-d') ?>
            <?php $fechadesde=date('2023-01-01') ?>
               <input class="form-control" id="desde" name="desde"  type="date" value="<?php echo $fechadesde; ?>"  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value="<?php echo $fecha; ?>"  autocomplete="off" required/>

          </div>
        </div>  

        <div class="col-md-2"><br>
                <h4 class="bg-warning"> Mis Descansos</h4>
        </div>
        <div class="col-md-1">
            <div class="titulos2"><h4>Mes</h4>
              <select name="mes" id="mes" class="form-control">
                   <option value="<?php echo date('Y-01')."-".'01'?>">Enero</option>
                   <option value="<?php echo date('Y-02')."-".'01'?>">Febrero</option>
                   <option value="<?php echo date('Y-03')."-".'01'?>">Marzo</option>
                   <option value="<?php echo date('Y-04')."-".'01'?>">Abril</option>
                   <option value="<?php echo date('Y-05')."-".'01'?>">Mayo</option>
                   <option value="<?php echo date('Y-06')."-".'01'?>">Junio</option>
                   <option value="<?php echo date('Y-07')."-".'01'?>">Julio</option>
                   <option value="<?php echo date('Y-08')."-".'01'?>">Agosto</option>
                   <option value="<?php echo date('Y-09')."-".'01'?>">Septiembre</option>
                   <option value="<?php echo date('Y-10')."-".'01'?>">Octubre</option>
                   <option value="<?php echo date('Y-11')."-".'01'?>">Noviembre</option>
                   <option value="<?php echo date('Y-12')."-".'01'?>">Diciembre</option>
              </select>
            </div>
        </div>
            <div class="col-md-1" align="center">  
            <a href="javascript:reportePDFmes();"  data-toggle="tooltip" data-placement="top" title="Descargar pdf"><img src="img/pdf.png" width="50px" height="50px">
                <p>MES</p>
            </a>
            </div>
      
      





    </div>
        <div class="row">
           
        	<div class="col-md-12">
        		<div class="outer_div"></div>
        	</div>
         
					
            <div id="result"></div>
        </div>
</div>
