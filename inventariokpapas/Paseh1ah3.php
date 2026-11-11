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
require('bd/conexionLocal.php');
require('bd/conexionLocalh3.php');
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
  $ExisteH=mysqli_query($con,"SELECT * FROM hospedaje where desde = '$fecha' and estado = 'A'");
     $rowcount=mysqli_num_rows($ExisteH);
     while ($rowExisteH= mysqli_fetch_array($ExisteH))
     {
       $idPersona=$rowExisteH['idPersona'];
       $idHotel=$rowExisteH['idHotel'];
       $idHabitacion=$rowExisteH['idHabitacion'];
       $idCama=$rowExisteH['idCama'];
       $desde=$rowExisteH['desde'];
       $hasta=$rowExisteH['hasta'];
       $estado=$rowExisteH['estado'];
       $tipohabitacion=$rowExisteH['tipohabitacion'];
      // $idHospedaje=$rowExisteH['idHospedaje'];

       $CapacidadH=mysqli_query($con,"SELECT * FROM habitacion where idHabitacion = '$idHabitacion'");
       $rowcount=mysqli_num_rows($CapacidadH);
       while ($row2= mysqli_fetch_array($CapacidadH))
       {
        $idHabitacionR=$row2['idHabitacion'];
        $capacidadHabitacionR=$row2['capacidadHabitacion'];
        $mas='1';
        $CapacidadTotal=$capacidadHabitacionR+$mas;

        $actualizarCapacidad=mysqli_query($con,"UPDATE habitacion SET capacidadHabitacion = '$CapacidadTotal' WHERE idHabitacion ='$idHabitacionR'");
        
        echo '<div class="alert alert-success"><strong>Success!</strong> Registro Actualizado...!</div>';
        date_default_timezone_set("America/Santiago"); 
        echo date("l jS \of F Y H:i:s");
       }

       $idHospedaje=$rowExisteH['idHospedaje'];
       $idCama=$rowExisteH['idCama'];
       $estado='I';
       $estadoCama='A';
       $actualizarEstado=mysqli_query($con,"UPDATE hospedaje SET estado = '$estado' WHERE idHospedaje ='$idHospedaje'");
       $actualizarCama=mysqli_query($con,"UPDATE cama SET estadoCama = '$estadoCama' WHERE idCama ='$idCama'");

       $actualizarDespedida=mysqli_query($con,"UPDATE hospedaje SET fechaDespedida='$fecha' ,horaDespedida='$hora' WHERE idHospedaje ='$idHospedaje'");  

    }
                   
/*CREA UN NUEVO RESUMEN DE HOSPEDAJE PARA LOS ACTIVOS CON FECHA DE SALIDA MAYOR A MAÑANA*/
 $mañana=date("Y-m-d",strtotime($fecha."+ 1 days"));
  $Existe=mysqli_query($con,"SELECT  
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
        hospedaje.tipoHabitacion,

        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.rutPersona,

        empresa.idEmpresa,
        empresa.nombreEmpresa,
        empresa.horaSalida
        
        FROM hospedaje
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
        where hospedaje.estado = 'A' and hospedaje.hasta > '$mañana'");
     $rowcount=mysqli_num_rows($Existe);
     while ($row1= mysqli_fetch_array($Existe))
     {
    date_default_timezone_set("America/Santiago"); 
    $idHospedaje=$row1['idHospedaje'];
    $hasta=$row1['hasta'];   
    $fecha = date('Y-m-d');  
    $Act='1';    
    $InsertarMañana=mysqli_query($con,"INSERT INTO `resumenhospedaje`(idHospedaje,FechaR,Act) VALUES ('$idHospedaje','$mañana','$Act')");  
    echo '<div class="alert alert-success"><strong>Success!</strong> Registro insertado...!</div>';
    date_default_timezone_set("America/Santiago"); 
    echo date("l jS \of F Y H:i:s");
      }

/*CREA UN NUEVO RESUMEN DE HOSPEDAJE PARA LOS QUE SE PASARON DE LA HORA DE SALIDA*/
  $Existe2=mysqli_query($con,"SELECT  
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
        hospedaje.tipoHabitacion,

        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.rutPersona,

        empresa.idEmpresa,
        empresa.nombreEmpresa,
        empresa.horaSalida
        
        FROM hospedaje
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
        where hospedaje.estado = 'I' and hospedaje.horaDespedida > empresa.horaSalida and hospedaje.fechaDespedida = '$fecha'");
     $rowcount2=mysqli_num_rows($Existe2);
     while ($row2= mysqli_fetch_array($Existe2))
     {
    date_default_timezone_set("America/Santiago"); 
    $idHospedaje2=$row2['idHospedaje'];
    $hasta=$row2['hasta'];
    $mañana=date("Y-m-d",strtotime($fecha."+ 1 days"));
    $fecha = date('Y-m-d');  
    $Act='1'; 
  

$Insertar=mysqli_query($con,"INSERT INTO `resumenhospedaje`(idHospedaje,FechaR,Act) VALUES ('$idHospedaje2','$fecha','$Act')");
echo '<div class="alert alert-success"><strong>Success!</strong> Registro insertado...!</div>';
date_default_timezone_set("America/Santiago"); 
echo date("l jS \of F Y H:i:s");
      }


error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
$mañana=date("Y-m-d",strtotime($fecha."+ 1 days")); 
$subject = "ronald";// El valor entre corchetes son los atributos name del formulario html
$msg = "Hola el registro de hospedaje fue insertado a la base de datos el dia ".$fecha." a las ".$hora." correctamente los datos de mañana ".$mañana."";
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