<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
// Array with names
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// get the q parameter from URL
$qr = $_REQUEST["q"];

$mystring = $qr;

$codigo=mb_strlen($mystring);


$fecha = date('Y-m-d');
$DiaAntes=date("Y-m-d",strtotime($fecha."- 1 days")); 
//$hint = "";

// lookup all hints from array if $q is different from ""
if ( $codigo >= 13 && $codigo <= 14) 
{
  /*Conexion*/
  require('bd/conexion.php');

// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
/*Fin Conexion*/

  date_default_timezone_set("America/Santiago");
  $hora=date('H:i:s');
  $fecha = date('Y-m-d');
 
  $horaCero="00:00:00";
  $fechaDefecto="0000-00-00";

/*Consulta si el trabajador existe*/
     $Existe=mysqli_query($con,"SELECT * FROM trabajador WHERE qrTrabajador='$qr'");
     $rowcount=mysqli_num_rows($Existe);
     if ($row1= mysqli_fetch_array($Existe))
     {$fecha = date('Y-m-d');
      $q=$row1['idTrabajador'];
/**********************Consulta si tiene registro de entrada el mismo dia******************/      
        $RegistroSalida=mysqli_query($con,"SELECT 
        entradat.idEntradaT,
        entradat.Fecha,
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
        trabajador.jornada,
        TIMEDIFF('$hora',entradat.horaEntrada) AS diferencia
        FROM entradat
        INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
        WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT = '$fecha' and entradat.horaEntrada!='$horaCero' and entradat.fechaSalida='$fechaDefecto' and entradat.horaSalida='$horaCero'");
        $rowcount=mysqli_num_rows($RegistroSalida);
        if ($row2= mysqli_fetch_array($RegistroSalida))
         {
           $jornada= $row2['jornada'];
           $idEntrada= $row2['idEntradaT'];
           $diferencia= $row2['diferencia'];
////////////////////////////////////////////JORNADA DE 8:00 A 16:00 (Registro Salida) //////////////////////           
           if ($jornada==1 && $diferencia>'01:00:00')/*8hrs + (E+1)*/
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


                /*******************************************************IMPRESION****************************/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
           }
////////////////////////////////////////////JORNADA DE 8:00 A 17:00  (Registro Salida)//////////////////////  
           if ($jornada==2 && $diferencia>'01:00:00')/*9hrs + (E+1)*/
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

                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
           }
////////////////////////////////////////////JORNADA DE 14:00 A 22:00(Registro Salida)  //////////////////////   
           if ($jornada==3 && $diferencia>'01:00:00')/*8hrs + (E+1)*/
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

                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/    
           }
////////////////////////////////////////////JORNADA DE 00:00 A 8:00 (Registro Salida) //////////////////////   
           if ($jornada==4 && $diferencia>'01:00:00')/*8hrs + (E+1)*/
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

                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/    
           }
////////////////////////////////////////////JORNADA DE 15:00 A 23:00 (Registro Salida) //////////////////////  
           if ($jornada==5 && $diferencia>'01:00:00')/*9hrs + (E+1)*/
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

                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/     
           }
////////////////////////////////////////////JORNADA DE 8:00 A 18:00 (Registro Salida) //////////////////////  
           if ($jornada==6 && $diferencia>'01:00:00')/*10hrs + (E+1)*/
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

                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/    
           } 
////////////////////////////////////////////JORNADA DE 8:00 A 22:00 (Registro Salida) //////////////////////  
           if ($jornada==7 && $diferencia>'01:00:00')/*10hrs + (E+1)*/
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


                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/    
           } 
////////////////////////////////////////////JORNADA DE 6:00 A 18:00 (Registro Salida) //////////////////////  
           if ($jornada==9 && $diferencia>'01:00:00')/*10hrs + (E+1)*/
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

                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/    
           }           
////////////////////////////////////////////JORNADA 7X7 (Registro Salida)//////////////////////  
           if ($jornada==10 && $diferencia>'01:00:00')/*10hrs + (E+1)*/
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

                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/      
           }
////////////////////////////////////////////JORNADA DE 2:00 A 10:00  (Registro Salida)//////////////////////  
           if ($jornada==11 && $diferencia>'01:00:00')/*10hrs + (E+1)*/
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


                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/     
           } 
////////////////////////////////////////////JORNADA DE 8:00 A 20:00  //////////////////////  
           if ($jornada==12 && $diferencia>'01:00:00')/*10hrs + (E+1)*/
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


                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/  
           }
////////////////////////////////////////////JORNADA DE 10:00 A 22:00 (Registro Salida) //////////////////////  
           if ($jornada==13 && $diferencia>'01:00:00')/*10hrs + (E+1)*/
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
            
                                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("d-m-Y") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/    

           }
////////////////////////////////////////////NOTIFICA QUE NO SE PUEDE MARCAR PORQUE ES EL MISMO DIA //////////////////////  
           if ($jornada==8 || $jornada==14 || $jornada==15 || $jornada==16) 
           {
              echo '<div class="alert alert-warning"><strong>Usted aun no termina su jornada laboral de 12 horas </strong></div>';
           }
////////////////////////////////////////////JORNADA QUE PERMITE PASAR DE DIA O NO (ESPECIAL) //////////////////////
           if ($jornada==17 ) 
            {
                  $RegistroSalidaEspecial=mysqli_query($con,"SELECT 
                  entradat.idEntradaT,
                  entradat.Fecha,
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
                  trabajador.jornada,
                  TIMEDIFF('$hora',entradat.horaEntrada) AS diferencia
                  FROM entradat
                  INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
                  WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT='$fecha' and entradat.horaEntrada!='$horaCero' and entradat.fechaSalida='$fechaDefecto' and entradat.horaSalida='$horaCero'");
                  $rowcount=mysqli_num_rows($RegistroSalidaEspecial);
                  if ($row5= mysqli_fetch_array($RegistroSalidaEspecial))
                      { 
                        if($diferencia >'01:00:00')
                        {                          
                          $idEntrada= $row5['idEntradaT'];
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
                              if ($jornada=='17' && $sumaHoras > 10) 
                              {                  
                                $CalculoExtra= '0' ;
                                $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                              }

                                          /*IMPRESION*/

                              $nombre_impresora = "Generica";
                              $connector = new WindowsPrintConnector($nombre_impresora);
                              $printer = new Printer($connector);
                              echo 1;             
                              $printer->setJustification(Printer::JUSTIFY_CENTER);
                              try{
                                $logo1 = EscposImage::load("img/asistencia.png", false);
                                  $printer->bitImage($logo1);
                              }catch(Exception $e){/*No hacemos nada si hay error*/}
                              /*
                                Ahora vamos a imprimir un encabezado
                              */
                            require('bd/conexion.php');
                              //$con = mysqli_connect('localhost','root','','hoteleria');
                              // Check connection
                              if (mysqli_connect_errno())
                              {
                              echo "Failed to connect to MySQL: " . mysqli_connect_error();
                              }
                              $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                    $rowcount1=mysqli_num_rows($resulta);

                                    while($row = mysqli_fetch_array($resulta)) {
                                                  $nombres = $row ['nombreTrabajador'];
                                                  $Apellidos = $row ['apellidoTrabajador1']; 
                                                  
                                                  }

                              $printer->text("\n"."Registro de Salida:" . "\n");
                              $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                          

                              #La fecha también
                              //date_default_timezone_set("America/Caracas");
                              $printer->text("Fecha: ".date("Y-m-d") . "\n");
                              $printer->text("Hora: ".date("H:i:s") . "\n");
                              $printer->text("-----------------------------" . "\n");
                              $printer->setJustification(Printer::JUSTIFY_CENTER);
                              $printer->text("-----------------------------"."\n");
                              $printer->setJustification(Printer::JUSTIFY_CENTER);
                              $printer->text("Hasta mañana\n");
                              $printer->feed(3);
                              $printer->cut();
                              $printer->pulse();
                              $printer->close();

                              /*FIN IMPRESION*/
                         }
                         else
                         {
                           echo '<div class="alert alert-warning"><strong>Aun no termina su jornada de trabajo1</strong></div>';
                         }                           

                  }  
            }               
/////////////////////////////////////////////////////////////////////////////////////////////////////////

          }

/**************************Fin del (If) Consulta si tiene registro de entrada el mismo dia******************/      
         else
         {
/////////////////////Notifica que ya salio ////////////////////////////////          
          $YaSalio=mysqli_query($con,"SELECT 
          entradat.idEntradaT,
          entradat.Fecha,
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
/////////////////////Fin del (If) que Notifica que ya salio ////////////////////////////////             
           else
           { 
////////////////////////////////Consulta el id del trabajador y si la fecha es hoy para registar entrada///////////////////////            
          $Ejornada=mysqli_query($con,"SELECT 
          entradat.idEntradaT,
          entradat.Fecha,
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
          WHERE entradat.idTrabajador='$q' and entradat.Fecha = '$fecha'");

             $rowcount=mysqli_num_rows($Ejornada);
             if ($row4= mysqli_fetch_array($Ejornada))
             {  $jornada= $row4['jornada'];
                $idEntrada= $row4['idEntradaT'];
                $hotel = $row4 ['idHotel'];
////////////////////////////////////////////////////////////////////REGISTRO ENTRADA DE JORNADA QUE TERMINAN EL MISMO DIA////////////////////////////////////////////////////////////////////////////////////
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

                      $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");

                  /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                        echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido...!</div>';
                        date_default_timezone_set("America/Santiago"); 
                        echo date("l jS \of F Y H:i:s");

                  /*IMPRESION*/

                        $nombre_impresora = "Generica";
                        $connector = new WindowsPrintConnector($nombre_impresora);
                        $printer = new Printer($connector);
                        echo 1;             
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                        try{
                          $logo1 = EscposImage::load("img/asistencia.png", false);
                            $printer->bitImage($logo1);
                        }catch(Exception $e){/*No hacemos nada si hay error*/}
                        /*
                          Ahora vamos a imprimir un encabezado
                        */
                      require('bd/conexion.php');
                        //$con = mysqli_connect('localhost','root','','hoteleria');
                        // Check connection
                        if (mysqli_connect_errno())
                        {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }
                        $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                              $rowcount1=mysqli_num_rows($resulta);

                              while($row = mysqli_fetch_array($resulta)) 
                                {
                                            $nombres = $row ['nombreTrabajador'];
                                            $Apellidos = $row ['apellidoTrabajador1'];                                       
                                }

                        $printer->text("\n"."Registro de Entrada:" . "\n");
                        $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                        #La fecha también
                        //date_default_timezone_set("America/Caracas");
                        $printer->text("Fecha: ".date("Y-m-d") . "\n");
                        $printer->text("Hora: ".date("H:i:s") . "\n");
                        $printer->text("-----------------------------" . "\n");
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                        $printer->text("-----------------------------"."\n");
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                        $printer->text("Feliz Jornada de Trabajo\n");
                        $printer->feed(3);
                        $printer->cut();
                        $printer->pulse();
                        $printer->close();

                        /*FIN IMPRESION*/

                }
////////////////////////////////////////////////////////////////////FIN REGISTRO ENTRADAD JORNADA QUE TERMINAN EL MISMO DIA////////////////////////////////////////////////////////////////////////////////////                

             
 ////////////////////////////////////////////////////////////REGISTRO SALIDA DE JORNADA QUE TERMINAN AL OTRO DIA/////////////////////////////////////////////////////////////////////////////////////////
                if ($jornada==8 || $jornada==14 || $jornada==15 || $jornada==16 || $jornada==17 ) 
                {
                      $RegistroSalidaEspecial=mysqli_query($con,"SELECT 
                      entradat.idEntradaT,
                      entradat.Fecha,
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
                      trabajador.jornada,
                      TIMEDIFF('$hora',entradat.horaEntrada) AS diferencia,
                      HOUR(SUM(TIMEDIFF(entradat.horaEntrada,'23:59:00'))) as  horasdiaAntes,
                      HOUR(SUM(TIMEDIFF('00:00:00','$hora'))) as horasdia     
                      FROM entradat
                      INNER JOIN trabajador ON entradat.idTrabajador=trabajador.idTrabajador
                      WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT='$DiaAntes' and entradat.horaEntrada!='$horaCero' and entradat.fechaSalida='$fechaDefecto' and entradat.horaSalida='$horaCero'");
                      $rowcount=mysqli_num_rows($RegistroSalidaEspecial);
                      if ($row5= mysqli_fetch_array($RegistroSalidaEspecial))
                       {
                          $horadiasAntes=$row5['horasdiaAntes'];
                          $horasdia=$row5['horasdia'];
                          $uno= 1;
                          $totalHorasTrabajadas= $uno+$horadiasAntes+$horasdia;

                          if($totalHorasTrabajadas >  2)
                          {                        
                          $idEntrada= $row5['idEntradaT'];
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
                                $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$totalHorasTrabajadas' WHERE idEntradaT ='$idEntrada'");
                               }
                                $horasDeTrabajo2='12';
                                
                                if ($jornada=='8' && $sumaHoras > 12) 
                                {                  
                                  $CalculoExtra= '0' ;
                                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                                }

                                if ($jornada=='14' && $sumaHoras > 12) 
                                {                  
                                  $CalculoExtra= '0' ;
                                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                                }

                                if ($jornada=='15' && $sumaHoras > 12) 
                                {                  
                                  $CalculoExtra= '0' ;
                                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                                }

                                if ($jornada=='16' && $sumaHoras > 12) 
                                {                  
                                  $CalculoExtra= '0' ;
                                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                                }

                                if ($jornada=='17' && $sumaHoras > 12) 
                                {                  
                                  $CalculoExtra= '0' ;
                                  $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");
                                }
                               
                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);
                                      while($row = mysqli_fetch_array($resulta)) 
                                                    {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1'];                                                      
                                                    }
                                $printer->text("\n"."Registro de Salida:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Hasta mañana\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                          }
                          else
                          {
                            echo '<div class="alert alert-warning"><strong>Aun no termina su jornada de trabajo 2</strong></div>';
                          
                              ////////////////////////PRUEBA///////////////////////////////////////
                              $Ejornada8=mysqli_query($con,"SELECT 
                              entradat.idEntradaT,
                              entradat.Fecha,
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
                              WHERE entradat.idTrabajador='$q' and entradat.Fecha = '$fecha'");

                              $rowcount=mysqli_num_rows($Ejornada8);
                              if ($row8= mysqli_fetch_array($Ejornada8))
                              {  $jornada= $row8['jornada'];
                                  $idEntrada= $row8['idEntradaT'];
                                  $idTrabajador= $q;
                                  $salidaDefecto="00:00:00";
                                  $horasTrabajadasDefecto='0';
                                  $horasExtrasDefecto='0';
                                  date_default_timezone_set("America/Santiago");
                                  $hora=date('H:i:s');
                                  $fecha = date('Y-m-d');
                                  $fechaDefecto="0000-00-00";


                          /***************************************************************************JORNADA (8) 22:00 A 8:00***********************************************************************/
                              if ($jornada==8 && $hora>'18:00:00') 
                                  {
                                    $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                    /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                    echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                    date_default_timezone_set("America/Santiago"); 
                                    echo date("l jS \of F Y H:i:s");
                                    /*IMPRESION*/

                                    $nombre_impresora = "Generica";
                                    $connector = new WindowsPrintConnector($nombre_impresora);
                                    $printer = new Printer($connector);
                                    echo 1;             
                                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                                    try{
                                      $logo1 = EscposImage::load("img/asistencia.png", false);
                                        $printer->bitImage($logo1);
                                    }catch(Exception $e){/*No hacemos nada si hay error*/}
                                    /*
                                      Ahora vamos a imprimir un encabezado
                                    */
                                   require('bd/conexion.php');
                                    //$con = mysqli_connect('localhost','root','','hoteleria');
                                    // Check connection
                                    if (mysqli_connect_errno())
                                    {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                    }
                                    $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                          $rowcount1=mysqli_num_rows($resulta);

                                          while($row = mysqli_fetch_array($resulta)) {
                                                        $nombres = $row ['nombreTrabajador'];
                                                        $Apellidos = $row ['apellidoTrabajador1']; 
                                                        
                                                        }

                                    $printer->text("\n"."Registro de Entrada:" . "\n");
                                    $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                                

                                    #La fecha también
                                    //date_default_timezone_set("America/Caracas");
                                    $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                    $printer->text("Hora: ".date("H:i:s") . "\n");
                                    $printer->text("-----------------------------" . "\n");
                                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                                    $printer->text("-----------------------------"."\n");
                                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                                    $printer->text("Feliz jornada de trabajo\n");
                                    $printer->feed(3);
                                    $printer->cut();
                                    $printer->pulse();
                                    $printer->close();

                                    /*FIN IMPRESION*/

                                  }
                           /***************************************************************************JORNADA (14)  16:00 A 1:00***********************************************************************/             
                              if ($jornada==14 && $hora>'15:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }
                           /***************************************************************************JORNADA (15)  17:00 A 2:00***********************************************************************/
                              if ($jornada==15 && $hora>'08:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }
                           /***************************************************************************JORNADA (16)  15:00 A 1:00***********************************************************************/
                              if ($jornada==16 && $hora>'15:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }
                          /***************************************************************************JORNADA (17)  15:00 A 1:00***********************************************************************/
                              if ($jornada==17 && $hora>'09:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }

                        }
                      }
                  }
   
  //////////////////////////////////////////////////////////// FIN DEL (IF) REGISTRO SALIDA DE JORNADA QUE TERMINAN AL OTRO DIA////////////////////////////////////////////////////////////////
  
 ////////////////////////////////////////////////////////////////////REGISTRO ENTRADA DE JORNADA QUE TERMINAN AL OTRO DIA//////////////////////////////////////////////////////////////////////////////////// 
                      else
                       {
                         $Ejornada8=mysqli_query($con,"SELECT 
                          entradat.idEntradaT,
                          entradat.Fecha,
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
                          WHERE entradat.idTrabajador='$q' and entradat.Fecha = '$fecha'");

                         $rowcount=mysqli_num_rows($Ejornada8);
                         if ($row8= mysqli_fetch_array($Ejornada8))
                           {  $jornada= $row8['jornada'];
                              $idEntrada= $row8['idEntradaT'];
                              $idTrabajador= $q;
                              $salidaDefecto="00:00:00";
                              $horasTrabajadasDefecto='0';
                              $horasExtrasDefecto='0';
                              date_default_timezone_set("America/Santiago");
                              $hora=date('H:i:s');
                              $fecha = date('Y-m-d');
                              $fechaDefecto="0000-00-00";


/***************************************************************************JORNADA (8) 22:00 A 8:00***********************************************************************/
                              if ($jornada==8 && $hora>'18:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");
                                /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/



                              }
/***************************************************************************JORNADA (14)  16:00 A 1:00***********************************************************************/             
                              if ($jornada==14 && $hora>'15:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }
/***************************************************************************JORNADA (15)  17:00 A 2:00***********************************************************************/
                              if ($jornada==15 && $hora>'08:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }
/***************************************************************************JORNADA (16)  15:00 A 1:00***********************************************************************/
                              if ($jornada==16 && $hora>'15:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }
/***************************************************************************JORNADA (17)  15:00 A 1:00***********************************************************************/
                              if ($jornada==17 && $hora>'09:00:00') 
                              {
                                $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                                /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                                date_default_timezone_set("America/Santiago"); 
                                echo date("l jS \of F Y H:i:s");

                                             /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                              }

                            }
                        }


/*nueva pruaba*/

                }

////////////////////////////////////////////REGISTRO ENTRADA DE JORNADA QUE TERMINAN AL OTRO DIA/////////////////////////////////////////////////////////////////////// 
                elseif ($jornada==8 || $jornada==14 || $jornada==15 || $jornada==16 || $jornada==17 ) 
                
                { 
                     $Ejornada88=mysqli_query($con,"SELECT 
                    entradat.idEntradaT,
                    entradat.Fecha,
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
                    WHERE entradat.idTrabajador='$q' and entradat.Fecha = '$fecha'");

                       $rowcount=mysqli_num_rows($Ejornada88);
                       if ($row88= mysqli_fetch_array($Ejornada88))
                       {  $jornada= $row88['jornada'];
                          $idEntrada= $row88['idEntradaT'];                         /*Inserta el Pirmer Registro*/
                          $idTrabajador= $q;
                          $salidaDefecto="00:00:00";
                          $horasTrabajadasDefecto='0';
                          $horasExtrasDefecto='0';
                          date_default_timezone_set("America/Santiago");
                          $hora=date('H:i:s');
                          $fecha = date('Y-m-d');
                          $fechaDefecto="0000-00-00";

  /***************************************************************************JORNADA (8) 22:00 A 8:00***********************************************************************/                      
                          if ($jornada==8 && $hora>'18:00:00') 
                          {
                            $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                            /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                              echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                              date_default_timezone_set("America/Santiago"); 
                              echo date("l jS \of F Y H:i:s");

                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                          }
/***************************************************************************JORNADA (14)  16:00 A 1:00***********************************************************************/  
                          if ($jornada==14 && $hora>'15:00:00') 
                          {
                            $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                            /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                              echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                              date_default_timezone_set("America/Santiago"); 
                              echo date("l jS \of F Y H:i:s");

                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                          }
/***************************************************************************JORNADA (15)  17:00 A 2:00***********************************************************************/
                          if ($jornada==15 && $hora>'08:00:00') 
                          {
                            $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                            /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                              echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                              date_default_timezone_set("America/Santiago"); 
                              echo date("l jS \of F Y H:i:s");

                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                          }
/***************************************************************************JORNADA (16)  15:00 A 1:00***********************************************************************/
                          if ($jornada==16 && $hora>'15:00:00') 
                          {
                            $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                            /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                              echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                              date_default_timezone_set("America/Santiago"); 
                              echo date("l jS \of F Y H:i:s");

                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) {
                                                    $nombres = $row ['nombreTrabajador'];
                                                    $Apellidos = $row ['apellidoTrabajador1']; 
                                                     
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                            

                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/



                          }
/***************************************************************************JORNADA (17)  15:00 A 1:00***********************************************************************/                              
                          if ($jornada==17 && $hora>'09:00:00') 
                          {
                            $actualizarPrimeraEntrada=mysqli_query($con,"UPDATE entradat SET fechaEntradaT = '$fecha', horaEntrada='$hora' WHERE idEntradaT ='$idEntrada'");
                            /*$Insertar=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fechaDefecto','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");*/
                              echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido ...!</div>';
                              date_default_timezone_set("America/Santiago"); 
                              echo date("l jS \of F Y H:i:s");

                                           /*IMPRESION*/

                                $nombre_impresora = "Generica";
                                $connector = new WindowsPrintConnector($nombre_impresora);
                                $printer = new Printer($connector);
                                echo 1;             
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                try{
                                  $logo1 = EscposImage::load("img/asistencia.png", false);
                                    $printer->bitImage($logo1);
                                }catch(Exception $e){/*No hacemos nada si hay error*/}
                                /*
                                  Ahora vamos a imprimir un encabezado
                                */
                               require('bd/conexion.php');
                                //$con = mysqli_connect('localhost','root','','hoteleria');
                                // Check connection
                                if (mysqli_connect_errno())
                                {
                                 echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                 $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                                      $rowcount1=mysqli_num_rows($resulta);

                                      while($row = mysqli_fetch_array($resulta)) 
                                                    {
                                                      $nombres = $row ['nombreTrabajador'];
                                                      $Apellidos = $row ['apellidoTrabajador1'];                                                      
                                                    }

                                $printer->text("\n"."Registro de Entrada:" . "\n");
                                $printer->text("\n"."Nombre Trabajador:" . "\n".$nombres." ".$Apellidos. "\n");
                                #La fecha también
                                //date_default_timezone_set("America/Caracas");
                                $printer->text("Fecha: ".date("Y-m-d") . "\n");
                                $printer->text("Hora: ".date("H:i:s") . "\n");
                                $printer->text("-----------------------------" . "\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("-----------------------------"."\n");
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("Feliz jornada de trabajo\n");
                                $printer->feed(3);
                                $printer->cut();
                                $printer->pulse();
                                $printer->close();

                                /*FIN IMPRESION*/
                          }


                        }
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

      echo("The string length in bytes is: ");
      echo(mb_strlen($mystring));    
     }
}

?>