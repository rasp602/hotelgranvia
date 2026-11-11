<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
// Array with names

// get the q parameter from URL
$q = $_REQUEST['q'];

$fecha = date('Y-m-d');
//$hint = "";
//require('bd/conexionLocalDirecta.php');
require('bd/conexionLocal.php');
/*$con = mysqli_connect('localhost','root','','hoteleria');
//$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/
// lookup all hints from array if $q is different from ""
if ($q !="") 

{

      date_default_timezone_set("America/caracas"); 
      $hora=date('H:i:s');

      //$consultaEstado=mysqli_query($con,"SELECT * FROM persona WHERE persona.qrPersona ='".$q."'");

     $consultaEstado=mysqli_query($con,"SELECT * FROM persona WHERE persona.qrPersona = ".$q."");

      $rowcount1=mysqli_num_rows($consultaEstado);

 if($rowcount1)
    {
          while($row = mysqli_fetch_array($consultaEstado))
        {  
                $nombre= $row['nombresPersona'];
                $apellido= $row['apellidoPersona1'];
                $idPersona= $row['idPersona'];


        echo $nombre." ".$apellido ;

        }
           
$consultaUltimoIdHospedaje=mysqli_query($con,"SELECT 
        
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
        habitacion.capacidadReal,
       
        
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
        empresa.nombreEmpresa,
        MAX(hospedaje.idHospedaje)

        
        FROM hospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa        
        where persona.qrPersona ='$q' and hospedaje.estado = 'I'");

while($row1 = mysqli_fetch_array($consultaUltimoIdHospedaje))
        {  
                 $idHospedaje= $row1['MAX(hospedaje.idHospedaje)'];
           

         
      
 
$consultaUltimaHab=mysqli_query($con,"SELECT 
        
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
        habitacion.capacidadReal,
       
        
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
        empresa.nombreEmpresa,
        MAX(hospedaje.idHospedaje)

        
        FROM hospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa        
        where hospedaje.idHospedaje ='$idHospedaje'");

while($row2 = mysqli_fetch_array($consultaUltimaHab))
        {  
                $habitacion= $row2['nHabitacion'];
 echo "<br>";
       echo "Ultima habitación : ".$habitacion;

        }

    }
}






else {
        echo '<div class="alert alert-warning"><strong>Alerta!</strong> Persona no existe en nuestros registros...</div>';

     }




}

?>