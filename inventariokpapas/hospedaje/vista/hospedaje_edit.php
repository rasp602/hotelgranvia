<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
/*  date_default_timezone_set("America/caracas");
  $hora=date("H:i:s");
  echo $hora;*/
?>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


<!-- select con buscador -->

<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

<script src="hospedaje/js/ajaxDisponibilidad1.js"></script>
<script src="hospedaje/js/ajaxCenso.js"></script>


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




  <?php $cliente=$usuario->id_user;?>       

  <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">La persona que intenta ingresar ya se encuentra registrada y con una habitacion ocupada</div>';?> 
     <div class="container-fluid">
        <div class="col-md-4">
              <h2 align="center" class="titulos">Nuevo Hospedaje <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-add-fill" viewBox="0 0 16 16">
              <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0Z"/>
              <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
              <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
            </svg></h2>

               <form id="form1" action="?c=hospedaje&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
               <input type="hidden" class="form-control" id="idHospedaje" name="idHospedaje" value="<?php echo $vte->idHospedaje;?>"> 
               <input type="hidden" class="form-control" id="estado" name="estado" value="A">          

   

           
                    <div class="row">     
                      <div class="col-md-12 titulos2">
                       <h4>Ingrese codigo QR <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                      <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z"/>
                      <path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z"/>
                      <path d="M7 9H2v5h5V9Zm-4 1h3v3H3v-3Zm8-6h1v1h-1V4Z"/>
                      <path d="M9 2h5v5H9V2Zm1 1v3h3V3h-3ZM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8H8Zm2 2H9V9h1v1Zm4 2h-1v1h-2v1h3v-2Zm-4 2v-1H8v1h2Z"/>
                      <path d="M12 9h2V8h-2v1Z"/>
                    </svg></h4>
                        <input type="text" class="form-control" name="qrPersona"   id="qrPersona" required onkeyup="showHint(this.value)" placeholder=""  value="<?php echo $vte->qrPersona?>" class="gui-input" autofocus onkeyup="return numeros(event)" maxlength="8"> 
                        </div>              
                    </div>
   

                    <div class="row">     
                      <div class="col-md-12 titulos2">
              
              <select  name="idPersona1" id="idPersona1" class="form-control  input-sm">
                 
              </select>
            
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
                    var id = $("#idPersona").val();
                    var tipoComida = $("#tipoComida").val();        
                    var parametros = {"id":id,"tipoComida":tipoComida}; 

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

                xmlhttp.open("GET", "gethintHospedaje.php?q=" + str, true);
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



                    <div class="row">     
                        <div class="col-md-12">
                        <h4>Hotel <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building-check" viewBox="0 0 16 16">
                      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514Z"/>
                      <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1V1Z"/>
                      <path d="M4.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
                    </svg></h4>


                        <select name="idHotel" id="idHotel" class="form-control  input-sm" >
                          
                            <?php 

                            if ($cliente=="44") {
                                ?>
                            <option value="1">H1</option>
                            <?php
                            }

                            if ($cliente=="45") {
                                ?>
                            <option value="2">H2</option>
                            <?php
                            }

                            if ($cliente=="46") {
                                ?>
                            <option value="3">H3</option>
                            <?php
                            }

                            if ($cliente=="47") {
                                ?>
                            <option value="4">H4</option>
                            <?php
                            }

                            if ($cliente=="48") {
                                ?>
                            <option value="5">H5</option>
                            <?php
                            }

                            elseif($usuario->nivel == "U"){

                            foreach ($this->model->ListarHotel()as $a): ?>
                             <option  <?php echo $a->idHotel == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHotel" ;?>"><?php echo $a->nombreHotel;?></option>
                                              <?php endforeach; 
                            }

                            ?>

                        </select>
                             </div>            
                    </div>

                  <div class="row">     
                    <div class="col-md-12">   
                    <h4>Habitacion</h4>
                    <select name="idHabitacion" id="idHabitacion" class="form-control  input-sm" required>
                      <option value="">Seleccionar Habitación</option>      
                            <?php
                            if ($cliente=="44") 
                            {                                
                                foreach ($this->model->ListarHabitacionesH1()as $a): ?>
                                <option  <?php echo $a->idHabitacion == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHabitacion" ;?>"><?php echo $a->nHabitacion;?></option>
                                <?php endforeach;  

                         
                            }
                            if ($cliente=="45") 
                            {                                
                                foreach ($this->model->ListarHabitacionesH2()as $a): ?>
                                <option  <?php echo $a->idHabitacion == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHabitacion" ;?>"><?php echo $a->nHabitacion;?></option>
                                <?php endforeach;  

                         
                            }

                            if ($cliente=="46") 
                            {                                
                                foreach ($this->model->ListarHabitacionesH3()as $a): ?>
                                <option  <?php echo $a->idHabitacion == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHabitacion" ;?>"><?php echo $a->nHabitacion;?></option>
                                <?php endforeach;  

                         
                            }


                            if ($cliente=="47") 
                            {                                
                                foreach ($this->model->ListarHabitacionesH4()as $a): ?>
                                <option  <?php echo $a->idHabitacion == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHabitacion" ;?>"><?php echo $a->nHabitacion;?></option>
                                <?php endforeach;  
                         
                            }

                            if ($cliente=="48") 
                            {                                
                                foreach ($this->model->ListarHabitacionesH5()as $a): ?>
                                <option  <?php echo $a->idHabitacion == "" ? 'selected' : ''; ?> value="<?php echo "$a->idHabitacion" ;?>"><?php echo $a->nHabitacion;?></option>
                                <?php endforeach;  

                         
                            }                            


                            ?>

                   </select>
                    </div>              
                  </div>
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Cama</h4>
                      <select name="idCama" id="idCama" class="form-control  input-sm" required>
                <option value="">Seleccionar cama</option>
                     </select>
                    </div>              
                  </div>

                  <div class="row">
                    <h4>T.Habitacion</h4>     
                      <div class="col-md-12">             
                         <select name="tipoHabitacion" id="tipoHabitacion" class="form-control  input-sm">
                                   <option value="D">Doble</option>
                                   <option value="S">Simple</option>
                                   
                         </select>
                      </div>              
                  </div>

                <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Desde</h4>
                    <input type="date" class="form-control" id="desde" name="desde" placeholder="desde" value="<?php echo date("Y-m-d");?>">
                    </div>              
                  </div>

 
                 
                  <div class="row">     
                    <div class="col-md-12"> 
                    <h4>Hasta</h4>
                    <input type="date" class="form-control" id="hasta" name="hasta" placeholder="hasta" value="<?php echo date("Y-m-d");?>">
                    </div>              
                  </div>  

      
                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Hospedar" class="btn btn-success" value='Registrar'/>

 


         <?php 
            $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                              ?>
                                
                    <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">  
                                 <?php  
                        }  

                   if ($usuario->nivel == "F") 
                        {
                             ?>
                    <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_fiscalizador'">  

                                 <?php  
                        } 
               }               
         ?> 
                                    
                    </div>
                 </div>                          
          
              </form>




</div>
    

</div>
       
</div>

    <div class="col-md-4">      
 
     <h2 align="center" class="titulos">Censo General <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
  <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
  <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
</svg>
</h2>


                <div class="row">
                              <div class="col-md-1" align="center">
      

     
                 </div>
                                
                    <div class="col-md-12" align="center">

                        <div class="row">
                     
                            <div class="col-md-12">
                                <div class="outer_div1">
                             

                                </div>
                            </div>
                   
                        </div>
                    </div>

                </div> 
    </div>


    <div class="col-md-4">      
 
     <h2 align="center" class="titulos">Censo Habitaciones <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
  <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
  <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
</svg></h2>


                <div class="row">

                                
                    <div class="col-md-12" align="center">
                        <div class="row">
                     
                            <div class="col-md-12">
                                <div class="outer_div">
                             

                                </div>
                            </div>
                   
                        </div>
                    </div>
                </div> 
    </div>




    </div>



</div>
 <!-- div del menu -->
</div>

    <script>
    $(document).ready(function(){
        load88();
    });

    function load88(){
        $("#idHotel").ready(function(e){
        e.preventDefault();  
        $("#idHabitacion").empty();
        $("#idCama").empty();
        var id = $("#idHotel").val();        
        var parametros = {"id":id};  
        $.ajax({
            url:'hospedaje/reportes/getHabitacionDisponible.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idHabitacion").html(data).fadeIn('fast');

             
            }
        })
      });
   
}

    </script> 

        <script>
    $(document).ready(function(){
        load89();
    });

    function load89(){
        $("#idHabitacion").change(function(e){
        e.preventDefault();  
        $("#idCama").empty();
        var id = $("#idHabitacion").val();        
        var parametros = {"id":id};  
        $.ajax({
            url:'hospedaje/reportes/getCamaDisponible.php',
            data: parametros,      
            success:function(data)
            {                
                $("#idCama").html(data).fadeIn('fast');

             
            }
        })
      });
   
}
    </script>    
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> 

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
<script>
    $(document).ready(function(){
        $('#qrPersona').keyup(function(){
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
      });
    });



</script>





