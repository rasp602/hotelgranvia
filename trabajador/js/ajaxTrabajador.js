function reportePDF1()
{
    var rutTrabajador = $('#rutTrabajador').val();
    var genero = $('#genero').val();
    
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idHotel = $('#idHotel').val();
    var nombresPersona = $('#nombreTrabajador').val();

window.open('trabajador/reportes_pdf/HistorialTrabajador.php?rutTrabajador='+rutTrabajador+'&genero='+genero+'&desde='+desde+'&hasta='+hasta+'&nombreTrabajador='+nombreTrabajador+'&idHotel='+idHotel);
}



function reportePDF2()
{
    var idTrabajador = $('#idTrabajador').val();

window.open('trabajador/reportes_pdf/credencial.php?idTrabajador='+idTrabajador);
}


function reporteExcel()
{
    var nombreTrabajador = $('#nombreTrabajador').val();
    var genero = $('#genero').val();
    var idHotel = $('#idHotel').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    
window.open('trabajador/excel/ReporteExcel.php?nombreTrabajador='+nombreTrabajador+'&genero='+genero+'&idHotel='+idHotel+'&desde='+desde+'&hasta='+hasta);
}

   $(document).ready(function(){
    load20();
    load30();
});



function load20(page){
$("#rutTrabajador").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
var id = $("#rutTrabajador").val();
var id1 = $("#genero").val();
var id3 = $("#desde").val();
var id4 = $("#hasta").val();
var id5 = $("#nombreTrabajador").val();
var id6 = $("#idHotel").val();
var id7 = $("#estado").val();        
var parametros = 
    {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5, "idHotel":id6, "estado":id7};   
   
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load30(page){
        var id = $("#rutTrabajador").val();
        var id1 = $("#genero").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombreTrabajador").val();
        var id6 = $("#idHotel").val();
        var id7 = $("#estado").val();        
        var parametros = 
            {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5, "idHotel":id6, "estado":id7};   
           
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
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
$("#nombreTrabajador").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
var id = $("#rutTrabajador").val();
var id1 = $("#genero").val();
var id3 = $("#desde").val();
var id4 = $("#hasta").val();
var id5 = $("#nombreTrabajador").val();
var id6 = $("#idHotel").val();
var id7 = $("#estado").val();        
var parametros = 
    {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5, "idHotel":id6, "estado":id7};   
     
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load31(page){
        var id = $("#rutTrabajador").val();
        var id1 = $("#genero").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombreTrabajador").val();
        var id6 = $("#idHotel").val();
        var id7 = $("#estado").val();        
        var parametros = 
            {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5, "idHotel":id6, "estado":id7};   
           
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
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
        var id = $("#rutTrabajador").val();
        var id1 = $("#genero").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombreTrabajador").val();
        var id6 = $("#idHotel").val();
        var id7 = $("#estado").val();        
        var parametros = 
            {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5, "idHotel":id6, "estado":id7};   
           
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}


   $(document).ready(function(){
        loadEstado();
  
    });

    function loadEstado(page){
        $("#estado").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#rutTrabajador").val();
        var id1 = $("#genero").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombreTrabajador").val();
        var id6 = $("#idHotel").val();
        var id7 = $("#estado").val();        
        var parametros = 
            {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5, "idHotel":id6, "estado":id7};   
           
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

   $(document).ready(function(){
        loadHotel();
  
    });

    function loadHotel(page){
        $("#idHotel").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#rutTrabajador").val();
        var id1 = $("#genero").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombreTrabajador").val();
        var id6 = $("#idHotel").val();
        var id7 = $("#estado").val();        
        var parametros = 
            {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5, "idHotel":id6, "estado":id7};   
           
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}



   $(document).ready(function(){
        load77();

    });

    function load77(page){
        $("#desde").change(function(e){
        e.preventDefault();  
        var id = $("#rutTrabajador").val();
        var id1 = $("#genero").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombreTrabajador").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5};   
       
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
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
        var id = $("#rutTrabajador").val();
        var id1 = $("#genero").val();
        var id3 = $("#desde").val();
        var id4 = $("#hasta").val();
        var id5 = $("#nombreTrabajador").val();
                
        var parametros = 
            {"action":"ajax","page":page,"rutTrabajador":id, "genero":id1,"desde":id3, "hasta":id4, "nombreTrabajador":id5};   
       
        $.ajax({
            url:'trabajador/reportes/tipoA.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}



