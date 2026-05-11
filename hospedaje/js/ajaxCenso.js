function censoGeneralPDF()
{
    var descripcion = $('#descripcion').val();
    var idHotel = $('#idHotel').val();
    var idHabitacion = $('#idHabitacion').val();
    var idCama = $('#idCama').val();
    var estado = $('#estado').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/reportes_pdf/censoGeneralPDF.php?idEmpresa='+idEmpresa+'&idHotel='+idHotel+'&descripcion='+descripcion+'&estado='+estado+'&desde='+desde+'&hasta='+hasta+'&idHabitacion='+idHabitacion+'&idCama='+idCama);
}

   $(document).ready(function(){

    load30();
});


    function load30(page){

        var id1 = $("#idHotel").val();
        var id4 = $("#estado").val();
        var parametros = 
            {"action":"ajax","page":page,"idHotel":id1 ,"estado":id4}; 
        $.ajax({
            url:'hospedaje/reportes/CensoGeneral.php',
            data: parametros,
      
            success:function(data){
            
                $(".outer_div1").html(data).fadeIn('slow');
              
            }
        })
    
}





