 function reportePDF1(){
        var nombreTrabajador = $("#nombreTrabajador").val();        
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idHotel = $("#idHotel").val();
    window.open('salida/reportes_pdf/list_salida.php?nombreTrabajador='+nombreTrabajador+'&idHotel='+idHotel+'&desde='+desde+'&hasta='+hasta);
}
    $(document).ready(function(){
  
        load11();
    });


    function load11(page){
        
     
        var nombreTrabajador = $("#nombreTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"nombreTrabajador":nombreTrabajador,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'salida/reportes/list_salida.php',
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
        var nombreTrabajador = $("#nombreTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idHotel = $("#idHotel").val();
        var parametros = {"action":"ajax","page":page,"nombreTrabajador":nombreTrabajador,"desde":desde,"hasta":hasta,"idHotel":idHotel};
       
        $.ajax({
            url:'salida/reportes/list_salida.php',
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
        $("#nombreTrabajador").keyup(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        
        var nombreTrabajador = $("#nombreTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"nombreTrabajador":nombreTrabajador,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'salida/reportes/list_salida.php',
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
        var nombreTrabajador = $("#nombreTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"nombreTrabajador":nombreTrabajador,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'salida/reportes/list_salida.php',
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
        var nombreTrabajador = $("#nombreTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"nombreTrabajador":nombreTrabajador,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'salida/reportes/list_salida.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}
  



