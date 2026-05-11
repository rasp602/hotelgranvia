<script src="entrada/js/ajaxEntrada.js"></script>
<?php/*
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=nombre_archivo.xls');*/
?>
<div class="container-fluid">
<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
    <h3  class="page-header" align="center">LISTA DE ENTRADAS</h3>

    <div class="row">


        <div class="col-md-2">
            <div class="titulos2"><h4>Persona</h4>
               <input type="text" class="form-control input-sm" id="idPersona" name="idPersona" placeholder="Persona:">
            </div>
        </div>

                 <div class="col-md-1">
            <h4>Empresa</h4>
            <select name="idEmpresa" id="idEmpresa" class="form-control  input-sm">
                        <option value="">Empresa</option>
               
              <?php  foreach ($this->model->ListarEmpresas()as $a): ?>

                 <option  <?php echo $a->idEmpresa == "" ? 'selected' : ''; ?> value="<?php echo "$a->idEmpresa" ;?>"><?php echo $a->nombreEmpresa;?></option>
                                  <?php endforeach; ?>  
            </select>
        </div>
        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group">
               <input class="form-control" id="desde" name="desde"  type="date" value=""  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control" id="hasta" name="hasta"  type="date" value=""  autocomplete="off" required/>

          </div>
        </div>        
      
             <div class="col-md-1">   <br>
            <a href="javascript:reportePDF1();"  data-toggle="tooltip" data-placement="top" title="Descargar pdf"><img src="img/pdf.png" width="50px" height="50px"></a>

    
         <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar actividad"><img src="img/excel.png" width="50px" height="50px"></a>
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
