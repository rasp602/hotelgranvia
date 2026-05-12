<script src="ingreso/js/ajaxIngreso.js"></script>
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
                                echo "hola usuario";
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                                echo "hola Fiscalizador";
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
               }               
         ?>

    <h3  class="page-header" align="center">Ingreso de Trabajadores</h3>

    <div class="row">

       <div class="col-md-2">
            <div class="titulos2"><h4>Trabajador</h4>
               <input type="text" class="form-control input-sm" id="nombreTrabajador" name="nombreTrabajador" placeholder="Trabajador:">
            </div>
        </div>




          <div class="col-md-2">
            <h4>Hotel</h4>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">
                    <option value="">Todos</option>
               
       <?php  foreach ($this->model->ListarHotel()as $a): ?>
                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach; ?> 
            </select>
          </div>


        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group">

            <?php $fecha=date('Y-m-d') ?>
               <input class="form-control" id="desde" name="desde"  type="date" value="<?php echo $fecha; ?>"  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value="<?php echo $fecha; ?>"  autocomplete="off" required/>

          </div>
        </div>        
      
            <div class="col-md-1" align="center">  
            <a href="javascript:reportePDF1();"  data-toggle="tooltip" data-placement="top" title="Descargar pdf"><img src="img/pdf.png" width="50px" height="50px">
                <p>PDF</p>
            </a>
            </div>

        <div class="col-md-1">
            <div class="titulos2"><h4>Mes</h4>

        <select name="mes" id="mes" class="form-control">
            <?php
            $meses = array(
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre'
            );

            $anioActual = date('Y');
            $mesActual = date('n');

            foreach ($meses as $mesNumero => $mesNombre) {
                $fecha = "$anioActual-$mesNumero-01";
                $selected = ($mesNumero == $mesActual) ? 'selected' : '';
                echo "<option value='$fecha' $selected>$mesNombre</option>";
            }
            ?>
        </select>
            </div>
        </div>
            <div class="col-md-1" align="center">  
            <a href="javascript:reportePDFmes();"  data-toggle="tooltip" data-placement="top" title="Descargar pdf"><img src="img/pdf.png" width="50px" height="50px">
                <p>MES</p>
            </a>
            </div>

            <div class="col-md-1" align="center">
        <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar empresas"><img src="img/excel.png" width="50px" height="50px"> <p>MES</p></a>
</div>

    </div>
        <div class="row">
           
        	<div class="col-md-12">
        		<div class="outer_div"></div>
        	</div>
         
					
            <div id="result"></div>
        </div>
</div>
