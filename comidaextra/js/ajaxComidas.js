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
        url: 'comida/reportes/list_ultimos_Ingresados.php',
        data: parametros,      
        success: function(data) {             
            $(".outer_div_ultimos_ingresados").html(data).fadeIn('slow');              
        },
        error: function(xhr, status, error) {
            console.error("Error en la carga de datos:", error);
        }
    });
}

/*PRUEBA DE LISTA ULTIMOS INGRESADOS*/
$(document).ready(function() {
    // Llama a la función de carga inicialmente
    loadUltimosrutcargados();

    // Configura un intervalo para actualizar cada segundo (1000 ms)
    setInterval(function() {
        loadUltimosrutcargados();
    }, 100);
});

function loadUltimosrutcargados(page = 1) {
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
        url: 'comida/reportes/list_ultimos_Rut_Ingresados.php',
        data: parametros,      
        success: function(data) {             
            $(".outer_div_ultimos_Rut_ingresados").html(data).fadeIn('slow');              
        },
        error: function(xhr, status, error) {
            console.error("Error en la carga de datos:", error);
        }
    });
}











