<script src="comidaextra/js/ajaxComidaExtra.js"></script>

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
                        if ($usuario->nivel == "I") 
                        {
                                echo "hola Inventario";
                                include_once 'menu_principal/vista/Menu_Inventario.php';   
                        } 
               }          
         ?> 
    <h3  class="page-header" align="center">COMIDAS EXTRAS</h3>
        <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Comida registrada correctamente..</div>'; ?> 
        
        <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Comida eliminada correctamente..</div>'; ?>  
    <div class="row">

    <div class="col-md-1"></div>
    <div class="col-md-1">
            <h4>Hotel</h4>
            <select name="idHotel" id="idHotel" class="form-control  input-sm">
<option value="">Todas</option>
 
              <?php  foreach ($this->model->ListarHotel()as $a): ?>
                 <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                  <?php endforeach; ?>  
            </select>
    </div>

    <div class="col-md-1">
            <h4>EMPRESA</h4>
            
            <select name="idEmpresa" id="idEmpresa" class="form-control  input-sm">
            <option value="">Todas</option>
              <?php  foreach ($this->model->ListarEmpresas()as $a): ?>
                 <option  <?php echo $a->idEmpresa == "" ? 'selected' : ''; ?> value="<?php echo "$a->idEmpresa" ;?>"><?php echo $a->nombreEmpresa;?></option>
                                  <?php endforeach; ?>  
            </select>
    </div>

        <div class="col-md-2">
            <div class="titulos2"><h4>Tipo de Comida</h4>
            <select name="tipoComida" id="tipoComida" class="form-control  input-sm">
                    <option value="">Seleccione un tipo de comida</option>
                    <option value="Desayuno">Desayuno</option>
                    <option value="Almuerzo">Almuerzo</option>
                    <option value="Cena">Cena</option>
                     <option value="fria">Colación Fria</option>
            </select>
            </div>
        </div>

<!--
        <div class="col-md-2">
            <div class="titulos2"><h4>Persona</h4>
               <input type="text" class="form-control input-sm" id="persona" name="persona" placeholder="Persona:">
            </div>
        </div>
              -->
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
        
        
          <div class="col-md-1">
             <div class="col-md-1">
            <a href="javascript:reportePDF1();"  data-toggle="tooltip" data-placement="top" title="Descargar pdf"><img src="img/pdf.png" width="50px" height="50px">
                <p>Reporte</p></a>
          </div>



    
   </div>
    
<div class="col-md-1">



<a href="?c=comidaextra&a=Crud1">
<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
</svg>
    <p>Comida Extra</p>
</a>


  </div>

    </div>
        <div class="row">
            <div class="col-md-2"></div>
        	<div class="col-md-8">
        		<div class="outer_div"></div>
        	</div>
					
            <div id="result"></div>

            <div class="col-md-2"></div>
        </div>
</div>
