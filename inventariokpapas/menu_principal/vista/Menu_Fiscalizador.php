<?php
error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
session_start();

if (!isset($_SESSION['usuarioInventario']))
{

  exit;
}

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
        <a href="?c=menu_principal&a=menu_fiscalizador" class="nav-link">Inicio</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container (!!!LOGO!!!!) -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="?c=menu_principal&a=menu_fiscalizador" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">HOTELERIA</span>
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


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                MENÚ PRINCIPAL
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <!--<ul class="nav nav-treeview">   
              <li class="nav-item">
                <a href="?c=ingreso&a=Crud1" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registro de Entrada / Salida con telefono</p>
                </a>
              </li>        
            </ul>-->
            <ul class="nav nav-treeview">   
              <li class="nav-item">
                <a href="?c=ingreso&a=CrudLector" class="nav-link">
                  <i class='fas fa-qrcode' style='font-size:24px'></i>
                  <p>Registro E/S con Lector Qr</p>
                </a>
              </li>        
            </ul>

            <ul class="nav nav-treeview">   
              <li class="nav-item">
                <a href="?c=hospedaje&a=CrudRapido" class="nav-link">
                  <i class='fas fa-key' style='font-size:24px'></i>
                  <p>Registro de Hospedaje</p>
                </a>
              </li>        
            </ul>
            <ul class="nav nav-treeview">   
              <li class="nav-item">
                <a href="?c=hospedaje&a=CrudRapidoNuevo" class="nav-link">
                   <i class='fas fa-qrcode' style='font-size:24px'></i>
                  <p>R.Hospedaje con QR</p>
                </a>
              </li>        
            </ul>            
              <li class="nav-item">
                <a href="?c=persona&a=Crud" class="nav-link">
                  <i class='fas fa-user-plus' style='font-size:24px'></i>
                  <p>Agregar Nueva Persona</p>
                </a>
              </li> 

              <li class="nav-item">
                <a href="?c=persona&a=menuPersona" class="nav-link">
                 <i class='fas fa-users' style='font-size:24px'></i>
                  <p>Personas Registradas</p>
                </a>
              </li> 

            <li class="nav-item">
                <a href="?c=hospedaje&a=menuHospedaje" class="nav-link">
                  <i class="fa fa-hotel" style="font-size:24px"></i>
                  <p>Hospedaje</p>
                </a>
              </li> 
            <li class="nav-item">
                <a href="?c=hospedaje&a=salidaHospedaje" class="nav-link">
                 <i class='fas fa-door-open' style='font-size:24px'></i>
                  <p>Salida de Hospedaje</p>
                </a>
            </li> 
           <li class="nav-item">
                <a href="?c=comidaservida&a=menuComidaServida" class="nav-link">
                  <i class='fas fa-pizza-slice' style='font-size:24px'></i>
                  <p>Comidas Servidas</p>
                </a>
            </li>           


              <!--<li class="nav-item">
                <a href="?c=hospedaje&a=CrudNombre" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registro de Hospedaje con nombre</p>
                </a>
              </li>--> 
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
          <div class="col-6 col-sm-2">            
                <a href="?c=ingreso&a=Crud1"><button type="button" class="btn btn-primary">Telefono</button></a>
          </div>
             <div class="col-6 col-sm-2">
                <a href="?c=ingreso&a=CrudLector"><button type="button" class="btn btn-primary">Lector Qr</button></a>
             </div>
    
          <div class="col-12 col-sm-6">
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
      </div>
<!-- /.container-fluid -->




   
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


    </div>

    <!-- /.content-header -->

    <!-- Main content -->

    <!-- /.content -->

  <!-- /.content-wrapper -->
  

