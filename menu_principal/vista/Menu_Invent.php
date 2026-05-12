<?php
error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en PHP.
session_start();

if (!isset($_SESSION['usuarioInventario'])) {
    exit;
}

?>


<div class="container-fluid">


          <?php include_once 'Menu_Inventario.php'; ?>

    
</div>



    </div>

    <!-- /.content-header -->

    <!-- Main content -->

    <!-- /.content -->

  <!-- /.content-wrapper -->
  

