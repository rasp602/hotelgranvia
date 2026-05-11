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
///////////////////////////////////conexion h1//////////////
$servername = "190.162.46.97";
$username = "hotel";
$password = "chile2023$";
$dbname = "hoteleria";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////conexion h2//////////////////
$servernameh2 = "190.101.222.123";
$usernameh2 = "rasph3";
$passwordh2 = "Rodri2410$";
$dbnameh2 = "hoteleria";

// Crear conexión
$conexionh2 = new mysqli($servernameh2, $usernameh2, $passwordh2, $dbnameh2);

// Verificar conexión
if ($conexionh2->connect_error) {
    die("Conexión fallida: " . $conexionh2->connect_error);
    
}

/////////////////////////////////////////////////////////////////////

//////////////////////////////////////conexion h3//////////////////
$servernameh3 = "190.101.222.123";
$usernameh3 = "rasph3";
$passwordh3 = "Rodri2410$";
$dbnameh3 = "hoteleria";

// Crear conexión
$conexionh3 = new mysqli($servernameh3, $usernameh3, $passwordh3, $dbnameh3);

// Verificar conexión
if ($conexionh3->connect_error) {
    die("Conexión fallida: " . $conexionh3->connect_error);
    
}

/////////////////////////////////////////////////////////////////////

//////////////////////////////////////conexion h4//////////////////
$servernameh4 = "190.44.59.220";
$usernameh4 = "rasph4";
$passwordh4 = "Rodri2410$";
$dbnameh4 = "hoteleria";

// Crear conexión
$conexionh4 = new mysqli($servernameh4, $usernameh4, $passwordh4, $dbnameh4);

// Verificar conexión
if ($conexionh4->connect_error) {
    die("Conexión fallida: " . $conexionh4->connect_error);
    
}

/////////////////////////////////////////////////////////////////////

//////////////////////////////////////conexion H1B//////////////////
$servernameh4 = "190.162.46.97";
$usernameh4 = "hotel";
$passwordh4 = "chile2023$";
$dbnameh4 = "hoteleria";

// Crear conexión
$conexionh4 = new mysqli($servernameh4, $usernameh4, $passwordh4, $dbnameh4);

// Verificar conexión
if ($conexionh4->connect_error) {
    die("Conexión fallida: " . $conexionh4->connect_error);
    
}

/////////////////////////////////////////////////////////////////////
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

function consultarComidasayer($DiaAntes, $hotelId, $conn)
{
    $sql2 = "SELECT 
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
    WHERE comida.fechaComida = '$DiaAntes' AND hospedaje.idHotel=$hotelId
    GROUP BY comida.tipoComida";

    $result = $conn->query($sql2);
    $datah2 = array();

    while ($row2 = $result->fetch_assoc()) {
        $datah2[$row2["tipoComida"]] = $row2["cantidad"];
    }

    return $datah2;
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


function consultarComidasExtra($fecha, $conn)
{
    $sqlExtra = "SELECT 
    comidaextra.idComidaextra,
    comidaextra.fechaComida,
    comidaextra.horaComida,
    comidaextra.tipoComida,
    comidaextra.persona,
    comidaextra.idEmpresa,
    COUNT(*) as cantidad
FROM comidaextra 
WHERE comidaextra.fechaComida = '$fecha'
GROUP BY comidaextra.tipoComida";

    $resultExtrah1 = $conn->query($sqlExtra);
    $dataExth1 = array();

    while ($rowExth1 = $resultExtrah1->fetch_assoc()) {
        $dataExth1[$rowExth1["tipoComida"]] = $rowExth1["cantidad"];
    }

    return $dataExth1;
}

function consultarComidaServidasH5($fecha, $conn)
{
    $sqlServidaH5 = "SELECT 
    comidaservida.tipoComida,
    comidaservida.fechaComida,
    sum(cantidad) as cantidad
FROM comidaservida 
WHERE comidaservida.fechaComida = '$fecha' and comidaservida.idHotel= 5
GROUP BY comidaservida.tipoComida";

    $resultservidah5 = $conn->query($sqlServidaH5);
    $dataServidah5 = array();

    while ($rowServidah5 = $resultservidah5->fetch_assoc()) {
        $dataServidah5[$rowServidah5["tipoComida"]] = $rowServidah5["cantidad"];
    }

    return $dataServidah5;
}

//fin de consulta//

// Consultas COMIDAS
$data2 = consultarComidas($DiaAntes, 1, $conn); // Ayer, Hotel H1
$datah1 = consultarComidas($fecha, 1, $conn); // Hoy, Hotel H1
$data1 = consultartodasComidas($conn); // Todas, todos los hoteles



$data = consultarComidas($DiaAntes, 1, $conn); // Ayer, Hotel H1

$dataH1BAYER = consultarComidas($DiaAntes, 25, $conn); // Ayer, Hotel H1B
$dataH1B = consultarComidas($fecha, 25, $conn); // Hoy, Hotel H1B

$data = consultarComidas($DiaAntes, 1, $conn); // Ayer, Hotel H1


$datah2ayer = consultarComidasayer($DiaAntes, 2, $conexionh3); // Ayer, Hotel H2
$datah2 = consultarComidas($fecha, 2, $conexionh3); // Hoy, Hotel H2

$datah3ayer = consultarComidasayer($DiaAntes, 3, $conexionh3); // Ayer, Hotel H3
$datah3 = consultarComidas($fecha, 3, $conexionh3); // Hoy, Hotel H3

$datah4ayer = consultarComidasayer($DiaAntes, 4, $conexionh4); // Ayer, Hotel H4
$datah4 = consultarComidas($fecha, 4, $conexionh4); // Hoy, Hotel H4

// Consultas COMIDAS EXTRAS

$dataExtrah1  = consultarComidasExtra($fecha,$conn); // Extra del H1

$dataExtraH1B  = consultarComidasExtra($fecha,$conn); // Extra del H1B
$dataExtrah2  = consultarComidasExtra($fecha,$conexionh2); // Extra del H2
$dataExtrah3 = consultarComidasExtra($fecha,$conexionh3); // Extra del H3
$dataExtrah4 = consultarComidasExtra($fecha,$conexionh4); // Extra del H4


// Consultas COMIDAS SERVIDAS
$dataServidah5 = consultarComidaServidasH5($fecha,$conn); // Extra del H5
$dataServidaAyerh5 = consultarComidaServidasH5($DiaAntes,$conn); // Extra del H5




/////////////////////////////consulta semana/////////////////////////////////////

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
 json_encode($dataMonths);




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


       
<?php 
          $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                                echo "hola usuario";
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                                echo "hola Fiscalizador";
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
                        if ($usuario->nivel == "I") 
                        {
                                echo "hola Inventario";
                                include_once 'menu_principal/vista/Menu_Inventario.php';   
                        } 
               }          
         ?> 


    <div class="col-md-4" align="center">
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


    <div class="col-md-4" align="center">
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
    
    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS EXTRAS POR TIPO HOY HOTEL H1</h1>
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
            <canvas id="barChartExtrah1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>


<div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">CANTIDAD DE COMIDAS POR TIPO AYER HOTEL H1B</h3>
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
            <canvas id="barChartayerH1B" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>


    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS POR TIPO HOY HOTEL H1B</h1>
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
            <canvas id="barChartH1B" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>
    
    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS EXTRAS POR TIPO HOY HOTEL H1B</h1>
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
            <canvas id="barChartExtraH1B" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">CANTIDAD DE COMIDAS POR TIPO AYER HOTEL H2</h3>
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
            <canvas id="barChartayerH2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

  <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS POR TIPO HOY HOTEL H2</h1>
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
            <canvas id="barCharth2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>




    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS EXTRAS POR TIPO HOY HOTEL H2</h1>
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
            <canvas id="barChartExtrah2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>











    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">CANTIDAD DE COMIDAS POR TIPO AYER HOTEL H3</h3>
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
            <canvas id="barChartayerH3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-4" align="center">
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

    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS EXTRAS POR TIPO HOY HOTEL H3</h1>
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
            <canvas id="barChartExtrah3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">CANTIDAD DE COMIDAS POR TIPO AYER HOTEL H4</h3>
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
            <canvas id="barChartayerH4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS POR TIPO HOY HOTEL H4</h1>
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
            <canvas id="barCharth4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    
    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS EXTRAS POR TIPO HOY HOTEL H4</h1>
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
            <canvas id="barChartExtrah4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>

    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">CANTIDAD DE COMIDAS SERVIDAS POR TIPO AYER HOTEL H5</h3>
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
            <canvas id="barChartayerH5" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>             
      </div>
    </div>
    
    <div class="col-md-4" align="center">
      <div class="card card-success">
          <div class="card-header">
            <h1 class="card-title">CANTIDAD DE COMIDAS SERVIDAS POR TIPO HOY HOTEL H5</h1>
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
            <canvas id="barChartServidah5" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
          label: 'Cantidad de comidas por tipo',
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



<!------------------------HOY H1---------------------------------->

<script>
 var datah1 = <?php echo json_encode($datah1); ?>;
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
           data: [datah1['Desayuno'] || 0, datah1['Almuerzo'] || 0, datah1['Cena'] || 0]
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
<!------------------------------------------------------------------->
<!------------------------HOY EXTRA H1---------------------------------->

<script>
 var dataExtrah1 = <?php echo json_encode($dataExtrah1); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas Extra por tipo',
          backgroundColor     : 'rgba(180, 30, 55, 1)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [dataExtrah1['Desayuno'] || 0, dataExtrah1['Almuerzo'] || 0, dataExtrah1['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartExtrah1').get(0).getContext('2d')
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
<!-------------------------------AYER H1B------------------------------------>
<script>
 var dataH1BAYER = <?php echo json_encode($dataH1BAYER); ?>;
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
           data: [dataH1BAYER['Desayuno'] || 0, dataH1BAYER['Almuerzo'] || 0, dataH1BAYER['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartayerH1B').get(0).getContext('2d')
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



<!------------------------HOY H1B---------------------------------->

<script>
 var dataH1B = <?php echo json_encode($dataH1B); ?>;
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
           data: [dataH1B['Desayuno'] || 0, dataH1B['Almuerzo'] || 0, dataH1B['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartH1B').get(0).getContext('2d')
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
<!------------------------------------------------------------------->
<!------------------------HOY EXTRA H1B---------------------------------->

<script>
 var dataExtraH1B = <?php echo json_encode($dataExtraH1B); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas Extra por tipo',
          backgroundColor     : 'rgba(180, 30, 55, 1)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [dataExtraH1B['Desayuno'] || 0, dataExtraH1B['Almuerzo'] || 0, dataExtraH1B['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartExtraH1B').get(0).getContext('2d')
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

<!--------------------------H1B----------------------------------------->


<!--------------------------H2----------------------------------------->
<script>
 var datah2ayer = <?php echo json_encode($datah2ayer); ?>;
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
           data: [datah2ayer['Desayuno'] || 0, datah2ayer['Almuerzo'] || 0, datah2ayer['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartayerH2').get(0).getContext('2d')
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

<!------------------------HOY H2---------------------------------->

<script>
 var datah2 = <?php echo json_encode($datah2); ?>;
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
           data: [datah2['Desayuno'] || 0, datah2['Almuerzo'] || 0, datah2['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barCharth2').get(0).getContext('2d')
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






<!------------------------HOY EXTRA H2---------------------------------->
<script>
 var dataExtrah2 = <?php echo json_encode($dataExtrah2); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas Extra por tipo',
          backgroundColor     : 'rgba(180, 30, 55, 1)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [dataExtrah2['Desayuno'] || 0, dataExtrah2['Almuerzo'] || 0, dataExtrah2['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartExtrah2').get(0).getContext('2d')
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

<!------------------------------------------------------------------->


<!------------------------HOY EXTRA H3---------------------------------->

<script>
 var dataExtrah3 = <?php echo json_encode($dataExtrah3); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas Extra por tipo',
          backgroundColor     : 'rgba(180, 30, 55, 1)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [dataExtrah3['Desayuno'] || 0, dataExtrah3['Almuerzo'] || 0, dataExtrah3['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartExtrah3').get(0).getContext('2d')
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
<!------------------------------------------------------------------->
<!------------------------HOY EXTRA H4---------------------------------->

<script>
 var dataExtrah4 = <?php echo json_encode($dataExtrah4); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas Extra por tipo',
          backgroundColor     : 'rgba(180, 30, 55, 1)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [dataExtrah4['Desayuno'] || 0, dataExtrah4['Almuerzo'] || 0, dataExtrah4['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartExtrah4').get(0).getContext('2d')
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
<!------------------------------------------------------------------->

<!------------------------HOY SERVIDA H5---------------------------------->

<script>
 var dataServidah5 = <?php echo json_encode($dataServidah5); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas Servidas por tipo',
           backgroundColor     : 'rgba(255, 99, 71, 1)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [dataServidah5['Desayuno'] || 0, dataServidah5['Almuerzo'] || 0, dataServidah5['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartServidah5').get(0).getContext('2d')
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
<!------------------------------------------------------------------->


<!------------------------AYER SERVIDA H5---------------------------------->

<script>
 var dataServidaAyerh5 = <?php echo json_encode($dataServidaAyerh5); ?>;
      var areaChartData = {
          labels: ['Desayuno', 'Almuerzo', 'Cena'],
      datasets: [
        {
           label: 'Cantidad de comidas Servidas por tipo',
           backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
           data: [dataServidaAyerh5['Desayuno'] || 0, dataServidaAyerh5['Almuerzo'] || 0, dataServidaAyerh5['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartayerH5').get(0).getContext('2d')
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
<!------------------------------------------------------------------->
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
          backgroundColor     : 'rgba(255, 99, 71, 1)',
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
 var datah3ayer = <?php echo json_encode($datah3ayer); ?>;
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
           data: [datah3ayer['Desayuno'] || 0, datah3ayer['Almuerzo'] || 0, datah3ayer['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartayerH3').get(0).getContext('2d')
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
 var datah4 = <?php echo json_encode($datah4); ?>;
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
           data: [datah4['Desayuno'] || 0, datah4['Almuerzo'] || 0, datah4['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barCharth4').get(0).getContext('2d')
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
 var datah4ayer = <?php echo json_encode($datah4ayer); ?>;
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
           data: [datah4ayer['Desayuno'] || 0, datah4ayer['Almuerzo'] || 0, datah4ayer['Cena'] || 0]
        }
      ]
    }
      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChartayerH4').get(0).getContext('2d')
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
  

