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
$DiaAntes=date("Y-m-d",strtotime($fecha."- 1 days")); 
//$hint = "";
$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// lookup all hints from array if $q is different from ""
if ($q !="") 
{
  date_default_timezone_set("America/Santiago");
  $hora=date('H:i:s');
  $fecha = date('Y-m-d');
  $hora1="22:00:00";
  $horaCero="00:00:00";
  $fechaDefecto="0000-00-00";
  $ayer="2023-01-10";
/*Consulta si el trabajador existe*/
  $Existe=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
     $rowcount=mysqli_num_rows($Existe);
     if ($row1= mysqli_fetch_array($Existe))
     {
/*Consulta si tiene registro de entrar el mismo dia*/      
        $RegistroSalida=mysqli_query($con,"SELECT 
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
        WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT = '$fecha' and entradat.horaEntrada!='$horaCero' and entradat.fechaSalida='$fechaDefecto' and entradat.horaSalida='$horaCero'");
        $rowcount=mysqli_num_rows($RegistroSalida);
        if ($row2= mysqli_fetch_array($RegistroSalida))
         {
           $jornada= $row2['jornada'];
           $idEntrada= $row2['idEntradaT'];

           if ($jornada==1)/*8hrs + (E+1)*/
           {  
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
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
           }
           if ($jornada==2)/*9hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
              $horasDeTrabajo2='9';
              $horasDeArreglo='1';
              if ($jornada=='2' && $sumaHoras > 9) 
              {
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
              }
           }
           if ($jornada==3)/*8hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo='8';
                $horasDeArreglo='1';
                if ($jornada=='3' && $sumaHoras > 8) 
                {                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           }
           if ($jornada==4)/*8hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='8';
                $horasDeArreglo='1';
                if ($jornada=='4' && $sumaHoras > 8) 
                {                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           }
           if ($jornada==5)/*9hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='9';
                $horasDeArreglo='1';
                if ($jornada=='5' && $sumaHoras > 9) 
                {                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           }
           if ($jornada==6)/*10hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='10';
                $horasDeArreglo='1';
                if ($jornada=='6' && $sumaHoras > 10) 
                {                  
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           } 
           if ($jornada==7)/*10hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='12';
                if ($jornada=='7' && $sumaHoras > 12) 
                {                  
                  $CalculoExtra= '0' ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           } 
           if ($jornada==9)/*10hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='12';
                if ($jornada=='9' && $sumaHoras > 12) 
                {                  
                  $CalculoExtra= '0' ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           }           
           if ($jornada==10)/*10hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='12';
                if ($jornada=='10' && $sumaHoras > 12) 
                {                  
                  $CalculoExtra= '0' ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           }

           if ($jornada==11)/*10hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='8';
                $horasDeArreglo='1';
                if ($jornada=='11' && $sumaHoras > 8) 
                {                  
                  $CalculoExtra= '0' ;
                  $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           } 

           if ($jornada==12)/*10hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='12';
                if ($jornada=='12' && $sumaHoras > 12) 
                {                  
                  $CalculoExtra= '0' ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           }

           if ($jornada==13)/*10hrs + (E+1)*/
           {
            /*Mensaje en pantalla*/
            echo '<div class="alert alert-warning"><strong>Hasta mañana...</strong></div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
            /*Actualiza la hora de salida*/
            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
            /*suma las horas trabajadas*/
            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
            $resultadoSuma=mysqli_num_rows($SumaHoras);
            /*Actualiza las horas trabajadas*/
            while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
                $horasDeTrabajo2='12';
                if ($jornada=='13' && $sumaHoras > 12) 
                {                  
                  $CalculoExtra= '0' ;
                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                }
           }

           if ($jornada==8) 
           {
              echo '<div class="alert alert-warning"><strong>Usted aun no termina su jornada laboral de 12 horas</strong></div>';
           }


         }
         else
         {
          $YaSalio=mysqli_query($con,"SELECT 
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
          WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT = '$fecha' and entradat.horaEntrada!='$horaCero' and entradat.fechaSalida!='$fechaDefecto' and entradat.horaSalida!='$horaCero'");
          $rowcount=mysqli_num_rows($YaSalio);
          if ($row3= mysqli_fetch_array($YaSalio))
           {
            echo '<div class="alert alert-warning"><strong>Success!</strong> Ya registro su salida...!</div>';
            date_default_timezone_set("America/Santiago"); 
            echo date("l jS \of F Y H:i:s");
           }
           else
           { 
             $Ejornada=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
             $rowcount=mysqli_num_rows($Ejornada);
             if ($row4= mysqli_fetch_array($Ejornada))
             {  $jornada= $row4['jornada'];

                if ($jornada==1||$jornada==2||$jornada==3||$jornada==4||$jornada==5||$jornada==6||$jornada==7||$jornada==9||$jornada==10||$jornada==11||$jornada==12||$jornada==13) 
                {
                /*Inserta el Pirmer Registro*/
                  $idTrabajador= $q;
                  $salidaDefecto="00:00:00";
                  $horasTrabajadasDefecto='0';
                  $horasExtrasDefecto='0';
                  $hora=date('H:i:s');
                  $fecha = date('Y-m-d');
                  $fechaDefecto="0000-00-00";
                  $Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");
                    echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido...!</div>';
                    date_default_timezone_set("America/Santiago"); 
                    echo date("l jS \of F Y H:i:s");
                }
                if ($jornada==8) 
                {
                      $RegistroSalidaEspecial=mysqli_query($con,"SELECT 
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
                      WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT='$DiaAntes' and entradat.horaEntrada!='$horaCero' and entradat.fechaSalida='$fechaDefecto' and entradat.horaSalida='$horaCero'");
                      $rowcount=mysqli_num_rows($RegistroSalidaEspecial);
                      if ($row5= mysqli_fetch_array($RegistroSalidaEspecial))
                       { $idEntrada= $row5['idEntradaT'];
                         $fechaEntradaT= $row5['fechaEntradaT'];
                            /*Mensaje en pantalla*/
                            echo '<div class="alert alert-warning"><strong>Hasta mañana1...</strong></div>';
                            date_default_timezone_set("America/Santiago"); 
                            echo date("l jS \of F Y H:i:s");
                            /*Actualiza la hora de salida*/
                            $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");
                            /*suma las horas trabajadas*/
                            $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");
                            $resultadoSuma=mysqli_num_rows($SumaHoras);
                            /*Actualiza las horas trabajadas*/
                            while($rowSuma = mysqli_fetch_array($SumaHoras))
                               {
                                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];
                                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
                               }
                                $horasDeTrabajo2='12';
                                if ($jornada=='8' && $sumaHoras > 12) 
                                {                  
                                  $CalculoExtra= '0' ;
                                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                                }
                       }else{
                         $idTrabajador= $q;
                          $salidaDefecto="00:00:00";
                          $horasTrabajadasDefecto='0';
                          $horasExtrasDefecto='0';
                          $hora=date('H:i:s');
                          $fecha = date('Y-m-d');
                          $fechaDefecto="0000-00-00";
                          $Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");
                            echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                            date_default_timezone_set("America/Santiago"); 
                            echo date("l jS \of F Y H:i:s");
                       }
/*nueva pruaba*/




                }
                elseif ($jornada==8) 
                
                { 
                          /*Inserta el Pirmer Registro*/
                          $idTrabajador= $q;
                          $salidaDefecto="00:00:00";
                          $horasTrabajadasDefecto='0';
                          $horasExtrasDefecto='0';
                          $hora=date('H:i:s');
                          $fecha = date('Y-m-d');
                          $fechaDefecto="0000-00-00";
                          $Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");
                            echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                            date_default_timezone_set("America/Santiago"); 
                            echo date("l jS \of F Y H:i:s");
                }
                /*valida si es el mismo dia*/
              }
            }
         }
/*Fin consulta si tiene registro de entrar el mismo dia*/ 



     }
/*Fin de consulta si existe el trabajador*/    
     else
     {
      echo '<div class="alert alert-warning"><strong>El trabajador no existe...</strong></div>';      
     }
}
else
{
      echo '<div class="alert alert-warning"><strong>No hay Identificador...</strong></div>';
}
?>