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

window.open('hospedaje/reportes_pdf/HistorialHospedaje.php?idEmpresa='+idEmpresa+'&idHotel='+idHotel+'&descripcion='+descripcion+'&estado='+estado+'&desde='+desde+'&hasta='+hasta+'&idHabitacion='+idHabitacion+'&idCama='+idCama);
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
$("#idHotel").change(function(e){
e.preventDefault();  
$("#outer_div").empty();

        var id1 = $("#idHotel").val();
        var id4 = $("#estado").val();
        var parametros = 
            {"action":"ajax","page":page,"idHotel":id1, "estado":id4};   
       
        $.ajax({
            url:'hospedaje/reportes/Disponible.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}


    function load30(page){

        var id1 = $("#idHotel").val();
        var id4 = $("#estado").val();
        var parametros = 
            {"action":"ajax","page":page,"idHotel":id1 ,"estado":id4}; 
        $.ajax({
            url:'hospedaje/reportes/Disponible.php',
            data: parametros,
      
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
              
            }
        })
    
}





$(document).ready(function(){
    load10();

});

function load10(page){
$("#estado").change(function(e){
e.preventDefault();  
$("#outer_div").empty();

        var id1 = $("#idHotel").val();
        var id4 = $("#estado").val();
        var parametros = 
            {"action":"ajax","page":page,"idHotel":id1 ,"estado":id4}; 
        $.ajax({
            url:'hospedaje/reportes/Disponible.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}



