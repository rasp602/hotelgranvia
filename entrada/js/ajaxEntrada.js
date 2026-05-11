  function reportePDF1(){
             

        var idPersona = $("#idPersona").val();
         var idEmpresa = $("#idEmpresa").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
    window.open('comida/reportes_pdf/list_comida.php?idPersona='+idPersona+'&desde='+desde+'&hasta='+hasta+'&idEmpresa='+idEmpresa);
}
    $(document).ready(function(){

        load11();
    });


    function load11(page){
        
        var idEmpresa = $("#idEmpresa").val();    
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa};
        $.ajax({
            type: "POST",
            url:'entrada/reportes/list_entrada.php',
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
              
        var idEmpresa = $("#idEmpresa").val();    
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa};
       
        $.ajax({
            url:'entrada/reportes/list_entrada.php',
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
       
        var idEmpresa = $("#idEmpresa").val();    
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa};
        $.ajax({
            url:'entrada/reportes/list_entrada.php',
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
       
        var idEmpresa = $("#idEmpresa").val();    
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa};
        $.ajax({
            url:'entrada/reportes/list_entrada.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}
  

   $(document).ready(function(){
        loadEmpresa();


    });

    function loadEmpresa(page){
        $("#idEmpresa").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
       
        var idEmpresa = $("#idEmpresa").val();    
        var idPersona = $("#idPersona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idPersona":idPersona,"desde":desde,"hasta":hasta,"idEmpresa":idEmpresa};
        $.ajax({
            url:'entrada/reportes/list_entrada.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}
  



