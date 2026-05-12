  function reportePDF1(){
        var nombreTrabajador = $("#nombreTrabajador").val();        
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var idHotel = $("#idHotel").val();
    window.open('ingreso/reportes_pdf/list_ingreso.php?nombreTrabajador='+nombreTrabajador+'&idHotel='+idHotel+'&desde='+desde+'&hasta='+hasta);
}

  function reportePDFmes(){
             
        var mes = $("#mes").val();
        var idTrabajador = $('#idTrabajador').val();

    window.open('ingreso/reportes_pdf/pdfNuevo3.php?mes='+mes+'&idTrabajador='+idTrabajador);
}

function reporteExcel()
{
var mes = $('#mes').val();
var idTrabajador = $('#idTrabajador').val();

    
window.open('ingreso/reportes_pdf/excelNuevo.php?mes='+mes+'&idTrabajador='+idTrabajador);
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
            url:'ingreso/reportes/list_ingreso.php',
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
            url:'ingreso/reportes/list_ingreso.php',
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
           url:'ingreso/reportes/list_ingreso.php',
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
            url:'ingreso/reportes/list_ingreso.php',
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
            url:'ingreso/reportes/list_ingreso.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}
  



