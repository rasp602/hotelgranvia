
var $j = jQuery.noConflict();
$(document).ready(function() {
    // Cuando la página se carga, inicializa el ComboBox con la capacidad de búsqueda
    $('#personas').select2({
        ajax: {
            url: 'hospedaje/vista/obtener_personas.php',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // Parámetro de búsqueda
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 1 // Número mínimo de caracteres antes de realizar la búsqueda
    });
});