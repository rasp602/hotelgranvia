  function reportePDF1(){
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#persona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
    window.open('comidaextra/reportes_pdf/list_comidaExtra.php?tipoComida='+tipoComida+'&persona='+persona+'&desde='+desde+'&hasta='+hasta);
}
    $(document).ready(function(){
        load10();
        load11();
    });

    function load10(page){
        $("#tipoPedido").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();  
            
        var tipoPedido = $("#tipoPedido").val();        
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"tipoPedido":tipoPedido,"desde":desde,"hasta":hasta};
       
        $.ajax({
            type: "POST",
            url:'producto/reportes/list_pedidos.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

    function load11(page){
        
        var tipoPedido = $("#tipoPedido").val();        
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"tipoPedido":tipoPedido,"desde":desde,"hasta":hasta};
       
        $.ajax({
            type: "POST",
               url:'producto/reportes/list_pedidos.php',
            data: parametros,      
            success:function(data){             
                $(".outer_div").html(data).fadeIn('slow');              
            }
        })
    
}


 $(document).ready(function(){
        load12();


    });

    function load12(page){
        $("#persona").keyup(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var tipoPedido = $("#tipoPedido").val();        
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"tipoPedido":tipoPedido,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'producto/reportes/list_pedidos.php',
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
        var tipoPedido = $("#tipoPedido").val();        
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"tipoPedido":tipoPedido,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'producto/reportes/list_pedidos.php',
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
        var tipoPedido = $("#tipoPedido").val();        
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"tipoPedido":tipoPedido,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'producto/reportes/list_pedidos.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}
  

$(document).ready(function(){
    load73();


});

function load73(page){
    $("#idHotel").change(function(e){
    e.preventDefault();  
    $("#outer_div").empty();
    var tipoPedido = $("#tipoPedido").val();        
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var parametros = {"action":"ajax","page":page,"tipoPedido":tipoPedido,"desde":desde,"hasta":hasta};
   
    $.ajax({
        url:'producto/reportes/list_pedidos.php',
        data: parametros,
     
        success:function(data){
        
            $(".outer_div").html(data).fadeIn('slow');
        
        }
    })
});
}


