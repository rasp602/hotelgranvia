  function reportePDF1(){
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
         var idEmpresa = $("#idEmpresa").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idHotel = $("#idHotel").val();
        //var idHotel = $("#idHotel").val();
    //window.open('comida/reportes_pdf/list_comida.php?tipoComida='+tipoComida+'&idPersona='+idPersona+'&desde='+desde+'&hasta='+hasta+'&idEmpresa='+idEmpresa+'&idHotel='+idHotel);
     window.open('comida/reportes_pdf/list_comida.php?tipoComida='+tipoComida+'&idPersona='+idPersona+'&desde='+desde+'&hasta='+hasta+'&idHotel='+idHotel+'&idEmpresa='+idEmpresa);
}

function reportePDF2() {
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    
    // Verificar si las variables están vacías
    if (desde === '' || hasta === '') {
        alert('Por favor, llene los campos "Desde" y "Hasta".');
    } else {
        window.open('comidaespecial/reportes_pdf/control_desayuno.php?desde=' + desde + '&hasta=' + hasta);
    }
}

function reportePDF3(){
     
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    
    // Verificar si las variables están vacías
    if (desde === '' || hasta === '') {
        alert('Por favor, llene los campos "Desde" y "Hasta".');
    } else {
        window.open('comidaespecial/reportes_pdf/control_almuerzo.php?desde=' + desde + '&hasta=' + hasta);
    }
}

function reportePDF4(){
     
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    
    // Verificar si las variables están vacías
    if (desde === '' || hasta === '') {
        alert('Por favor, llene los campos "Desde" y "Hasta".');
    } else {
        window.open('comidaespecial/reportes_pdf/control_cena.php?desde=' + desde + '&hasta=' + hasta);
    }
}






    $(document).ready(function(){
        load10();
        load11();
    });

    function load10(page){
        $("#tipoComida").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();        
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
        var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        $.ajax({
            type: "POST",
            url:'comidaespecial/reportes/list_comidaEspecial.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

    function load11(page){
        
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
        var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        $.ajax({
            type: "POST",
            url:'comidaespecial/reportes/list_comidaEspecial.php',
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
        $("#idPersona").keyup(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
        var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        $.ajax({
            url:'comidaespecial/reportes/list_comidaEspecial.php',
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
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
        var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        $.ajax({
            url:'comidaespecial/reportes/list_comidaEspecial.php',
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
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
        var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        $.ajax({
            url:'comidaespecial/reportes/list_comidaEspecial.php',
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
        $("#idEmpresa").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
        var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        $.ajax({
            url:'comidaespecial/reportes/list_comidaEspecial.php',
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
        $("#idHotel").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
         $("#idHabitacion").empty();
          $("#desde").empty();
           $("#hasta").empty();
           
      

        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
 var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        
        $.ajax({
            url:'comidaespecial/reportes/list_comidaEspecial.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

   $(document).ready(function(){
        load76();


    });

    function load76(page){
        $("#idHabitacion").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idEmpresa = $("#idEmpresa").val();
        var idHotel = $("#idHotel").val();
        var idHabitacion = $("#idHabitacion").val();
        var parametros = {"action":"ajax","page":page,"tipoComida":tipoComida,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa,"idHotel":idHotel,"idHabitacion":idHabitacion};
        
        $.ajax({
            url:'comidaespecial/reportes/list_comidaEspecial.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}