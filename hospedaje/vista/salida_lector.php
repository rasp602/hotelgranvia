<script src="hospedaje/js/ajaxHospedaje.js"></script>
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
 
<script>
  toastr.info('Bienvenido')
</script>
<div class="row"> 
<div class="col-md-2" align="center">

<h6>Escanea tu codigo QR para registrar tu salida de hospedaje</h6>
<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
  <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5ZM9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8Zm1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5Z"/>
  <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2ZM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96c.026-.163.04-.33.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1.006 1.006 0 0 1 1 12V4Z"/>
</svg>

<div class="col-md-12" align="center">
<form id="form1" action="?c=comida&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                <div class="row">     
                      <div class="col-md-12 titulos2">                      
                            <input type="text" class="form-control" name="qrTrabajador"   id="qrTrabajador" required onkeyup="showHint(this.value)" placeholder=""  value="<?php echo $vte->qrTrabajador?>" class="gui-input" autofocus onkeypress="return numeros(event)" maxlength="8"> 
                        </div>                   

                </div> 
                <div class="row"> 

                       <input type="hidden" class="form-control input-sm" id="idUsuario" name="idUsuario" placeholder="usuario:" value='<?php echo $usuario->id_user; ?>'>
                        
            
                        <?php $fecha=date('Y-m-d') ?>
                       <input class="form-control" id="desde" name="desde"  type="hidden" value="<?php echo $fecha; ?>"  autocomplete="off" required/>
                       <input class="form-control" id="hasta" name="hasta"  type="hidden" value="<?php echo $fecha; ?>"  autocomplete="off" required/>
                </div>   

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
</div>
       <div class="row">
  <div class="col-md-12">
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
        var id = $("#qrTrabajador").val();
             
        var parametros = {"id":id}; 

  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";

    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        document.getElementById('txtHint').innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET", "gethintSalidaHuespedNuevo.php?q=" + str, true);
    xmlhttp.send();
    location.reload();

  }
}

function playAudio() { 
  x.play(); 
  

} 
  </script>



  <div class="col-md-12" align="left">

    <form action="">

   </form>
     <span id="txtHint"></span></p>
  </div>
</div>                
</form>
</div>
</div>


<div class="col-md-10">
<h3 align="center">Salida de Huespedes</h3> 
 
<div class="outer_div1"></div>
</div>
</div>
              
<script src="jquery-3.1.1.min.js"></script>
 <script>
    function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = [];
 
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}
    </script>

</div>
       


</div>



<!---->

