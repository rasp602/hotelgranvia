function reportePDF1()
{
    var idLinea = $('#idLineaA').val();
    var tipoA = $('#tipoA').val();
    var estado = $('#estado').val();
    var id_user = $('#id_user').val();
    var descripcion = $('#descripcion').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idMaquina = $('#idMaquina').val();
window.open('actividad/reportes_pdf/HistorialFallas.php?idLineaA='+idLinea+'&tipoA='+tipoA+'&idMaquina='+idMaquina+'&estado='+estado+'&id_user='+id_user+'&descripcion='+descripcion+'&desde='+desde+'&hasta='+hasta);
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
            url:'actividad/reportes/tipoTotal.php',
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
            url:'actividad/reportes/tipoTotal.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
  
}


