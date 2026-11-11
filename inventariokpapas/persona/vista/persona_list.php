<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="persona/js/ajaxA.js"></script>

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


     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Persona registrada correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Persona eliminada correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Persona actulizada correctamente..</div>'; ?>


<div class="row">
    <input type="hidden" name="id_user" id="id_user" value="<?php echo $usuario->id_user;?>">
</div>
<div class="container-fluid">
    <h2>Personas</h2>
    <div class="row">
        <div class="col-auto h5">
            <p align="center">Mostrar :</p>
                <select name="num_registros" id="num_registros" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select><br>
                     <p align="center">Registros</p>   
        </div>
        <div class="col-auto h5">
            <p align="left">Buscar R.u.t:</p>
            <input type="text" name="rutPersona" id="rutPersona" class="form-control">
        </div> 
        <div class="col-auto h5">
            <p align="left">Buscar Nombre:</p>
            <input type="text" name="nombresPersona" id="nombresPersona" class="form-control">
        </div>

        <div class="col-auto h5">
            <p align="left">Genero:</p>
                <select name="genero" id="genero" class="form-control">
                    <option value="">Todos</option>
                    <option value="M">M</option>
                    <option value="F">F</option>

                </select>
        </div> 
        <div class="col-auto h5">
            <p align="left">Empresa:</p>
                <select name="idEmpresa" id="idEmpresa" class="form-control">
                    <option value="">Todas</option>               
                        <?php  foreach ($this->model->ListarEmpresas()as $a): ?>
                    <option  <?php echo $a->idEmpresa == "" ? 'selected' : ''; ?> value="<?php echo "$a->idEmpresa" ;?>"><?php echo $a->nombreEmpresa;?></option>
                    <?php endforeach; ?>
                    </select>
        </div>  

        <div class="col-auto h5">
            <p align="left">Creado Desde:</p>
            <div class="input-group">
                <input class="form-control" id="desde" name="desde"  type="date" value=""  autocomplete="off" required/>
            </div>  
        </div>

        <div class="col-auto h5">
            <p align="left">Creado Hasta:</p>
            <div class="input-group">
                <input class="form-control" id="hasta" name="hasta"  type="date" value=""  autocomplete="off" required/>
            </div>
        </div>        

        <div class="col-auto h5">
            <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar actividad"><img src="img/pdf.png" width="50px" height="50px"><p align="center">Descargar</p></a>     
        </div>

        <div class="col-auto h5">
            <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar personas"><img src="img/excel.png" width="50px" height="50px"><p align="center">Descargar</p></a>
        </div>
 </div>
    <div class="row">
    
    	<div class="col-md-12">
    		<div class="outer_div"></div>
    	</div>

        <div id="result"></div>
    </div>
<?php /*include_once 'persona/vista/Personas.php'; */?>

</div>





 <script>
       
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
       
       </script> 



      <script>
       
       function sololetras(e){
           key= e.keyCode || e.which;
           teclado= String .fromCharCode(key).toLowerCase();
           letras="abcdefghijklmnñopqrstuvwxyz"
           especiales="13-9-8-37-38-46";
           
           teclado_especial=false;
           
           for(var i in especiales){
               
               if(key==especiales[i]){
                   teclado_especial=true;break;
                   
                   }
               }
           if(letras.indexOf(teclado)==-1 && !teclado_especial){
               
               return false;
               
               }
           
           }
       
       
       </script> 