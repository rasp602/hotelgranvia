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
$fechaFija="2023-01-29";
$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
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
  $validacion='0';                    
                    
/*Consulta si el trabajador existe*/
  $Existe=mysqli_query($con,"SELECT * FROM trabajador where estado = 'A'");
     $rowcount=mysqli_num_rows($Existe);
     while ($row1= mysqli_fetch_array($Existe))
     {
    $idTrabajador=$row1['idTrabajador'];
     $fecha = date('Y-m-d');  

/*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,Fecha,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras,validacion) VALUES ('$idTrabajador','$mañana','$fechaDefecto','$horaCero','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto','$validacion')");
echo '<div class="alert alert-success"><strong>Success!</strong> Registro insertado...!</div>';
date_default_timezone_set("America/Santiago"); 
echo date("l jS \of F Y H:i:s");*/



     }

     error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

$subject = "ronald";// El valor entre corchetes son los atributos name del formulario html
$msg = "Hola el registro fue insertado a la base de datos el dia ".$fecha." a las ".$hora." correctamente";
$from = "rasp602@gmail.com";

// El from DEBE corresponder a una cuenta de correo real creada en el servidor
$headers = "From: rasp602cl@gmail.com.com\r\n"; 
$headers .= "Reply-To: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n"; 
  
if(mail($from, $subject, $msg,$headers)){
  echo "mail enviado";
  }else{
  $errorMessage = error_get_last()['msg'];
  echo $errorMessage;
}
                

?>