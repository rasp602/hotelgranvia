<script src="producto/js/ajaxOrdenesPreparadas.js"></script>

<div class="container-fluid">
<?php 
          $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                              ;
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
         ?> 
    <h3  class="page-header" align="center">Órdenes de entrega preparadas</h3>
        <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Orden registrada correctamente..</div>'; ?> 
        
        <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Ordeneliminada correctamente..</div>'; ?>  
        <div class="container mt-4">
  <div class="row">
    <!-- Espaciado a la izquierda -->
    <div class="col-md-1"></div>

    <!-- Selección de Hotel -->
    <div class="col-md-2">
      <h4>Hotel</h4>
      <select name="idHotel" id="idHotel" class="form-control input-sm">
        <option value="">Seleccione un hotel</option>
        <?php foreach ($this->model->ListarHotel() as $a): ?>
          <option value="<?php echo $a->idHotel; ?>" 
                  <?php echo $a->idHotel == "" ? 'selected' : ''; ?>>
            <?php echo $a->nombreHotel; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Selección de Tipo de Entrega -->
    <div class="col-md-2">
      <h4>Tipo de Entrega</h4>
      <select name="tipoEntrega" id="tipoEntrega" class="form-control input-sm">
        <option value="">Seleccione un tipo de entrega</option>
        <option value="L">Lonchera</option>
        <option value="E">Empaquetado</option>
      </select>
    </div>

    <!-- Fecha Desde -->
    <div class="col-md-2">
      <h4>Desde</h4>
      <input type="date" class="form-control" id="desde" name="desde" autocomplete="off" required>
    </div>

    <!-- Fecha Hasta -->
    <div class="col-md-2">
      <h4>Hasta</h4>
      <input type="date" class="form-control" id="hasta" name="hasta" autocomplete="off" required>
    </div>

    <!-- Botón Nueva Orden -->
    <div class="col-md-2 text-center">
      <a href="127.0.0.1/inventario/vender.php" class="btn btn-primary mt-4 d-flex align-items-center justify-content-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-square">
          <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
        <p class="mb-0 ms-2">Nueva orden</p>
      </a>
    </div>

    <!-- Espaciado a la derecha -->
    <div class="col-md-1"></div>
  </div>
</div>
<br>
        <div class="row">
            <div class="col-md-1"></div>
        	<div class="col-md-10">
        		<div class="outer_div"></div>
        	</div>
					
            <div id="result"></div>

            <div class="col-md-1"></div>
        </div>
</div>
