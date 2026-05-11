function reportePDF1()
{
    var descripcion = $('#descripcion').val();
    var idHotel = $('#idHotel').val();
    var idHabitacion = $('#idHabitacion').val();
    var idCama = $('#idCama').val();
    var estado = $('#estado').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/reportes_pdf/HistorialHospedajeDiario.php?idEmpresa='+idEmpresa+'&idHotel='+idHotel+'&descripcion='+descripcion+'&estado='+estado+'&desde='+desde+'&hasta='+hasta+'&idHabitacion='+idHabitacion+'&idCama='+idCama);
}

function resumenPago()
{
   
    var dia_ini = $('#dia_ini').val();
    var dia_fin = $('#dia_fin').val();
    var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/reportes_pdf/pdfx.php?idEmpresa='+idEmpresa+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin);
}


function resumenPagoExcel()
{
   
    var dia_ini = $('#dia_ini').val();
    var dia_fin = $('#dia_fin').val();
    var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/reportes_pdf/excelx.php?idEmpresa='+idEmpresa+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin);
}

function reporteExcel()
{
    var descripcion = $('#descripcion').val();
    var idHotel = $('#idHotel').val();
    var idHabitacion = $('#idHabitacion').val();
    var idCama = $('#idCama').val();
    var estado = $('#estado').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idEmpresa = $('#idEmpresa').val();
    
window.open('hospedaje/excel/ReporteExcelDiario.php?idEmpresa='+idEmpresa+'&idHotel='+idHotel+'&descripcion='+descripcion+'&estado='+estado+'&desde='+desde+'&hasta='+hasta+'&idHabitacion='+idHabitacion+'&idCama='+idCama);
}


function cargaExcel()
{
var nombresPersona = $('#nombresPersona').val();
var id_user = $('#id_user').val();
var rutPersona = $('#rutPersona').val();
var desde = $('#desde').val();
var hasta = $('#hasta').val();
var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/excel/cargaExcel.php?nombresPersona='+nombresPersona+'&id_user='+id_user+'&rutPersona='+rutPersona+'&desde='+desde+'&hasta='+hasta+'&idEmpresa='+idEmpresa);
}



   $(document).ready(function(){
    load20();
    load30();
});



function load20(page){
$("#descripcion").keyup(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load30(page){
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
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
        $("#idHotel").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        $("#idCama").empty();
        $("#idHabitacion").empty();
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            type: "POST",
            url:'hospedaje/reportes/hospedajeDiario.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}





   $(document).ready(function(){
        load80();
   

    });

    function load80(page){
        $("#idHabitacion").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        $("#idCama").empty();
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}



   $(document).ready(function(){
        load81();
   

    });

    function load81(page){
        $("#idCama").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
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
        $("#outer_div").empty();
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
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
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6};   
       
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


$(document).ready(function(){
    load10();

});

function load10(page){
$("#estado").change(function(e){
e.preventDefault();  
$("#outer_div").empty();
$("#idHabitacion").empty();
$("#idCama").empty();
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
        var id7 = $("#idEmpresa").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6, "idEmpresa":id7};   
        
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
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
$("#idEmpresa").change(function(e){
e.preventDefault();  
$("#outer_div").empty();
$("#idHabitacion").empty();
$("#idCama").empty();
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
        var id7 = $("#idEmpresa").val();
                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6, "idEmpresa":id7};   
        
        $.ajax({
            url:'hospedaje/reportes/hospedajeDiario.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

