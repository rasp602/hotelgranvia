<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
// Array with names

// get the q parameter from URL
$q = $_REQUEST["q"];
$fecha = date('Y-m-d');
//$hint = "";
$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// lookup all hints from array if $q is different from ""
if ($q !="") {

date_default_timezone_set("America/Santiago");
$hora=date('H:i:s');
$fecha = date('Y-m-d');

$hora1="22:00:00";
$hora2="19:00:00";
$fechaDefecto="0000-00-00";
    $result=mysqli_query($con,"SELECT 
        entradat.idEntradaT,
        entradat.idTrabajador,
        entradat.fechaEntradaT,
        entradat.horaEntrada,
        entradat.horaSalida,
        entradat.horasTrabajadas,
        entradat.horasExtras,

        trabajador.idTrabajador,
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
        trabajador.fechaCreado,
        trabajador.horaCreado,
        trabajador.fotoTrabajador,
        trabajador.qrTrabajador,
        trabajador.idHotel,
        trabajador.jornada

   FROM entradat
   INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
   WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT = '$fecha'");
   $rowcount=mysqli_num_rows($result);
   if ($row1= mysqli_fetch_array($result))
   {
        $jornada= $row1['jornada'];
        $idEntrada= $row1['idEntradaT'];
        $fechaEntradaT= $row1['fechaEntradaT'];

        if ($jornada==1 && $fechaEntradaT==$fecha || $jornada==2 && $fechaEntradaT==$fecha || $jornada==3 && $fechaEntradaT==$fecha|| $jornada==4 && $fechaEntradaT==$fecha|| $jornada==5 && $fechaEntradaT==$fecha|| $jornada==6 && $fechaEntradaT==$fecha || $jornada==8 && $fechaEntradaT==$fecha) 
        {
          
          echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
          date_default_timezone_set("America/Santiago"); 
          echo date("l jS \of F Y H:i:s");
          $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
          $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
          $resultadoSuma=mysqli_num_rows($SumaHoras);
          while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
          $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
          $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
                }

                $horasDeTrabajo='8';
                $horasDeArreglo='1';
                if ($jornada=='1' && $sumaHoras > 8) 
                  
                 {
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo - $horasDeArreglo ;

                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                 }

                $horasDeTrabajo2='9';
                if ($jornada=='2' && $sumaHoras > 9) 
                {
                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }

                $horasDeTrabajo='8';
                if ($jornada=='3' && $sumaHoras > 8) 
                {
                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }

                $horasDeTrabajo2='9';
                if ($jornada=='4' && $sumaHoras > 9) 
                {
                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }


                if ($jornada=='5' && $sumaHoras > 9) 
                {
                  
                  $CalculoExtra= "0" ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }

                $horasDeTrabajo2='9';
                if ($jornada=='6' && $sumaHoras > 9) 
                {
                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }

                $horasDeTrabajo2='9';
                if ($jornada=='8' && $sumaHoras > 9) 
                {
                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }



            }
        if ($jornada==7 && $fechaEntradaT==$fecha) 
                {
              
                  echo '<div class="alert alert-warning"><strong>Hasta mañana turno 7x7...</strong></div>';
                  date_default_timezone_set("America/Santiago"); 
                  echo date("l jS \of F Y H:i:s");
                  $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
                  $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
                  $resultadoSuma=mysqli_num_rows($SumaHoras);
                  while($rowSuma = mysqli_fetch_array($SumaHoras))
                       {
                  $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                  $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
                       }
                  $CalculoExtra='0';
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }           
   }
   else
   {     
                  $salidaDefecto="00:00:00";
                  $horasTrabajadasDefecto='0';
                  $horasExtrasDefecto='0';

                  $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                  $rowcount1=mysqli_num_rows($resulta);
                  while($row = mysqli_fetch_array($resulta)) 
                  {
                    $idTrabajador= $row['idTrabajador'];
                    $jornada= $row['jornada'];

                    if ($jornada==1 || $jornada==2|| $jornada==3 || $jornada==4|| $jornada==5|| $jornada==6|| $jornada==8) 
                    { 
                    $ret=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')"); 
                      echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido...!</div>';
                      date_default_timezone_set("America/Santiago");  
                      echo date("l jS \of F Y H:i:s");
                    }  
                    
                    elseif ($jornada==7) 
                    { 
                          $resulta=mysqli_query($con,"SELECT 
                          entradat.idEntradaT,
                          entradat.idTrabajador,
                          entradat.fechaEntradaT,
                          entradat.horaEntrada,
                          entradat.horaSalida,
                          entradat.horasTrabajadas,
                          entradat.horasExtras,

                          trabajador.idTrabajador,
                          trabajador.rutTrabajador,
                          trabajador.nombreTrabajador,
                          trabajador.apellidoTrabajador1,
                          trabajador.apellidoTrabajador2,
                          trabajador.genero,
                          trabajador.fechaCreado,
                          trabajador.horaCreado,
                          trabajador.fotoTrabajador,
                          trabajador.qrTrabajador,
                          trabajador.idHotel,
                          trabajador.jornada

                           FROM entradat
                           INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
                           WHERE entradat.idTrabajador='$q' and entradat.horaSalida = '$hora2'");
                           $rowcount=mysqli_num_rows($resulta);

                           if ($row1= mysqli_fetch_array($resulta))
                           {
                              $jornada= $row1['jornada'];
                              $idEntrada= $row1['idEntradaT'];
                             
                              echo '<div class="alert alert-warning"><strong>Turnos Diferentes...</strong></div>';
                              date_default_timezone_set("America/Santiago"); 
                              echo date("l jS \of F Y H:i:s");
                        
                              $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");

                              $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");   
                              $resultadoSuma=mysqli_num_rows($SumaHoras);
                              while($rowSuma = mysqli_fetch_array($SumaHoras))
                                   {
                              $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                              $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
                                   }

                              if ($jornada=='7' && $sumaHoras > 12) 
                                {                 
                                    $CalculoExtra='0';
                                    $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                                }
                            }  


                            else
                            {
                              $ret=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')"); 
                              echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido...!</div>';
                              date_default_timezone_set("America/Santiago"); 
                              echo date("l jS \of F Y H:i:s");
                            }  
                    }
                  }
   }


}
?>