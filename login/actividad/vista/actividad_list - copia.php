<script>
  function reportePDF1(){

    var idLinea = $('#idLinea').val();
    var tipoA = $('#tipoA').val();
    var estado = $('#estado').val();


    window.open('actividad/reportes_pdf/actividad.php?idLinea='+idLinea+'&tipoA='+tipoA+'&estado='+estado);
}

</script>


<div class="container-fluid">

<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
     <h2 class="titulos" align="center"> Actividades </h2>
	<div class="row">
        <div class="col-md-2 titulos2"><h4>Buscar</h4>
           <input type="text" class="form-control input-sm" id="descripcion" name="descripcion" placeholder="Buscar:">

        </div>
        <div class="col-md-3 titulos2"><h4>Seleccione un tipo de Actividad</h4>
           <select name="tipoA" id="tipoA" class="form-control  input-sm">
            <option value="">--</option>
           <option value="GPS">GPS</option>
           <option value="CAMARAS">CAMARAS</option>
            
           </select>
        </div>

        <div class="col-md-4 titulos2"><h4>Seleccione una linea</h4>
            <select name="idLinea" id="idLinea" class="form-control input-sm">
                <option value="">---</option>
                <?php  foreach ($this->model->ListarLineas()as $a): ?>
                <option  <?php echo $a->idLinea == "" ? 'selected' : ''; ?> value="<?php echo "$a->idLinea" ;?>"><?php echo $a->nLinea;?></option>
                <?php endforeach; ?>
            </select>
        </div>

                     


        <div class="col-md-2 titulos2"><h4>Estado</h4>
            <select name="estado" id="estado" class="form-control input-sm">   
            <option value="">--</option>    
            <option value="Pendiente">Pendiente</option>
            <option value="Aprobado" >Aprobado</option>            
            </select>
        </div>

          <div class="col-md-1">
          <br>
    <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar actividad"><img src="img/pdf.png" width="50px" height="50px" "></a>
      
        </div>
     
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="outer_div"></div>
    	</div>

        <div id="result"></div>
    </div>

</div>
<!--CONSULTA DE EVENTO TODOS -->
<script>
    $(document).ready(function(){
        load2();
        load3();

    });

    function load2(page){
        $("#descripcion").keyup(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#descripcion").val();
        var parametros = {"action":"ajax","page":page,"numero":id};
       
        $.ajax({
            url:'actividad/reportes/descripcion.php',
            data: parametros,
         
            success:function(data){
             console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load3(page){
        var id = $("#descripcion").val();        
        var parametros = {"action":"ajax","page":page,"numero":id};     

        $.ajax({
            url:'actividad/reportes/descripcion.php',
            data: parametros,
      
            success:function(data){
                console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}
    </script>

    <script>
    $(document).ready(function(){
        load4();
        load5();

    });

    function load4(page){
        $("#tipoA").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val(), id1 = $("#idLinea").val(), id2 = $("#estado").val();       
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLinea":id1, "estado":id2};
       
        $.ajax({
            type: "POST",
            url:'actividad/reportes/tipoA.php',
            data: parametros,         
            success:function(data){
             console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

    function load5(page){
        var id = $("#tipoA").val(), id1 = $("#idLinea").val(), id2 = $("#estado").val();       
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLinea":id1, "estado":id2};  
        $.ajax({
            type: "POST",
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
             console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}
    </script>


    </script>

    <script>
    $(document).ready(function(){
        load6();
        load7();

    });

    function load6(page){
        $("#estado").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val(), id1 = $("#idLinea").val(), id2 = $("#estado").val();       
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLinea":id1, "estado":id2};
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
             console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

    function load7(page){
        var id = $("#tipoA").val(), id1 = $("#idLinea").val(), id2 = $("#estado").val();       
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLinea":id1, "estado":id2};
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
             console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}
    </script>


    <script>
    $(document).ready(function(){
        load8();
        load9();

    });

    function load8(page){
        $("#idLinea").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val(), id1 = $("#idLinea").val(), id2 = $("#estado").val();       
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLinea":id1, "estado":id2};
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
             console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

    function load9(page){
        var id = $("#tipoA").val(), id1 = $("#idLinea").val(), id2 = $("#estado").val();       
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLinea":id1, "estado":id2}; 
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
             console.log(data)
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}
    </script>






           
          
      



