
   $(document).ready(function(){
    
    load30();
});





    function load30(page){
        var id = $("#descripcion").val();
        var id1 = $("#idHotel").val();
        var id2 = $("#idHabitacion").val();
        var id3 = $("#idCama").val();
        var id4 = $("#estado").val();
        var id5 = $("#desde").val();
        var id6 = $("#hasta").val();
        var id7 = $("#idUsuario").val();

                
        var parametros = 
            {"action":"ajax","page":page,"descripcion":id, "idHotel":id1, "idHabitacion":id2, "idCama":id3, "estado":id4, "desde":id5, "hasta":id6, "idUsuario":id7};   
       
        $.ajax({
            url:'hospedaje/reportes/resumenBajas.php',
            data: parametros,
      
            success:function(data){
            
                $(".outer_div1").html(data).fadeIn('slow');
              
            }
        })
    
}




  