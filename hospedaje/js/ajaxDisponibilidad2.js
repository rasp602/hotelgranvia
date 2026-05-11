 $(document).ready(function(){
    load22();

});



function load22(page){

$("#idHotel").change(function(e){
e.preventDefault();  
$("#outer_div").empty();
        var id1 = $("#idHotel").val();
        var id2 = $("#idUsuario").val();
        var id4 = $("#estadoHabitacion").val();
        var parametros = 
            {"action":"ajax","page":page,"idHotel":id1, "idUsuario":id2, "estadoHabitacion":id4};   
       
        $.ajax({
            url:'hospedaje/reportes/Disponible2.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}




$(document).ready(function(){
    load12();

});

function load12(page){
$("#estadoHabitacion").change(function(e){
e.preventDefault();  
$("#outer_div").empty();

        var id1 = $("#idHotel").val();
         var id2 = $("#idUsuario").val();
        var id4 = $("#estadoHabitacion").val();
        var parametros = 
             {"action":"ajax","page":page,"idHotel":id1, "idUsuario":id2, "estadoHabitacion":id4};   
        $.ajax({
            url:'hospedaje/reportes/Disponible2.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}



