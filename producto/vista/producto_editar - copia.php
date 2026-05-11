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
                               
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
                        if ($usuario->nivel == "I") 
                        {
                             
                                include_once 'menu_principal/vista/Menu_Inventario.php';   
                        } 
               }          
         ?> 
  
 

 
 
<script>
  toastr.info('Bienvenido')
</script>
  



<div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h2><i class="fas fa-plus-circle"></i> Registrar Producto</h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form id="form1" action="?c=producto&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="idProducto" name="idProducto" value="<?php echo $vte->idProducto; ?>">

                <div class="form-group">
                    <label for="idTipoProducto">Tipo de Producto</label>
                    <select name="idTipoProducto" id="idTipoProducto" class="form-control" required>
                        <option value="">Seleccionar tipo producto</option>
                        <?php foreach ($this->model->ListarTipoProducto() as $a): ?>
                            <option value="<?php echo $a->idTipoProducto; ?>" <?php echo $a->idTipoProducto == "" ? 'selected' : ''; ?>><?php echo $a->nombreTipoProducto; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="nombreProducto">Nombre de Producto</label>
                    <input type="text" class="form-control" name="nombreProducto" id="nombreProducto" placeholder="Nombre del Producto" value="<?php echo $vte->nombreProducto; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="codigoBarra">Código de Barra</label>
                    <input type="text" class="form-control" name="codigoBarra" id="codigoBarra" placeholder="Código de Barra" value="<?php echo $vte->codigoBarra; ?>">
                </div>

                <div class="form-group">
                  
                    <input type="hidden" class="form-control" name="precioProducto" id="precioProducto" placeholder="Precio del Producto" value=1000 required>
                </div>

                <div class="form-group">
         
                    <input type="hidden" class="form-control" name="existenciaProducto" id="existenciaProducto" placeholder="Existencia" value=0 required>
                </div>

                <input type="hidden" name="fechaIngreso" id="fechaIngreso" value="<?php echo date("Y-m-d"); ?>">

                <div class="text-center">
                    <button type="submit" id="Guardar" class="btn btn-success mt-4">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



              
<script src="jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#Guardar').click(function(){

        var id = $("#persona").val();
        var tipoComida = $("#tipoComida").val();        
        var parametros = {"id":id,"tipoComida":tipoComida}; 
           $.ajax({
               url: 'ticketComidaExtra.php',
               type: 'POST',
               data: parametros, 


               success: function(data){
                   if(data==1){
                       alert('Imprimiendo....');

                   }else{
                          location.reload();
                   }
               }
           }); 
        });
    });


</script>

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

