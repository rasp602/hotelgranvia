  function reportePDF1(){
    var idLinea = $('#idLineaCAM').val();
    var camara = $('#camara').val();
    var maquina = $('#maquinaCAM').val();
    window.open('comida/reportes_pdf/list_comida.php?idLinea='+idLinea+'&camara='+camara+'&maquina='+maquina);
}
    $(document).ready(function(){
        load10();
        load11();
    });

    function load10(page){
        $("#nombre").keyup(function(e){
        e.preventDefault();  
        $("#outer_div").empty();   
             
        var id = $("#nombre").val();        

        var parametros = {"action":"ajax","page":page,"nombre":id};
       
        $.ajax({
            type: "POST",
            url:'usuarios/reportes/descripcion.php',
            data: parametros,         
            success:function(data){
            
                $(".outer_div").html(data).fadeIn('slow');
            
            }
        })
    });

}

    function load11(page){
        
        var id = $("#nombre").val();        

        var parametros = {"action":"ajax","page":page,"nombre":id};
        $.ajax({
            type: "POST",
            url:'usuarios/reportes/descripcion.php',
            data: parametros,      
            success:function(data){             
                $(".outer_div").html(data).fadeIn('slow');              
            }
        })
    
}


 



