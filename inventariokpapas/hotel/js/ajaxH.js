function reportePDF1()
{

    var campo = $('#campo').val();

window.open('hotel/reportes_pdf/HistorialHotel.php?campo='+campo);
}

function reporteExcel()
{
    var campo = $('#campo').val();
    var id_user = $('#id_user').val();
    
window.open('hotel/excel/ReporteExcel.php?campo='+campo+'&id_user='+id_user);
}

   $(document).ready(function(){
    load20();
    load30();
});



function load20(page){
$("#nombreHotel").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id = $("#nombreHotel").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreHotel":id,"desde":id3, "hasta":id4};   
       
        $.ajax({
            url:'hotel/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load30(page){
        var id = $("#nombreHotel").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreHotel":id,"desde":id3, "hasta":id4}; 
       
        $.ajax({
            url:'hotel/reportes/tipoA.php',
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
        var id = $("#nombreHotel").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreHotel":id,"desde":id3, "hasta":id4}; 
        $.ajax({
            url:'hotel/reportes/tipoA.php',
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
        var id = $("#nombreHotel").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"nombreHotel":id,"desde":id3, "hasta":id4}; 
        $.ajax({
            url:'hotel/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

