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
  //$fecha = date('Y-m-d');
  $horaCero="00:00:00";
  $fechaDefecto="0000-00-00";
  $salidaDefecto="00:00:00";
  $horasTrabajadasDefecto='0';
  $horasExtrasDefecto='0';
  $DiaAntes=date("Y-m-d",strtotime($fecha."- 1 days"));                  
                    
/*Consulta si el trabajador existe*/
  $ExisteH=mysqli_query($con,"SELECT * FROM hospedaje where hasta = '$DiaAntes'");
     $rowcount=mysqli_num_rows($ExisteH);
     while ($row1= mysqli_fetch_array($ExisteH))
     {
       $idHabitacion=$row1['idHabitacion'];
       $idHospedaje=$row1['idHospedaje'];

       $CapacidadH=mysqli_query($con,"SELECT * FROM habitacion where idHabitacion = '$idHabitacion'");
       $rowcount=mysqli_num_rows($CapacidadH);
       while ($row2= mysqli_fetch_array($CapacidadH))
       {
        $idHabitacion=$row2['idHabitacion'];
        $capacidadHabitacion=$row2['capacidadHabitacion'];
        $mas='1';
        $CapacidadTotal=$capacidadHabitacion+$mas;
        $actualizarCapacidad=mysqli_query($con,"UPDATE habitacion SET capacidadHabitacion = '$CapacidadTotal' WHERE idHabitacion ='$idHabitacion'");
        
        echo '<div class="alert alert-success"><strong>Success!</strong> Registro Actualizado...!</div>';
        date_default_timezone_set("America/Santiago"); 
        echo date("l jS \of F Y H:i:s");
       }
       $idHospedaje=$row1['idHospedaje'];
       $idCama=$row1['idCama'];
       $estado='I';
       $estadoCama='A';
       $actualizarEstado=mysqli_query($con,"UPDATE hospedaje SET estado = '$estado' WHERE idHospedaje ='$idHospedaje'");
       $actualizarCama=mysqli_query($con,"UPDATE cama SET estadoCama = '$estadoCama' WHERE idCama ='$idCama'");

       $actualizarDespedida=mysqli_query($con,"UPDATE hospedaje SET fechaDespedida='$fecha' ,horaDespedida='$hora' WHERE idHospedaje ='$idHospedaje'");  

    }


/*Enviar Correo*/
 
                

?>