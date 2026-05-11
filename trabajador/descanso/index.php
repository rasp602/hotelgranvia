	
	<link rel="stylesheet" type="text/css" href="trabajador/descanso/css/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<script type="text/javascript" src="trabajador/descanso/js1/jquery-3.0.0.min.js"></script>
<script src="trabajador/descanso/js1/bootstrap.min.js"></script>



<?php
$trabajador= $_REQUEST['idTrabajador'];

include('config.php');

  $SqlEventos   = ("SELECT * FROM eventoscalendar WHERE idTrabajador = $trabajador");
  $resulEventos = mysqli_query($con, $SqlEventos);

?>



  <form name="formEvento" id="formEvento" action="?c=trabajador&a=DescansoGuardar&idTrabajador=$trabajador" class="form-horizontal" method="POST">
    <div class="form-group">     
      <div class="col-sm-10">
             
      </div>
    </div>  
 <a href="?c=trabajador&a=menuTrabajador" class="nav-link"> Trabajadores</a>
 
     <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>       
     </div>

<div class="row">
   <div class="col-md-1">
  </div>
  <div class="col-md-2">
          
          <div class="col-md-10">
            <h4>Trabajador</h4>

          <select  name="idTrabajador" id="idTrabajador" class="form-control  input-sm selectpicker" data-show-subtext="true" data-live-search="true" readonly>

            <?php
            include "trabajador/descanso/db.php";
            $con = connect();
            if (!$con->set_charset("utf8")) {//asignamos la codificación comprobando que no falle
                   die("Error cargando el conjunto de caracteres utf8");
            }
            $consulta = "SELECT * FROM trabajador where idTrabajador = $trabajador";
            $resultado = mysqli_query($con , $consulta);
            $contador=0;

            while($misdatos = mysqli_fetch_assoc($resultado)){ $contador++;?>
            <option value="<?php echo $misdatos["idTrabajador"]; ?>"data-subtext=""><?php echo $misdatos["nombreTrabajador"]." ".$misdatos["apellidoTrabajador1"]; ?></option>
            <?php }?>          
          </select>  
          </div>

          <div class="col-md-10">  
          <h4>Tipo de Registro</h4>    
            <select name="tipo_evento" id="tipo_evento" class= "form-control input-sm selectpicker">         
                <option value="Descanso">Descanso</option>
                <option value="Licencia">Licencia</option>
                <option value="Vacaciones">Vacaciones</option>
            </select>
          </div>
           <input type="hidden" class="form-control" name="evento" id="evento" value="" placeholder="Nombre del Evento"/>

           <input type="hidden" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Inicio"> 
        <input type="hidden" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="Fecha Final"> 
        <input type="hidden" class="form-control" name="color_evento" id="color_evento" value="#0000FF">
  </div>  

  <div class="col-md-8">
<div id="calendar"></div>
</div>
 <div class="col-md-1">
  </div>  
</div>
  </form>


<div class="container">
  <div class="row">
    <div class="col msjs">
      <?php
        include('trabajador/descanso/msjs.php');
      ?>
    </div>
  </div>
</div>

<?php  
  /*include('modalNuevoEvento.php');*/
  include('modalUpdateEvento.php');
?>




<script src="trabajador/descanso/js1/jquery-3.0.0.min.js"> </script>
<script src="trabajador/descanso/js1/popper.min.js"></script>
<script src="trabajador/descanso/js1/bootstrap.min.js"></script>

<script type="text/javascript" src="trabajador/descanso/js1/moment.min.js"></script>	
<script type="text/javascript" src="trabajador/descanso/js1/fullcalendar.min.js"></script>
<script src='trabajador/descanso/locales/es.js'></script>





<script type="text/javascript">
$(document).ready(function() {
  $("#calendar").fullCalendar({
    header: {
      left: "prev,next today",
      center: "title",
      right: "month,agendaWeek,agendaDay"
    },

    locale: 'es',

    defaultView: "month",
    navLinks: true, 
    editable: true,
    eventLimit: true, 
    selectable: true,
    selectHelper: false,

//Nuevo Evento
  select: function(start, end){
      $("#exampleModal").modal();
      $("input[name=fecha_inicio]").val(start.format('DD-MM-YYYY'));
       
      var valorFechaFin = end.format("DD-MM-YYYY");
      var F_final = moment(valorFechaFin, "DD-MM-YYYY").subtract(0, 'days').format('DD-MM-YYYY'); //Le resto 1 dia
      $('input[name=fecha_fin').val(F_final);  
    },
      
    events: [
      <?php
       while($dataEvento = mysqli_fetch_array($resulEventos)){ ?>
          {
          _id: '<?php echo $dataEvento['id']; ?>',
          idTrabajador: '<?php echo $dataEvento['idTrabajador']; ?>',
          title: '<?php echo $dataEvento['evento']; ?>',
          start: '<?php echo $dataEvento['fecha_inicio']; ?>',
          end:   '<?php echo $dataEvento['fecha_fin']; ?>',
          color: '<?php echo $dataEvento['color_evento']; ?>'
          },
        <?php } ?>
    ],


//Eliminar Evento
eventRender: function(event, element) {
    element
      .find(".fc-content")
      .prepend("<span id='btnCerrar'; class='closeon material-icons'>&#xe5cd;</span>");
    
    //Eliminar evento
    element.find(".closeon").on("click", function() {

  var pregunta = confirm("Deseas Borrar este Evento?");   
  if (pregunta) {

    $("#calendar").fullCalendar("removeEvents", event._id);

     $.ajax({
            type: "POST",
            url: 'trabajador/descanso/deleteEvento.php',
            data: {id:event._id},
            success: function(datos)
            {
              $(".alert-danger").show();

              setTimeout(function () {
                $(".alert-danger").slideUp(500);
              }, 3000); 

            }
        });
      }
    });
  },


//Moviendo Evento Drag - Drop
eventDrop: function (event, delta) {
  var idEvento = event._id;
  var start = (event.start.format('DD-MM-YYYY'));
  var end = (event.start.format("DD-MM-YYYY"));

    $.ajax({
        url: 'trabajador/descanso/drag_drop_evento.php',
        data: 'start=' + start + '&end=' + end + '&idEvento=' + idEvento,
        type: "POST",
        success: function (response) {
         // $("#respuesta").html(response);
        }
    });
},

//Modificar Evento del Calendario 
eventClick:function(event){
    var idEvento = event._id;
    $('input[name=idEvento').val(idEvento);
    $('input[name=evento').val(event.title);
    $('input[name=fecha_inicio').val(event.start.format('DD-MM-YYYY'));
    $('input[name=fecha_fin').val(event.end.format('DD-MM-YYYY'));

    $("#modalUpdateEvento").modal();
  },


  });


//Oculta mensajes de Notificacion
  setTimeout(function () {
    $(".alert").slideUp(300);
  }, 3000); 


});




</script>

<!--------- WEB DEVELOPER ------>
<!--------- URIAN VIERA   ----------->
<!--------- PORTAFOLIO:  https://blogangular-c7858.web.app  -------->

</body>

