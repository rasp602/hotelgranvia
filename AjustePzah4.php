<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
// Array with names

// get the q parameter from URL
$fecha = date('Y-m-d');
$mañana=date("Y-m-d",strtotime($fecha."+ 1 days")); 

//$con = mysqli_connect('localhost','root','','hoteleria');

require('bd/conexionLocalh4.php');//h2
//$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// lookup all hints from array if $q is different from ""

  date_default_timezone_set("America/Santiago");
 
  $hora=date('H:i:s');
  $fecha = date('Y-m-d');
  $horaCero="00:00:00";
  $fechaDefecto="0000-00-00";
  $salidaDefecto="00:00:00";
  $horasTrabajadasDefecto='0';
  $horasExtrasDefecto='0';
  $ayer=date("Y-m-d",strtotime($fecha."- 1 days"));  
             
 /*VERIFICA SI HAY HOSPEDAJES NUEVOS*/
  $ExisteH=mysqli_query($con,"SELECT 
  hospedaje.idHospedaje,
  hospedaje.idPersona,
  hospedaje.idHotel,
  hospedaje.idHabitacion,
  hospedaje.idCama,
  hospedaje.desde,
  hospedaje.hasta,
  hospedaje.estado,
  hospedaje.fechaDespedida,
  hospedaje.horaDespedida,
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
  persona.idContrato,
  empresa.idEmpresa,
  empresa.nombreEmpresa
FROM 
  hospedaje
INNER JOIN 
  hotel ON hospedaje.idHotel = hotel.idHotel
INNER JOIN 
  habitacion ON hospedaje.idHabitacion = habitacion.idHabitacion
INNER JOIN 
  cama ON hospedaje.idCama = cama.idCama 
INNER JOIN 
  persona ON hospedaje.idPersona = persona.idPersona 
INNER JOIN 
  empresa ON persona.idEmpresa = empresa.idEmpresa 
WHERE 

  hospedaje.estado = 'I' 
  AND hospedaje.idHotel = 4 
  AND cama.estadoCama = 'I' 
  AND cama.idCama NOT IN (
      SELECT 
          hospedaje.idCama
      FROM 
          hospedaje
      WHERE 
          estado = 'A' 
       
     
  ) GROUP BY hospedaje.idHabitacion");

     $rowcount=mysqli_num_rows($ExisteH);
     while ($rowExisteH= mysqli_fetch_array($ExisteH))
     {       
 
       $idHospedaje=$rowExisteH['idHospedaje'];
       $idPersona=$rowExisteH['idPersona'];
       $idHotel=$rowExisteH['idHotel'];
       $idHabitacion=$rowExisteH['idHabitacion'];
       $idCama=$rowExisteH['idCama'];
       $desde=$rowExisteH['desde'];
       $hasta=$rowExisteH['hasta'];
       $estado=$rowExisteH['estado'];
       $fechaDespedida=$rowExisteH['fechaDespedida'];
       $horaDespedida=$rowExisteH['horaDespedida'];
       $cantidad=$rowExisteH['cantidad'];
      
  



       $actualizarCamaH2=mysqli_query($con,"UPDATE cama SET estadoCama = 'A' WHERE idCama ='$idCama'");

       echo $idHabitacion."\n";


    }
//ELIMINAR REGISTROS DUPLICADOS EN LA TABLA COMIDA DEL HOTEL H4
$ElimiarDuplicadosH4=mysqli_query($con,"DELETE c1
FROM comida c1
INNER JOIN comida c2 ON 
    c1.idComida < c2.idComida AND 
    c1.idPersona = c2.idPersona AND
    c1.tipoComida = c2.tipoComida AND
    c1.fechaComida = c2.fechaComida AND
    c1.horaComida = c2.horaComida AND
    c1.idHospedaje = c2.idHospedaje");
  echo '<div class="alert alert-success"><strong>Success!</strong> Registro duplicados eliminados HOTEL H4...!</div>';











    

?>