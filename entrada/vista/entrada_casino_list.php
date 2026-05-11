<script src="entrada/js/ajaxEntradaCasino.js"></script>
<?php/*
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=nombre_archivo.xls');*/
?>
<div class="container-fluid">
<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
    <h3  class="page-header" align="center">ENTRADAS A CASINO</h3>

    <div class="row">


        <div class="col-md-2">
            <div class="titulos2"><h4>Trabajador</h4>
               <input type="text" class="form-control input-sm" id="idPersona" name="idPersona" placeholder="Persona:">
            </div>
        </div>

                 <div class="col-md-1">
            <h4>Hotel</h4>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">
                        <option value="">Hotel</option>
               
              <?php  foreach ($this->model->ListarHotel()as $a): ?>

                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach; ?>  
            </select>
        </div>
         <?php $fecha=date('Y-m-d') ?>
        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group">
               <input class="form-control" id="desde" name="desde"  type="date" value="<?php echo $fecha; ?>"  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value="<?php echo $fecha; ?>"  autocomplete="off" required/>

          </div>
        </div>        
      
            <div class="col-md-1">   
            <a href="javascript:reportePDF1();"  data-toggle="tooltip" data-placement="top" title="Descargar pdf"><img src="img/pdf.png" width="50px" height="50px"></a>
            </div>

        <div class="col-md-1">             
         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar"><img src="img/excel.png" width="50px" height="50px"></a>
        </div>

    </div>
        <div class="row">
            <div class="col-md-2"></div>
        	<div class="col-md-8">
        		<div class="outer_div"></div>
        	</div>
            <div class="col-md-2"></div>
					
            <div id="result"></div>
        </div>
</div>
