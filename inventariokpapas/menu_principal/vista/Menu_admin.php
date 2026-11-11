<div class="container" align="center"> 


        <div class="col-md-12">
            
                    <div class="container-fluid">
                      <br>
                      <header1>
                        <nav class="navbar navbar-default">
                          <div class="container-fluid">
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-1">
                              <span class="sr-only">Menu</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                            <a href="#" class="navbar-brand"></a>
                            </div>
                            <div class="collapsed navbar-collapse" id="navbar-1"> 
                              <ul class="nav navbar-nav">
                                 <li><a href="?c=menu_principal&a=menu_principal"><h5 class="titulos2"><span class="glyphicon glyphicon-home titulos2"></span> Inicio</h5></a></li>
                         <li><a href="?c=actividad&a=menuActividades"><h5 class="titulos2"><span class="glyphicon glyphicon-calendar titulos2"></span>Fallas</h5></a></li>

                                  <li> <a href="?c=cita&a=menuCita"><h5 class="titulos2"><span class="glyphicon glyphicon-lock titulos2"></span> Cambiar clave</h5></a></li>

                              

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

                             

                                 
                    
                              </ul>

                               <div  align="right"><img src="img/usuarios.png" alt="" width="4%" align="right">
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
                               </div>

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
                              </div>

                            </div>  
                          </div>
                        </nav>
                        
                      </header1>

                    </div>    
           
        </div>
  



</div>