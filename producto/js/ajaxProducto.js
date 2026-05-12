  function reportePDF1(){
        var tipoComida = $("#tipoComida").val();        
        var idPersona = $("#persona").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
    window.open('comidaextra/reportes_pdf/list_comidaExtra.php?tipoComida='+tipoComida+'&persona='+persona+'&desde='+desde+'&hasta='+hasta);
}

function reportePDFmes(){
             
    var mes = $("#mes").val();
    var idTrabajador = $('#idTrabajador').val();

window.open('producto/reportes_pdf/pdfNuevo3.php?mes='+mes);
}

function reporteExcel()
{
var mes = $('#mes').val();
var idTrabajador = $('#idTrabajador').val();

    
window.open('producto/reportes_pdf/excelNuevo.php?mes='+mes);
}

    $(document).ready(function(){
        load10();
        load11();
    });

    function load10(page){
        $("#idTipoProducto").change(function(e){
        e.preventDefault();  
        $("#outer_div").empty();  
        var nombreProducto = $("#nombreProducto").val();      
        var idTipoProducto = $("#idTipoProducto").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idTipoProducto":idTipoProducto,"nombreProducto":nombreProducto,"desde":desde,"hasta":hasta};
       
        $.ajax({
            type: "POST",
            url:'producto/reportes/list_producto.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

    function load11(page){
        var nombreProducto = $("#nombreProducto").val();      
        var idTipoProducto = $("#idTipoProducto").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idTipoProducto":idTipoProducto,"nombreProducto":nombreProducto,"desde":desde,"hasta":hasta};
       
        $.ajax({
            type: "POST",
            url:'producto/reportes/list_producto.php',
            data: parametros,      
            success:function(data){             
                $(".outer_div").html(data).fadeIn('slow');              
            }
        })
    
}

/*PRUEBA DE LISTA ULTIMOS INGRESADOS*/
$(document).ready(function() {
    // Llama a la función de carga inicialmente
    loadUltimoscargados();

    // Configura un intervalo para actualizar cada segundo (1000 ms)
    setInterval(function() {
        loadUltimoscargados();
    }, 100);
});

function loadUltimoscargados(page = 1) {
    var nombreProducto = $("#nombreProducto").val();      
    var idTipoProducto = $("#idTipoProducto").val();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var parametros = {
        "action": "ajax",
        "page": page,
        "idTipoProducto": idTipoProducto,
        "nombreProducto": nombreProducto,
        "desde": desde,
        "hasta": hasta,
        "_": new Date().getTime() // Añadir marca de tiempo para evitar caché
    };
   
    $.ajax({
        type: "POST",
        url: 'producto/reportes/list_ultimos_Ingresados.php',
        data: parametros,      
        success: function(data) {             
            $(".outer_div_ultimos_ingresados").html(data).fadeIn('slow');              
        },
        error: function(xhr, status, error) {
            console.error("Error en la carga de datos:", error);
        }
    });
}



 $(document).ready(function(){
        load12();


    });

    function load12(page){
        $("#nombreProducto").keyup(function(e){
        e.preventDefault();  
        $("#outer_div").empty();
        var nombreProducto = $("#nombreProducto").val();      
        var idTipoProducto = $("#idTipoProducto").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"idTipoProducto":idTipoProducto,"nombreProducto":nombreProducto,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'producto/reportes/list_producto.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
} 
$(document).ready(function(){
    load13();


});

function load13(page){
    $("#codigoBarra").keyup(function(e){
    e.preventDefault();  
    $("#outer_div").empty();
    var nombreProducto = $("#nombreProducto").val();      
    var tipoProducto = $("#tipoProducto").val();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var codigoBarra = $("#codigoBarra").val();
    var parametros = {"action":"ajax","page":page,"tipoProducto":tipoProducto,"nombreProducto":nombreProducto,"desde":desde,"hasta":hasta,"codigoBarra":codigoBarra};
   
    $.ajax({
        url:'producto/reportes/list_producto.php',
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
        var nombreProducto = $("#nombreProducto").val();      
        var tipoProducto = $("#tipoProducto").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"tipoProducto":tipoProducto,"nombreProducto":nombreProducto,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'producto/reportes/list_producto.php',
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
        var nombreProducto = $("#nombreProducto").val();      
        var tipoProducto = $("#tipoProducto").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var parametros = {"action":"ajax","page":page,"tipoProducto":tipoProducto,"nombreProducto":nombreProducto,"desde":desde,"hasta":hasta};
       
        $.ajax({
            url:'producto/reportes/list_producto.php',
            data: parametros,
         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });
}
  




