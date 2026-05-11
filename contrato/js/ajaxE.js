function reportePDF1()
{

    var campo = $('#campo').val();

window.open('empresa/reportes_pdf/HistorialEmpresa.php?campo='+campo);
}

function reporteExcel()
{
var campo = $('#campo').val();
var id_user = $('#id_user').val();
    
window.open('empresa/excel/ReporteExcel.php?campo='+campo+'&id_user='+id_user);
}

   $(document).ready(function(){
    load20();
    load30();
});



function load20(page){
$("#nombreEmpresa").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id = $("#nombreEmpresa").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreEmpresa":id,"desde":id3, "hasta":id4};   
       
        $.ajax({
            url:'empresa/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load30(page){
        var id = $("#nombreEmpresa").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreEmpresa":id,"desde":id3, "hasta":id4}; 
       
        $.ajax({
            url:'empresa/reportes/tipoA.php',
            data: parametros,
      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}


   $(document).ready(function(){
        load77();

    });

    function load77(page){
        $("#desde").change(function(e){
        e.preventDefault();  
        var id = $("#nombreEmpresa").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreEmpresa":id,"desde":id3, "hasta":id4}; 
        $.ajax({
            url:'empresa/reportes/tipoA.php',
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
        var id = $("#nombreEmpresa").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreEmpresa":id,"desde":id3, "hasta":id4}; 
        $.ajax({
            url:'empresa/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

