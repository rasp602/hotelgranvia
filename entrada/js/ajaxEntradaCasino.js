  function reportePDF1(){             

        var idTrabajador = $("#idTrabajador").val();
         var idHotel = $("#idHotel").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
    window.open('entrada/reportes_pdf/list_entradaCasino.php?idTrabajador='+idTrabajador+'&desde='+desde+'&hasta='+hasta+'&idHotel='+idHotel);
}


function reporteExcel()
{
        var idTrabajador = $("#idTrabajador").val();
         var idHotel = $("#idHotel").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
    
window.open('entrada/excel/ReporteExcel.php?idTrabajador='+idTrabajador+'&desde='+desde+'&hasta='+hasta+'&idHotel='+idHotel);
}


    $(document).ready(function(){

        load11();
    });


    function load11(page){
        
        var idHotel = $("#idHotel").val();    
        var idTrabajador = $("#idTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idTrabajador":idTrabajador,"desde":desde,"hasta":hasta,"idHotel":idHotel};
        $.ajax({
            type: "POST",
            url:'entrada/reportes/list_entradaCasino.php',
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
        $("#idTrabajador").keyup(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
              
        var idHotel = $("#idHotel").val();    
        var idTrabajador = $("#idTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idTrabajador":idTrabajador,"desde":desde,"hasta":hasta,"idHotel":idHotel};
       
        $.ajax({
            url:'entrada/reportes/list_entradaCasino.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
} 


   $(document).ready(function(){
        loadHotel();


    });

    function loadHotel(page){
        $("#idHotel").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
       
        var idHotel = $("#idHotel").val();    
        var idTrabajador = $("#idTrabajador").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idTrabajador":idTrabajador,"desde":desde,"hasta":hasta,"idHotel":idHotel};
        $.ajax({
            url:'entrada/reportes/list_entrada.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}

