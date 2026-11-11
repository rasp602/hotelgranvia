function reportePDF1()
{
    var rutPersona = $('#rutPersona').val();
    var genero = $('#genero').val();
    var estado = $('#estado').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var nombresPersona = $('#nombresPersona').val();

window.open('persona/reportes_pdf/HistorialPersona.php?rutPersona='+rutPersona+'&genero='+genero+'&estado='+estado+'&desde='+desde+'&hasta='+hasta+'&nombresPersona='+nombresPersona);
}

function reporteExcel()
{
    var idLinea = $('#idLineaA').val();
    var tipoA = $('#tipoA').val();
    var estado = $('#estado').val();
    var id_user = $('#id_user').val();
    var descripcion = $('#descripcion').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idMaquina = $('#idMaquina').val();
    
window.open('actividad/excel/ReporteExcel.php?idLineaA='+idLinea+'&tipoA='+tipoA+'&idMaquina='+idMaquina+'&estado='+estado+'&id_user='+id_user+'&descripcion='+descripcion+'&desde='+desde+'&hasta='+hasta);
}

   $(document).ready(function(){
    load20();
    load30();
});



function load20(page){
$("#rutPersona").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id = $("#rutPersona").val();
        var id1 = $("#genero").val();
        var id2 = $("#estado").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutPersona":id, "genero":id1, "estado":id2, "desde":id3, "hasta":id4};   
       
        $.ajax({
            url:'persona/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load30(page){
        var id = $("#rutPersona").val();
        var id1 = $("#genero").val();
        var id2 = $("#estado").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutPersona":id, "genero":id1, "estado":id2, "desde":id3, "hasta":id4}; 
       
        $.ajax({
            url:'persona/reportes/tipoA.php',
            data: parametros,
      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}

   $(document).ready(function(){
    load21();
    load31();
});



function load21(page){
$("#nombresPersona").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id = $("#rutPersona").val();
        var id1 = $("#genero").val();
        var id2 = $("#estado").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombresPersona").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutPersona":id, "genero":id1, "estado":id2, "desde":id3, "hasta":id4, "nombresPersona":id5};   
       
        $.ajax({
            url:'persona/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load31(page){
        var id = $("#rutPersona").val();
        var id1 = $("#genero").val();
        var id2 = $("#estado").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombresPersona").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutPersona":id, "genero":id1, "estado":id2, "desde":id3, "hasta":id4, "nombresPersona":id5};   
       
        $.ajax({
            url:'persona/reportes/tipoA.php',
            data: parametros,
      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}




   $(document).ready(function(){
        load40();
  
    });

    function load40(page){
        $("#genero").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#rutPersona").val();
        var id1 = $("#genero").val();
        var id2 = $("#estado").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutPersona":id, "genero":id1, "estado":id2, "desde":id3, "hasta":id4}; 
       
        $.ajax({
            type: "POST",
            url:'persona/reportes/tipoA.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}



/*

   $(document).ready(function(){
        load80();
   

    });

    function load80(page){
        $("#idLineaA").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
        var id7 = $('#idMaquina').val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6, "idMaquina":id7};   
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}
*/




   $(document).ready(function(){
        load77();

    });

    function load77(page){
        $("#desde").change(function(e){
        e.preventDefault();  
        var id = $("#rutPersona").val();
        var id1 = $("#genero").val();
        var id2 = $("#estado").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutPersona":id, "genero":id1, "estado":id2, "desde":id3, "hasta":id4}; 
        $.ajax({
            url:'persona/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}



   $(document).ready(function(){
        load72();


    });

    function load72(page){
        $("#hasta").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#rutPersona").val();
        var id1 = $("#genero").val();
        var id2 = $("#estado").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutPersona":id, "genero":id1, "estado":id2, "desde":id3, "hasta":id4}; 
        $.ajax({
            url:'persona/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

/*

$(document).ready(function(){
    load10();

});

function load10(page){
$("#idMaquina").change(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
        var id7 = $('#idMaquina').val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6, "idMaquina":id7};   
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}





$(document).ready(function(){
    load11();
  
});

function load11(page){


        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
        var id7 = $('#idMaquina').val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6, "idMaquina":id7};   
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
  
}
*/

