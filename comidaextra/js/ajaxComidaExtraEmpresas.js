function reportePDF1(){
    var idHotel = $("#idHotel").val(); 
    var idEmpresa = $("#idEmpresa").val();    
    var tipoComida = $("#tipoComida").val();        
    var persona = $("#persona").val();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    window.open('comidaextra/reportes_pdf/list_comidaExtra.php?tipoComida='+tipoComida+'&desde='+desde+'&hasta='+hasta+'&idHotel='+idHotel+'&idEmpresa='+idEmpresa);
}

    $(document).ready(function(){
        load10();
        load11();
    });

    function load10(page){
        $("#tipoComida").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();  
        var idHotel = $("#idHotel").val(); 
        var idEmpresa = $("#idEmpresa").val();    
        var tipoComida = $("#tipoComida").val();        
        var persona = $("#persona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idEmpresa":idEmpresa,"tipoComida":tipoComida,"persona":persona,"desde":desde,"hasta":hasta,"idHotel":idHotel};
       
        $.ajax({
            type: "POST",
            url:'comidaextra/reportes/list_comidaExtraEmpresa.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

    function load11(page){
        
        var idHotel = $("#idHotel").val(); 
        var idEmpresa = $("#idEmpresa").val();    
        var tipoComida = $("#tipoComida").val();        
        var persona = $("#persona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idEmpresa":idEmpresa,"tipoComida":tipoComida,"persona":persona,"desde":desde,"hasta":hasta,"idHotel":idHotel};
       
        $.ajax({
            type: "POST",
            url:'comidaextra/reportes/list_comidaExtraEmpresa.php',
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
        var idHotel = $("#idHotel").val(); 
        var idEmpresa = $("#idEmpresa").val();    
        var tipoComida = $("#tipoComida").val();        
        var persona = $("#persona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idEmpresa":idEmpresa,"tipoComida":tipoComida,"persona":persona,"desde":desde,"hasta":hasta,"idHotel":idHotel};
       
        $.ajax({
            url:'comidaextra/reportes/list_comidaExtraEmpresa.php',
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
        var idHotel = $("#idHotel").val(); 
        var idEmpresa = $("#idEmpresa").val();    
        var tipoComida = $("#tipoComida").val();        
        var persona = $("#persona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idEmpresa":idEmpresa,"tipoComida":tipoComida,"persona":persona,"desde":desde,"hasta":hasta,"idHotel":idHotel};
       
        $.ajax({
            url:'comidaextra/reportes/list_comidaExtraEmpresa.php',
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
        var idHotel = $("#idHotel").val(); 
        var idEmpresa = $("#idEmpresa").val();    
        var tipoComida = $("#tipoComida").val();        
        var persona = $("#persona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idEmpresa":idEmpresa,"tipoComida":tipoComida,"persona":persona,"desde":desde,"hasta":hasta,"idHotel":idHotel};
       
        $.ajax({
            url:'comidaextra/reportes/list_comidaExtraEmpresa.php',
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
    var idHotel = $("#idHotel").val(); 
    var idEmpresa = $("#idEmpresa").val();    
    var tipoComida = $("#tipoComida").val();        
    var persona = $("#persona").val();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var parametros = {"action":"ajax","page":page,"idEmpresa":idEmpresa,"tipoComida":tipoComida,"persona":persona,"desde":desde,"hasta":hasta,"idHotel":idHotel};
   
    $.ajax({
        url:'comidaextra/reportes/list_comidaExtraEmpresa.php',
        data: parametros,
     
        success:function(data){
        
            $(".outer_div").html(data).fadeIn('slow');
        
        }
    })
});
}


$(document).ready(function(){
    load75();

});

function load75(page){
    $("#idEmpresa").change(function(e){
    e.preventDefault();  
    $("#outer_div").empty();  
    var idHotel = $("#idHotel").val(); 
    var idEmpresa = $("#idEmpresa").val();    
    var tipoComida = $("#tipoComida").val();        
    var persona = $("#persona").val();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var parametros = {"action":"ajax","page":page,"idEmpresa":idEmpresa,"tipoComida":tipoComida,"persona":persona,"desde":desde,"hasta":hasta,"idHotel":idHotel};
   
    $.ajax({
        type: "POST",
        url:'comidaextra/reportes/list_comidaExtraEmpresa.php',
        data: parametros,         
        success:function(data){
        
            $(".outer_div").html(data).fadeIn('slow');
        
        }
    })
});

}