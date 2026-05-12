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
                         
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                               
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
               }               
         ?> 
 

 <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Trabajador registrado correctamente..</div>'; ?> 


 
<script>
  toastr.info('Bienvenido')
</script>
  <h2>Escanea tu codigo QR para registrar Ingreso / Salida</h2>

<div class="col-md-12" align="center">
              
<script src="jquery-3.1.1.min.js"></script>
<script src="js/html5-qrcode.min.js"></script>
<style>
  .result{
    background-color: green;
    color:#fff;
    padding:20px;
  }
  .row{
    display:flex;
  }
</style>
<div class="row">
  <div class="col-sm-2 col-md-2 "></div>
  <div class="col-sm-6 col-md-8">
    <div style="width:350px;" id="reader"></div>
  </div>
<div class="col-sm-2  col-md-2"></div>
  <audio id="myAudio1">
  <source src="success.mp3" type="audio/ogg">
</audio>
<audio id="myAudio2">
  <source src="failes.mp3" type="audio/ogg">
</audio>

<script>
var x = document.getElementById("myAudio1");
var x2 = document.getElementById("myAudio2");      

function showHint(str) {

         var id = $("#qrTrabajador").val();
            
        var parametros = {"id":id};
  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "gethintEntradaT.php?q=" + str, true);
    xmlhttp.send();
 // location.reload();
  }
}

function playAudio() { 
  x.play(); 
} 
  </script>



  <div class="col-md-8" align="left">

    <form action="">

   </form>
     <span id="txtHint"></span></p>
  </div>
</div>


<script type="text/javascript">
function onScanSuccess(qrCodeMessage) {

    document.getElementById("qrTrabajador").value = qrCodeMessage;
    showHint(qrCodeMessage);
 

html5QrcodeScanner.clear();


}
function onScanError(errorMessage) {
  //handle scan error
}
var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 300 });
html5QrcodeScanner.render(onScanSuccess, onScanError);

</script>


</div>

              <div class="col-md-12">
                  <form id="form1" action="?c=entradaT&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="idEntradaT" name="idEntradaT" value="<?php echo $vte->salidaT;?>" placeholder="salidaT"> 
             
                    <div class="row">     
                      <div class="col-md-12 titulos2">
                         
                            <input type="hidden" class="form-control" name="qrTrabajador"   id="qrTrabajador" required onkeyup="showHint(this.value)" placeholder="qrTrabajador"  value="<?php echo $vte->qrTrabajador?>"> 
                        </div>              
                    </div>
        

   
                    <div class="row">     
                      <div class="col-md-12 titulos2">
                            
                            <input type="hidden" class="form-control" name="fechaEntradaT"   id="fechaEntradaT" onkeyup="" placeholder=""  value="<?php echo date("Y-m-d")?>"> 
                        </div>              
                    </div>

                    <div class="row">     
                      <div class="col-md-12 titulos2">
                  
                          <input type="hidden" class="form-control" name="horaEntrada" id="horaSalida" value="<?php
                          date_default_timezone_set("America/caracas"); 
                          echo date("H:i:s");?>">          
                  
                      </div>              
                    </div>  
      


</div>
                 <div class="row">
                    <div class="col-md-12" align="center">
                 
                        
                          <input type="button" id="cancelar" class="btn btn-danger" name="Recargar" value="Recargar" onClick="location.href='?c=ingreso&a=Crud1'">             
                    </div>
                 </div>                          
              </div>
              </form>



</div>
       


</div>
       
<!--style="visibility:hidden"-->


