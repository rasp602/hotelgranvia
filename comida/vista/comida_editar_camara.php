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
  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>     
 

 
 
<script>
  toastr.info('Bienvenido')
</script>
  <h2>Escanea tu codigo QR para solicitar tu comida</h2>

  <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Comida registrada correctamente..</div>'; ?> 

 <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Ya comio</div>'; ?> 

  <?php if (isset($_GET["error"])) echo '<div class="alert alert-warning" role="alert">Sin hospedaje</div>'; ?>  

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

    xmlhttp.open("GET", "gethint.php?q=" + str, true);
    xmlhttp.send();
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


<script type="text/javascript">
function onScanSuccess(qrCodeMessage) {

    document.getElementById("qrPersona").value = qrCodeMessage;

    showHint(qrCodeMessage);
 
        var idPersona = $("#qrPersona").val();        
        var parametros = {"id":idPersona};  
        $.ajax({
            url:'comida/reportes/getPersona.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idPersona").html(data).fadeIn('fast');
             
            }
       
      }); 

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
                  <form id="form1" action="?c=comida&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="idComida" name="idComida" value="<?php echo $vte->idComida;?>" placeholder="idComida"> 

                   
            <div class="row">     
         
                            <div class="col-md-12 titulos2">
                    

                             <input type="hidden" class="form-control" name="tipoComida"   id="tipoComida" placeholder=""  value="<?php 
                                    $hora= date('H:i:s');
                                    $desayuno="Desayuno";
                                    $cena="Cena";
                                  if ($hora >= '12:00:00' && $hora <= '23:59:59') {
                                        echo $desayuno;
                                  } 


                                  if ($hora >= '00:00:00' && $hora <= '11:59:59') {
                                    echo $cena;
                                  }
                            

                                  ?>">
            </div>               
                  </div>
             
                    <div class="row">     
                      <div class="col-md-12 titulos2">
                      
                            <input type="hidden" class="form-control" name="qrPersona"   id="qrPersona" required onkeyup="showHint(this.value)" placeholder=""  value="<?php echo $vte->qrPersona?>"> 
                        </div>              
                    </div>
        

                    <div class="row">     
                      <div class="col-md-12 titulos2">
              
              <select  name="idPersona" id="idPersona" class="form-control  input-sm" style="visibility:hidden">

            </select>
                        </div>              
                    </div>

                    <div class="row">     
                      <div class="col-md-12 titulos2">
                            
                            <input type="hidden" class="form-control" name="fechaComida"   id="fechaComida" onkeyup="" placeholder=""  value="<?php echo date("Y-m-d")?>"> 
                        </div>              
                    </div>

                    <div class="row">     
                      <div class="col-md-12 titulos2">
                  
                          <input type="hidden" class="form-control" name="horaComida" id="horaComida" value="<?php
                          date_default_timezone_set("America/caracas"); 
                          echo date("H:i:s");?>">          
                  
                      </div>              
                    </div>  
      


</div>
                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Guardar" class="btn btn-success" value='Solicitar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">             
                    </div>
                 </div>                          
              </div>
              </form>
              
<script src="jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#Guardar').click(function(){

        var id = $("#idPersona").val();
        var tipoComida = $("#tipoComida").val();        
        var parametros = {"id":id,"tipoComida":tipoComida}; 
           $.ajax({
               url: 'ticket.php',
               type: 'POST',
               data: parametros, 


               success: function(data){
                   if(data==1){
                       alert('Imprimiendo....');
                   }else{
                  
                   }
               }
           }); 
        });
    });


</script>


</div>
       


</div>
       



