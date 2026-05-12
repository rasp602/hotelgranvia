<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.	
?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>     

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
<div class="col-md-4"></div>

              <div class="col-md-4">
                  <form id="form1" action="?c=ingreso&a=ValidarExtra" name="form1" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="idEntradaT" name="idEntradaT" value="<?php echo $vte->idEntradaT;?>" placeholder="idEntradaT"> 
             
              
        <h2 align="center">Validar Horas Extras:</h2>
   
                    <div class="row">     
                      <div class="col-md-12 titulos2">                                                       
                     
                          <select name="validacion" id="validacion" class="col-md-12 form-control" required="">   
                            <option value="0">SI</option>
                            <option value="1">NO</option>                            
                          </select>
                          
                  
                      </div>              
                    </div>  

                  <div class="row">
                    <div class="col-md-12" align="center"> 
                    <br>                
                             <input type="submit"  id="Registrar" class="btn btn-success" value='Actualizar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Recargar" value="Atras" onClick="location.href='?c=ingreso&a=menuIngreso'">             
                    </div>
                 </div>                          
          </div>

<div class="col-md-4"></div>



          </form>



</div>


       
<!--style="visibility:hidden"-->


