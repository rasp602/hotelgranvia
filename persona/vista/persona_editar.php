l<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
$servername = "190.101.222.6";
$username = "hotel";
$password = "chile2023$";
$dbname = "hoteleria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$sql_empresa = "SELECT * FROM empresa";
$result_empresa = $conn->query($sql_empresa);

$sql_contrato = "SELECT * FROM contrato";
$result_contrato = $conn->query($sql_contrato);



?>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
function subirimagen()
{
  self.name = 'opener';
  remote = open('persona/vista/gestionimagen.php', 'remote', 'width=600,height=200,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=yes, status=yes');
  remote.focus();
  }

</script>   

<div class="container-fluid fondoInscripcion">
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
           
           <h2 align="center">Actualizar datos personales</h2>
              
            <div class="col-md-3"></div>
              <div class="col-md-6">
                  <form id="form1" action="?c=persona&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                  <input type="hidden" class="form-control" id="idPersona" name="idPersona" value="<?php echo $vte->idPersona;?>"> 
                
                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Rut:</h4>
                    <input type="text" class="form-control" id="rutPersona" name="rutPersona" value="<?php echo $vte->rutPersona;?>"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Nombres:</h4>
                    <input type="text" class="form-control" id="nombresPersona" name="nombresPersona" value="<?php echo $vte->nombresPersona;?>"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Apellido Padre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona1" name="apellidoPersona1" value="<?php echo $vte->apellidoPersona1;?>"> 
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Apellido Madre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona2" name="apellidoPersona2" value="<?php echo $vte->apellidoPersona2;?>"> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">             
                    <input type="hidden" class="form-control" id="fechaCreado" name="fechaCreado" placeholder="fechaCreado" value="<?php echo date("Y-m-d");?>">
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">                    
                    <input type="hidden" class="form-control" id="horaCreado" name="horaCreado" placeholder="horaCreado" value="<?php
                    date_default_timezone_set("America/caracas"); 
                    echo date("H:i:s");?>">
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">                   
                     <h4 for="">Genero:</h4>
                          <select name="genero" id="genero" class="col-md-2 form-control" required="">
                              <option value="M">MASCULINO</option>
                              <option value="F">FEMENINO</option>                            
                          </select>
                    </div>              
                  </div>                                 
      
                                  
        <div class="row">
          <div class="col-md-12">
            <h4>Empresa</h4>            
              <select name="idEmpresa" id="idEmpresa" class="form-control  input-sm">
                <?php
                while ($row_empresa = $result_empresa->fetch_assoc()) {
                    $selected = ($row_empresa['idEmpresa'] == $vte->idEmpresa) ? 'selected' : '';
                    echo "<option value='" . $row_empresa['idEmpresa'] . "' $selected>" . $row_empresa['nombreEmpresa'] . "</option>";
                }
                ?>
              </select>
          </div>
        </div>
        
      <div class="row">
          <div class="col-md-12">
            <h4>Contrato</h4>
            <select name="idContrato" id="idContrato" class="form-control  input-sm">  
            <option value="">Seleccionar</option>     
            </select>
          </div>
      </div>  
               
                  <div class="row">     
                    <div class="col-md-12">                  
                    <input type="hidden" class="form-control" id="card" name="card" placeholder="card" value="<?php echo $vte->card; ?>" maxlength="8">
                    </div>              
                  </div>
                  <div class="row">
                    <div class="col-md-12"> 
                      <input type="hidden" class="form-control" id="imagen" name="imagen" placeholder="Imagen 1" value="<?php echo $vte->imagen; ?>"  >
                    </div>
                    </div>
                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br>
                          <input type="submit"  id="Actualizar" class="btn btn-success" value='Actualizar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=persona&a=menuPersona'">  <br>           
                    </div>
                 </div> 

                 <div class="row">
                    <div class="col-md-10">        
                      <input type="hidden" class="form-control" id="qrPersona" maxlength="8" name="qrPersona" placeholder="Codigo Qr" required  value="<?php echo $vte->qrPersona; ?>"  >
                    </div>         
                  </div>


                    <div class="col-md-2"></div>
              </form>

</div>

</div>
       
</div>

</div>
       </script> 

<script type="text/javascript">
// Campos Nombres
$(document).ready(function () {
        $("#rutPersona").keyup(function () {
            var value = $(this).val();
            $("#qrPersona").val(value);
            $("#card").val(value);
         
        });
});

</script>


<script>
    $(document).ready(function(){
        load89();
    });

    function load89(){
        $("#idEmpresa").change(function(e){
        e.preventDefault();  
        $("#idContrato").empty();
        var id = $("#idEmpresa").val();        
        var parametros = {"id":id};  
        $.ajax({
            url:'persona/reportes/getContrato.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idContrato").html(data).fadeIn('fast');

             
            }
        })
      });
   
}
    </script>   


