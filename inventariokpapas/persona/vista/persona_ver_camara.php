<?php
  error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
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
  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>   
    



<h2>Agregar codigo Qr</h2>

<div class="col-md-4" align="center">

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
  <div class="col-md-4">
    <div style="width:500px;" id="reader"></div>
  </div>

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
    xmlhttp.open("GET", "gethint2.php?q=" + str, true);
    xmlhttp.send();
  }
}

function playAudio() { 
  x.play(); 
} 
  </script>



  <div class="col-md-4" align="left">

    <form action="">

   </form>
     <span id="txtHint"></span></p>
  </div>
</div>


<script type="text/javascript">
function onScanSuccess(qrCodeMessage) {

    document.getElementById("qrPersona").value = qrCodeMessage;
    showHint(qrCodeMessage);

 /*   playAudio();
*/
   
html5QrcodeScanner.clear();
/*document.location.reload();*/
}
function onScanError(errorMessage) {
  //handle scan error
}
var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 480 });
html5QrcodeScanner.render(onScanSuccess, onScanError);

</script>


</div>


            <div class="col-md-6">
                  <form id="form1" action="?c=persona&a=GuardarQR" name="form1" method="post" enctype="multipart/form-data">
              <input type="hidden" class="form-control" id="idPersona" name="idPersona" value="<?php echo $vte->idPersona;?>"> 
                
                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Rut:</h4>
                    <input type="text" class="form-control" id="rutPersona" name="rutPersona" value="<?php echo $vte->rutPersona;?>" readonly=»readonly»> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">
                    <h4>Nombres:</h4>
                    <input type="text" class="form-control" id="nombresPersona" name="nombresPersona" value="<?php echo $vte->nombresPersona;?>" readonly=»readonly»> 
                    </div>              
                  </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Apellido Padre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona1" name="apellidoPersona1" value="<?php echo $vte->apellidoPersona1;?>" readonly=»readonly»> 
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Apellido Madre:</h4>
                    <input type="text" class="form-control" id="apellidoPersona2" name="apellidoPersona2" value="<?php echo $vte->apellidoPersona2;?>"readonly=»readonly»> 
                    </div>              
                  </div>

       

          
                  <div class="row">
                    <div class="col-md-12">
                        <h4 for="">Codigo Qr:</h4> 
                      <input type="text" class="form-control" id="qrPersona" name="qrPersona" placeholder="Codigo Qr" required onkeyup="showHint(this.value)" value="<?php echo $vte->qrPersona; ?>"readonly=»readonly»  >
                    
                    </div>         
                  </div>

                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Actualizar" class="btn btn-success" value='Actualizar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=persona&a=menuPersona'">             
                    </div>
                 </div>                          
              
              </form>

              </div>

</div>
       
</div>









