<?php
error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en PHP.
session_start();

if (!isset($_SESSION['usuarioInventario'])) {
    exit;
}

// Incluir archivo de configuración de la base de datos
require 'bd/config.php';
date_default_timezone_set("America/Santiago");
// Configuración de la base de datos
$servername = "190.101.222.6";
$username = "hotel";
$password = "chile2023$";
$dbname = "hoteleria";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la fecha actual y la fecha de ayer
$fecha = date('Y-m-d');
$DiaAntes = date("Y-m-d", strtotime($fecha . "-1 days"));

// Función para realizar la consulta y obtener los datos
function consultarComidas($fecha, $hotelId, $conn)
{
    $sql = "SELECT 
        comida.idComida,
        comida.idPersona,
        comida.tipoComida,
        comida.fechaComida,
        comida.horaComida,
        comida.idHospedaje,
        hospedaje.idHospedaje,
        hospedaje.idHabitacion,
        hospedaje.idPersona,
        hospedaje.idHotel,
        hotel.idHotel,
        hotel.nombreHotel,
        COUNT(*) as cantidad
    FROM comida 
    INNER JOIN hospedaje ON comida.idHospedaje=hospedaje.idHospedaje
    INNER JOIN hotel ON hospedaje.idHotel = hotel.idHotel
    WHERE comida.fechaComida = '$fecha' AND hospedaje.idHotel=$hotelId
    GROUP BY comida.tipoComida";

    $result = $conn->query($sql);
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[$row["tipoComida"]] = $row["cantidad"];
    }

    return $data;
}
function consultartodasComidas($conn)
{
//consulta de todas las comida de todos los hoteles por tipo//

$sql1 = "SELECT tipoComida, COUNT(*) as cantidad FROM comida GROUP BY tipoComida";
$result1 = $conn->query($sql1);

  $data1 = array();
  while ($row1 = $result1->fetch_assoc()) {
      $data1[$row1["tipoComida"]] = $row1["cantidad"];
  }
return $data1;
}
//fin de consulta//

// Consultas
$data2 = consultarComidas($DiaAntes, 1, $conn); // Ayer, Hotel H1
$data = consultarComidas($fecha, 1, $conn); // Hoy, Hotel H1
$data1 = consultartodasComidas($conn); // Todas, todos los hoteles
$datah3 = consultarComidas($fecha, 3, $conn); // Hoy, Hotel H3

//consulta semana//

// Obtener la fecha actual y el número de la semana
$today = date('Y-m-d');

$weekNumber = date('W', strtotime($today));
$sqlsemanaDesayuno = "SELECT 
comida.idComida,
comida.idPersona,
comida.tipoComida,
comida.fechaComida,
comida.horaComida,
comida.idHospedaje
FROM comida
WHERE fechaComida >= CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY
  AND fechaComida < CURDATE() - INTERVAL WEEKDAY(CURDATE()) - 1 DAY + INTERVAL 1 WEEK AND comida.tipoComida = 'Desayuno'";

$resultsemana = $conn->query($sqlsemanaDesayuno);
// Verificar si la consulta fue exitosa
if ($resultsemana === false) {
    die("Error en la consulta: " . $conn->error);
}

// Inicializar un array para almacenar los datos por día de la semana
$dataWeekdays = array(
    'Monday' => 0,
    'Tuesday' => 0,
    'Wednesday' => 0,
    'Thursday' => 0,
    'Friday' => 0,
    'Saturday' => 0,
    'Sunday' => 0,
);

// Procesar los resultados de la consulta
while ($rowsemana = $resultsemana->fetch_assoc()) {
    // Obtener el día de la semana de la fecha y aumentar el contador
    $dayOfWeek = date('l', strtotime($rowsemana['fechaComida']));
    $dataWeekdays[$dayOfWeek]++;
}

//CONSULTA SEMANA ALMUERZOS//
$sqlsemanaAlmuerzo = "SELECT 
comida.idComida,
comida.idPersona,
comida.tipoComida,
comida.fechaComida,
comida.horaComida,
comida.idHospedaje
FROM comida
WHERE fechaComida >= CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY
  AND fechaComida < CURDATE() - INTERVAL WEEKDAY(CURDATE()) - 1 DAY + INTERVAL 1 WEEK AND comida.tipoComida = 'Almuerzo'";
$resultsemanaAlmuerzo = $conn->query($sqlsemanaAlmuerzo);
// Verificar si la consulta fue exitosa
if ($resultsemanaAlmuerzo === false) {
    die("Error en la consulta: " . $conn->error);
}

// Inicializar un array para almacenar los datos por día de la semana
$dataWeekdaysAlmuerzo = array(
    'Monday' => 0,
    'Tuesday' => 0,
    'Wednesday' => 0,
    'Thursday' => 0,
    'Friday' => 0,
    'Saturday' => 0,
    'Sunday' => 0,
);

// Procesar los resultados de la consulta
while ($rowsemanaAlmuerzo = $resultsemanaAlmuerzo->fetch_assoc()) {
    // Obtener el día de la semana de la fecha y aumentar el contador
    $dayOfWeek = date('l', strtotime($rowsemanaAlmuerzo['fechaComida']));
    $dataWeekdaysAlmuerzo[$dayOfWeek]++;
}

//CONSULTA SEMANA CENA//
$sqlsemanaCena = "SELECT 
comida.idComida,
comida.idPersona,
comida.tipoComida,
comida.fechaComida,
comida.horaComida,
comida.idHospedaje
FROM comida
WHERE fechaComida >= CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY
  AND fechaComida < CURDATE() - INTERVAL WEEKDAY(CURDATE()) - 1 DAY + INTERVAL 1 WEEK AND comida.tipoComida = 'Cena'";
$resultsemanaCena = $conn->query($sqlsemanaCena);
// Verificar si la consulta fue exitosa
if ($resultsemanaCena === false) {
    die("Error en la consulta: " . $conn->error);
}

// Inicializar un array para almacenar los datos por día de la semana
$dataWeekdaysCena = array(
    'Monday' => 0,
    'Tuesday' => 0,
    'Wednesday' => 0,
    'Thursday' => 0,
    'Friday' => 0,
    'Saturday' => 0,
    'Sunday' => 0,
);

// Procesar los resultados de la consulta
while ($rowsemanaCena = $resultsemanaCena->fetch_assoc()) {
    // Obtener el día de la semana de la fecha y aumentar el contador
    $dayOfWeek = date('l', strtotime($rowsemanaCena['fechaComida']));
    $dataWeekdaysCena[$dayOfWeek]++;
}
//CONSULTA CANTIDAD DE COMIDAS POR MES/
$sqlMesCena = "SELECT 
    comida.idComida,
    comida.idPersona,
    comida.tipoComida,
    comida.fechaComida,
    comida.horaComida,
    comida.idHospedaje
FROM comida
WHERE MONTH(fechaComida) = MONTH(CURDATE())";
$resultMesCena = $conn->query($sqlMesCena);

if ($resultMesCena === false) {
    die("Error en la consulta: " . $conn->error);
}

$dataMonths = array();

while ($rowMesCena = $resultMesCena->fetch_assoc()) {
    $monthYear = date('F', strtotime($rowMesCena['fechaComida']));

    if (!isset($dataMonths[$monthYear])) {
        $dataMonths[$monthYear] = 0;
    }

    $dataMonths[$monthYear]++;
}

// Ahora $dataMonths contiene la cantidad de comidas por tipo para cada mes
echo json_encode($dataMonths);




// Ahora $dataWeekdays contiene la cantidad de comidas por tipo para cada día de la semana
json_encode($dataWeekdays);
json_encode($dataWeekdaysAlmuerzo);
json_encode($dataWeekdaysCena);
// Cerrar conexión


// Convertir a JSON y enviar respuesta
/*header('Content-Type: application/json');*/
json_encode($data);
$conn->close();
?>


<div class="container-fluid">
    <?php include_once 'menu_principal/vista/Menu_Fiscalizador.php'; ?>

    <div class="col-md-6" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">CANTIDAD DE COMIDAS POR TIPO AYER HOTEL H1</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
              </div>
          </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChartayer" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>


    <div class="col-md-6" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS POR TIPO HOY HOTEL H1</h1>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
              </div>
          </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-6" align="center">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">TODAS LAS COMIDAS POR TIPO DEL TODOS LOS HOTELES</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
            </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>     
        </div>
    </div>

    <div class="col-md-6" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS POR TIPO HOY HOTEL H3</h1>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
              </div>
          </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barCharth3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-6" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE DESAYUNOS ESTA SEMANA</h1>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
              </div>
          </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChartsemana" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-6" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE ALMUERZOS ESTA SEMANA</h1>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
              </div>
          </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChartsemanaAlmuerzo" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-6" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE CENAS ESTA SEMANA</h1>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
              </div>
          </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChartsemanaCena" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>   

    <div class="col-md-6" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS POR MES</h1>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
              </div>
          </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChartMes" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>   



</div>

<!--CIERRE DEL DIV PRINCIPAL-->
</div>
<script>
 var data2 = <?php echo json_encode($data2); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
          label: 'Cantidad de comidas por tipo data2',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [data2['Desayuno'] || 0, data2['Almuerzo'] || 0, data2['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartayer').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
  

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
</script>



<script>
 var data = <?php echo json_encode($data); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas por tipo',
          backgroundColor     : 'rgba(255, 99, 71, 1)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [data['Desayuno'] || 0, data['Almuerzo'] || 0, data['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
  

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
</script>


<script>
 var data1 = <?php echo json_encode($data1); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas por tipo',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [data1['Desayuno'] || 0, data1['Almuerzo'] || 0, data1['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart1').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
  

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
</script>



<script>
 var datah3 = <?php echo json_encode($datah3); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
          label: 'Cantidad de comidas por tipo',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [datah3['Desayuno'] || 0, datah3['Almuerzo'] || 0, datah3['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barCharth3').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
  

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
</script>

<script>
    var dataWeekdays = <?php echo json_encode($dataWeekdays); ?>; // Asume que $dataWeekdays contiene los resultados de la consulta por días de la semana

    var areaChartData = {
        labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        datasets: [
            {
                label: 'Cantidad de comidas por tipo',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [
                    dataWeekdays['Monday'] || 0,
                    dataWeekdays['Tuesday'] || 0,
                    dataWeekdays['Wednesday'] || 0,
                    dataWeekdays['Thursday'] || 0,
                    dataWeekdays['Friday'] || 0,
                    dataWeekdays['Saturday'] || 0,
                    dataWeekdays['Sunday'] || 0,
                ]
            }
        ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartsemana').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
</script>

<script>
    var dataWeekdaysAlmuerzo = <?php echo json_encode($dataWeekdaysAlmuerzo); ?>; // Asume que $dataWeekdays contiene los resultados de la consulta por días de la semana

    var areaChartData = {
        labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        datasets: [
            {
                label: 'Cantidad de comidas por tipo',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [
                  dataWeekdaysAlmuerzo['Monday'] || 0,
                  dataWeekdaysAlmuerzo['Tuesday'] || 0,
                  dataWeekdaysAlmuerzo['Wednesday'] || 0,
                  dataWeekdaysAlmuerzo['Thursday'] || 0,
                  dataWeekdaysAlmuerzo['Friday'] || 0,
                  dataWeekdaysAlmuerzo['Saturday'] || 0,
                  dataWeekdaysAlmuerzo['Sunday'] || 0,
                ]
            }
        ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartsemanaAlmuerzo').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
</script>

<script>
    var dataWeekdaysCena = <?php echo json_encode($dataWeekdaysCena); ?>; // Asume que $dataWeekdays contiene los resultados de la consulta por días de la semana

    var areaChartData = {
        labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        datasets: [
            {
                label: 'Cantidad de comidas por tipo',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [
                  dataWeekdaysCena['Monday'] || 0,
                  dataWeekdaysCena['Tuesday'] || 0,
                  dataWeekdaysCena['Wednesday'] || 0,
                  dataWeekdaysCena['Thursday'] || 0,
                  dataWeekdaysCena['Friday'] || 0,
                  dataWeekdaysCena['Saturday'] || 0,
                  dataWeekdaysCena['Sunday'] || 0,
                ]
            }
        ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartsemanaCena').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
</script>

<script>
    var dataMonths = <?php echo json_encode($dataMonths); ?>; // Asume que $dataWeekdays contiene los resultados de la consulta por días de la semana

    var areaChartData = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [
            {
                label: 'Cantidad de comidas por mes',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [
                  dataMonths['January'] || 0,
                  dataMonths['February'] || 0,
                  dataMonths['March'] || 0,
                  dataMonths['April'] || 0,
                  dataMonths['May'] || 0,
                  dataMonths['June'] || 0,
                  dataMonths['July'] || 0,
                  dataMonths['August'] || 0,
                  dataMonths['September'] || 0,
                  dataMonths['Octuber'] || 0,
                  dataMonths['Novembe'] || 0,
                  dataMonths['December'] || 0,

                ]
            }
        ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartMes').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
</script>


    </div>

    <!-- /.content-header -->

    <!-- Main content -->

    <!-- /.content -->

  <!-- /.content-wrapper -->
  

