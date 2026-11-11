<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
// Array with names

// get the q parameter from URL
$q = $_REQUEST["q"];

$mystring = $q;

$codigo=mb_strlen($mystring);


$fecha = date('Y-m-d');
$DiaAntes=date("Y-m-d",strtotime($fecha."- 1 days")); 
//$hint = "";


    $q = $_REQUEST["q"];
    date_default_timezone_set("America/Santiago");
    $hora=date('H:i:s');
    $fecha = date('Y-m-d');
    echo '<div class="alert alert-warning"><strong>Despedida de un huespede...</strong></div>';
  

  /*Conexion*/
//$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
require('bd/conexionLocal.php');
//$con = mysqli_connect('localhost','root','','hoteleria');

//$con = mysqli_connect('200.74.49.175','root','','hoteleria');

// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
/*Fin Conexion*/

$ExisteHospedaje=mysqli_query($con,"SELECT 
        
        hospedaje.idHospedaje,
        hospedaje.idPersona,
        hospedaje.idHotel,
        hospedaje.idHabitacion,
        hospedaje.idCama,
        hospedaje.desde,
        hospedaje.hasta,
        hospedaje.estado,

        hotel.idHotel,
        hotel.nombreHotel,
        hotel.capacidadHotel,
        hotel.direccion,

        habitacion.idHabitacion,
        habitacion.idHotel,
        habitacion.nHabitacion,
        habitacion.capacidadHabitacion,
       
        
        cama.idCama,
        cama.idHabitacion,
        cama.nCama,
        cama.estadoCama,

        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.rutPersona,
        persona.qrPersona,

        empresa.idEmpresa,
        empresa.nombreEmpresa

        
        FROM hospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa        
        where persona.qrPersona ='$q' and hospedaje.estado = 'A'");
     $rowcount=mysqli_num_rows($ExisteHospedaje);
     if ($row1= mysqli_fetch_array($ExisteHospedaje))
     {
        $idHospedaje= $row1['idHospedaje'];
        $idHabitacion=$row1['idHabitacion'];
        $idCama=$row1['idCama'];
        $capacidadHabitacion=$row1['capacidadHabitacion'];
        $mas=1;
        $nuevaCapacidadHabitacion=$capacidadHabitacion+$mas;
        $inactivo='I';
        $estadoCama='A';
        
        $actualizarDespedida=mysqli_query($con,"UPDATE hospedaje SET estado = '$inactivo',fechaDespedida='$fecha' ,horaDespedida='$hora' WHERE idHospedaje ='$idHospedaje'");  

        //FALTA ACTUALIZAR CAMA
        $actualizarCama=mysqli_query($con,"UPDATE cama SET estadoCama = '$estadoCama' WHERE idCama ='$idCama'");

        //FALTA ACTUALIZAR LA HABITACION 
        $actualizarHabitacion=mysqli_query($con,"UPDATE habitacion SET capacidadHabitacion = '$nuevaCapacidadHabitacion' WHERE idHabitacion ='$idHabitacion'");


     }

?>