function reportePDF1()
{
    var idLinea = $('#idLineaA').val();
    var tipoA = $('#tipoA').val();
    var estado = $('#estado').val();
    var id_user = $('#id_user').val();
    var descripcion = $('#descripcion').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    
    window.open('actividad/reportes_pdf/actividad.php?idLineaA='+idLinea+'&tipoA='+tipoA+'&estado='+estado+'&id_user='+id_user+'&descripcion='+descripcion+'&desde='+desde+'&hasta='+hasta);
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
    
window.open('actividad/excel/ReporteExcel.php?idLineaA='+idLinea+'&tipoA='+tipoA+'&estado='+estado+'&id_user='+id_user+'&descripcion='+descripcion+'&desde='+desde+'&hasta='+hasta);
}

   $(document).ready(function(){
    load20();
    load30();
});

function load20(page){
$("#descripcion").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load30(page){
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};

        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}

   $(document).ready(function(){
        load40();
        load50();

    });

    function load40(page){
        $("#tipoA").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
       
        $.ajax({
            type: "POST",
            url:'actividad/reportes/tipoA.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

    function load50(page){
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6}; 
        $.ajax({
            type: "POST",
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}



   $(document).ready(function(){
        load60();
        load70();

    });

    function load60(page){
        $("#estado").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

    function load70(page){
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}

   $(document).ready(function(){
        load80();
        load90();

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
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

    function load90(page){
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}

   $(document).ready(function(){
        load77();
        load97();

    });

    function load77(page){
        $("#desde").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

    function load97(page){
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}


   $(document).ready(function(){
        load72();
        load87();

    });

    function load72(page){
        $("#hasta").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
       
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

    function load87(page){
        var id = $("#tipoA").val();
        var id1 = $("#idLineaA").val();
        var id2 = $("#estado").val();
        var id3 = $("#id_user").val();
        var id4 = $("#descripcion").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = {"action":"ajax","page":page,"tipoA":id, "idLineaA":id1, "estado":id2, "id_user":id3, "descripcion":id4, "desde":id5, "hasta":id6};
        $.ajax({
            url:'actividad/reportes/tipoA.php',
            data: parametros,      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}