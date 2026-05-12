
<?php
error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
session_start();

if (!isset($_SESSION['usuarioInventario']))
{

  exit;
}
require 'bd/config.php';
$fecha=date('Y-m-d');

// Cerrar conexión

?>


<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?c=menu_principal&a=menu_usuarios" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contactos</a>
      </li>
    </ul>

    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container (!!!LOGO!!!!) -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="?c=menu_principal&a=menu_usuarios" class="brand-link">
      <img src="img/granvia.png" alt="AdminLTE Logo" class="brand-image img-circle" width="80px" height="80px">
      <span class="brand-text font-weight-light">HOTEL GRAN VIA</span>
      <p class="brand-text font-weight-light">Servicios Hoteleros</p>
    </a>
<br>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
     <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
</svg>
        </div>
        <div class="info">
       
<h4 class="text-white">
                                  <?php 

                                  $usuario = null;
                                  if (isset($_SESSION["usuarioInventario"])) {
                                      $usuario = $_SESSION["usuarioInventario"];
                                     
                                      echo  $usuario->nombre ; echo"\n".$usuario->apellido;
                                  } else {
                                      header("Location: ../../index.php");
                                  }
                                       echo "\n ";
                                            if ( $_SESSION["usuarioInventario"] )
                                            {
                                                  
                                             
                                            }

                                  ?>
                      </h4>       
        </div>
      </div>

      <!-- SidebarSearch Form
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <!--MENU INVENTARIO--------------------------->       
 
          <li class="nav-item menu-open">            
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                INVENTARIO
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">         
              <li class="nav-item">
                <a href="?c=producto&a=menuProducto" class="nav-link">
                  <i class='fa-solid fa-cube' style='font-size:24px'></i>
                  <p>Productos</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="?c=producto&a=CrudIngreso" class="nav-link">
                  <i class='fa-solid fa-barcode' style='font-size:24px'> </i>
                  <p> Ingreso</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?c=producto&a=Crud" class="nav-link">
                  <i class='fa-solid fa-barcode' style='font-size:24px'> </i>
                  <p> Ingreso por unidad</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="?c=producto&a=Crud2" class="nav-link">
                <i class='fa-solid fa-barcode' style='font-size:24px'> </i>
                  <p> Egreso por unidad </p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="javascript:reporteExcel();" class="nav-link">
                <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Inventario</p>
                </a>
              </li> 
              <!--<li class="nav-item">
                <a href="?c=producto&a=CrudOrden" class="nav-link">
                <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Generar orden de entrega</p>
                </a>
              </li>-->
              <li class="nav-item">
                <a href="?c=producto&a=menuPedidos" class="nav-link">
                <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Pedidos</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="?c=producto&a=menuOrdenes" class="nav-link">
                <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Ordenes de entrega</p>
                </a>
              </li>  
              <!--<li class="nav-item">
                <a href="?c=producto&a=OrdenePreparada" class="nav-link">
                <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Generar Orden preparada</p>
                </a>
              </li>-->

              <li class="nav-item">
                <a href="?c=producto&a=menuOrdenesPreparadas" class="nav-link">
                <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Orden preparada</p>
                </a>
              </li>      
          
              </ul>
          </li> 


    <!--MENU COMIDA--------------------------->
    <li class="nav-item menu-open">            
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              <p>COMIDAS</p>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
            <li class="nav-item">
                <a href="#" class="nav-link">


              <i class="bi bi-bar-chart-line-fill"style='font-size:24px'></i>
                  <p> Indicadores</p>
                </a>
              </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                 <i class='fas fa-utensils' style='font-size:24px'></i>
                  <p>Comidas</p>
                </a>
              </li>
                        
              <li class="nav-item">
                <a href="#" class="nav-link">
                 <i class='fas fa-pizza-slice' style='font-size:24px'></i>
                  <p>Comidas Extras</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                 <i class='fas fa-pizza-slice' style='font-size:24px'></i>
                  <p>Comidas Servidas H5</p>
                </a>
              </li>

            </ul>
          </li> 



             <li class="nav-item">
               
                                 <?php 

                                          $usuario = null;
                                          if (isset($_SESSION["usuarioInventario"])) {
                                              $usuario = $_SESSION["usuarioInventario"];
                                        
                                          } else {
                                              header("Location: ../../index.php");
                                          }
                                               echo "\n ";
                                                    if ( $_SESSION["usuarioInventario"] )
                                                    {
                                                      echo "<li> <a href='includes/cerrarSesion.php'><h5 class='titulos2'><span class='glyphicon glyphicon-off titulos2'></span> Salir</h5></a></li>";
                                                    }

                                    ?>  
          
          </li>
<!--          <li class="nav-header">EXAMPLES</li>-->



        <!--    <li class="nav-header">MISCELLANEOUS</li>
     
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>EDITAR USUARIO</p>
            </a>
          </li>-->

         
<!--
         <li class="nav-header">MULTI LEVEL EXAMPLE</li>
      
       
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>

        
           <li class="nav-header">PUERTAS</li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>SALIDA</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>CASINO</p>
            </a>
          </li>-->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


 <!-- /.HASTA AQUI MENU DE LA IZQUIERDA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            
               <div  id="barraUsuarioFecha" align="right">  
                                <script type="text/javascript">
                                    var d = new Date();
                                    var dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                                    var monthname = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                                    document.write(dayname[d.getDay()]);
                                    document.write(', ');
                                    document.write(d.getDate());
                                    document.write(' de ');
                                    document.write(monthname[d.getMonth()]);
                                    document.write(' de ');
                                    document.write(d.getFullYear());
                                </script>
                                  <?php
                     date_default_timezone_set("America/Santiago"); 
                    echo date("H:i:s");?>


                    
                              </div>
            
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <!-- ./col 

          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 class="cantidad"></h3>

                <h4>Personas registradas</h4>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="?c=persona&a=Crud" class="small-box-footer">Registrar Persona <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>-->

          <!-- ./col 

          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-info">
              <div class="inner">
                <h3 class="hospedaje"></h3>

                <h4>Huespedes</h4>
              </div>
              <div class="icon">
                <i class="ion-android-time"></i>
              </div>
              <a href="?c=hospedaje&a=Crud" class="small-box-footer">Registrar Hospedaje <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>-->
    
          <!-- ./col 
          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 class="comidas"></h3>

                <h4>Comidas registradas</h4>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="?c=comida&a=Crud1" class="small-box-footer">Registrar comida <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <!-- ./col 
          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-success">
              <div class="inner">
                <h3 class="trabajadores"></h3>

                <h4>Trabajadores</h4>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="?c=trabajador&a=Crud" class="small-box-footer">Registrar Trabajador <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>-->


          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
 
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->
  <script src="../../plugins/chart.js/Chart.min.js"></script>

<script type="text/javascript">
            
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'persona/reportes/getCantPersonas.php',
            data: parametros,
         
            success:function(data){
            
                $(".cantidad").html(data).fadeIn('slow');
            
            }
        })
    });
</script>
      
     

 <script type="text/javascript">
            
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'persona/reportes/getCantComidas.php',
            data: parametros,
         
            success:function(data){
            
                $(".comidas").html(data).fadeIn('slow');
            
            }
        })
    });
</script>


 <script type="text/javascript">
            
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'hospedaje/reportes/getCantHospedajes.php',
            data: parametros,
         
            success:function(data){
            
                $(".hospedaje").html(data).fadeIn('slow');
            
            }
        })
    });
</script>


 <script type="text/javascript">
            
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'trabajador/reportes/getTrabajadores.php',
            data: parametros,
         
            success:function(data){
            
                $(".trabajadores").html(data).fadeIn('slow');
            
            }
        })
    });
</script>


    