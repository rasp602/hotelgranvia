
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// Array with names
 //require('bd/conexionLocal.php');
// get the q parameter from URL
$q = $_REQUEST["q"];


$mystring = $q;

$codigo=mb_strlen($mystring);


$fecha = date('Y-m-d');
$DiaAntes=date("Y-m-d",strtotime($fecha."- 1 days")); 
//$hint = "";

// lookup all hints from array if $q is different from ""
if ($codigo >= 7) 
{
$fecha = date('Y-m-d'); 
require('bd/conexionLocal.php');
//$con = mysqli_connect('localhost','root','','hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
date_default_timezone_set("America/Santiago");

      //date_default_timezone_set("America/Caracas");
      $hora=date('H:i:s');
      $tipoComida1="Desayuno";
      $tipoComida2="Almuerzo";
      $tipoComida3="Cena";
      $consultaEstado=mysqli_query($con,"SELECT  
      persona.idPersona,
      persona.qrPersona,
      hospedaje.idHospedaje,
      hospedaje.idPersona,
      hospedaje.estado
      FROM persona 
      INNER JOIN hospedaje ON persona.idPersona=hospedaje.idPersona
      WHERE persona.qrPersona ='".$q."' and hospedaje.estado = 'A'");
      $rowcount1=mysqli_num_rows($consultaEstado);
 if($row= mysqli_fetch_array($consultaEstado))
  {
    $idPersona= $row['idPersona'];
    $idHospedaje= $row['idHospedaje'];
     /*DESAYUNO*/
  if ($hora >= '00:00:00' && $hora <= '10:00:00')
    {  
      $fecha = date('Y-m-d');
      $result2=mysqli_query($con,"SELECT 
        comida.idComida,
        comida.tipoComida,
        comida.fechaComida,
        comida.idPersona,
        persona.idPersona,
        persona.qrPersona,
        persona.nombresPersona,
        persona.apellidoPersona1
        FROM comida 
        INNER JOIN persona ON comida.idPersona = persona.idPersona 
        WHERE persona.qrPersona LIKE '%".$q."%' and comida.fechaComida = '$fecha' and comida.tipoComida = '$tipoComida1'");
        $rowcount=mysqli_num_rows($result2);
                if($rowcount)
                {                 
                  echo '<div class="alert alert-warning"><strong>Alerta! </strong>ya usted utilizo su cupo de Desayuno...</div>';
                  //date_default_timezone_set("America/Caracas");
                            echo date("l jS \of F Y H:i:s");                                          
                }
                else
                {
                   echo '<div class="alert alert-success"><strong>Bienvenido...! </strong> Usted tiene un cupo de Cena disponible (noche).</div>';
                      //date_default_timezone_set("America/Caracas");
                    echo date("l jS \of F Y H:i:s");
                  $ret=mysqli_query($con,"INSERT INTO `comida`(idPersona,idHospedaje,tipoComida,fechaComida,horaComida) VALUES ('$idPersona','$idHospedaje','$tipoComida1','$fecha','$hora')");
                  $nombre_impresora = "Generica1"; 
                  $connector = new WindowsPrintConnector($nombre_impresora);
                  $printer = new Printer($connector);
                  echo 1;             
                  $printer->setJustification(Printer::JUSTIFY_CENTER);
                  try{
                  $logo1 = EscposImage::load("img/granvia.png", false);
                  $printer->bitImage($logo1);
                  }catch(Exception $e){/*No hacemos nada si hay error*/}
                  /*
                    Ahora vamos a imprimir un encabezado
                  */
                    require('bd/conexionLocal.php');
                  //$con = mysqli_connect('localhost','root','','hoteleria');
                  // Check connection
                  if (mysqli_connect_errno())
                  {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                  }
                  $resulta=mysqli_query($con,"SELECT * FROM persona WHERE idPersona='$idPersona'");
                    $rowcount1=mysqli_num_rows($resulta);

                    while($row = mysqli_fetch_array($resulta)) {
                                  $nombres = $row ['nombresPersona'];
                                  $Apellidos = $row ['apellidoPersona1']; 

                                  }

                  $printer->text("\n"."Tipo de Comida:" . "\n".$tipoComida1);
                  $printer->text("\n"."Nombre:" . " ".$nombres." ".$Apellidos."\n");
                  $printer->text("Dirección : Angamos" . "\n");

                  #La fecha también
                  //date_default_timezone_set("America/Caracas");
                  $printer->text(date("Y-m-d H:i:s") . "\n");
                  $printer->text("-----------------------------" . "\n");
                  $printer->setJustification(Printer::JUSTIFY_CENTER);
                  $printer->text("-----------------------------"."\n");
                  $printer->setJustification(Printer::JUSTIFY_CENTER);
                  $printer->text("Muchas gracias por visitarnos\n");
                  $printer->feed(3);
                  $printer->cut();
                  $printer->pulse();
                  $printer->close();
                   
                }                    
      }
     /*ALMUERZO*/
  if ($hora >= '11:00:00' && $hora <= '15:59:00')
    {  
      $fecha = date('Y-m-d');
      $result2=mysqli_query($con,"SELECT 
        comida.idComida,
        comida.tipoComida,
        comida.fechaComida,
        comida.idPersona,
        persona.idPersona,
        persona.qrPersona,
        persona.nombresPersona,
        persona.apellidoPersona1
        FROM comida 
        INNER JOIN persona ON comida.idPersona = persona.idPersona 
        WHERE persona.qrPersona LIKE '%".$q."%' and comida.fechaComida = '$fecha' and comida.tipoComida = '$tipoComida2'");
        $rowcount=mysqli_num_rows($result2);
                if($rowcount)
                {                 
                  echo '<div class="alert alert-warning"><strong>Alerta! </strong>ya usted utilizo su cupo de Cena...</div>';
                  //date_default_timezone_set("America/Caracas");
                            echo date("l jS \of F Y H:i:s");                                          
                }
                else
                {
                  echo '<div class="alert alert-success"><strong>Bienvenido...! </strong> Usted tiene un cupo de Cena disponible (noche).</div>';
                      //date_default_timezone_set("America/Caracas");
                    echo date("l jS \of F Y H:i:s");
                  $ret=mysqli_query($con,"INSERT INTO `comida`(idPersona,idHospedaje,tipoComida,fechaComida,horaComida) VALUES ('$idPersona','$idHospedaje','$tipoComida2','$fecha','$hora')");
                  $nombre_impresora = "Generica1"; 

              $connector = new WindowsPrintConnector($nombre_impresora);
              $printer = new Printer($connector);
              echo 1;             
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              try{
                $logo1 = EscposImage::load("img/granvia.png", false);
                  $printer->bitImage($logo1);
              }catch(Exception $e){/*No hacemos nada si hay error*/}
              /*
                Ahora vamos a imprimir un encabezado
              */
                require('bd/conexionLocal.php');
              //$con = mysqli_connect('localhost','root','','hoteleria');
              // Check connection
              if (mysqli_connect_errno())
              {
               echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }
               $resulta=mysqli_query($con,"SELECT * FROM persona WHERE idPersona='$idPersona'");
                    $rowcount1=mysqli_num_rows($resulta);

                    while($row = mysqli_fetch_array($resulta)) {
                                  $nombres = $row ['nombresPersona'];
                                  $Apellidos = $row ['apellidoPersona1']; 

                                  }

              $printer->text("\n"."Tipo de Comida:" . "\n".$tipoComida2);
              $printer->text("\n"."Nombre:" . " ".$nombres." ".$Apellidos."\n");
              $printer->text("Dirección : Angamos" . "\n");

              #La fecha también
              //date_default_timezone_set("America/Caracas");
              $printer->text(date("Y-m-d H:i:s") . "\n");
              $printer->text("-----------------------------" . "\n");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("-----------------------------"."\n");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("Muchas gracias por visitarnos\n");
              $printer->feed(3);
              $printer->cut();
              $printer->pulse();
              $printer->close();
  
                }                    
    }
  /*CENA*/
  if ($hora >= '16:00:00' && $hora <= '23:59:00')
    
    {  
      $fecha = date('Y-m-d');
      $result2=mysqli_query($con,"SELECT 
        comida.idComida,
        comida.tipoComida,
        comida.fechaComida,
        comida.idPersona,
        persona.idPersona,
        persona.qrPersona,
        persona.nombresPersona,
        persona.apellidoPersona1
        FROM comida 
        INNER JOIN persona ON comida.idPersona = persona.idPersona 
        WHERE persona.qrPersona LIKE '%".$q."%' and comida.fechaComida = '$fecha' and comida.tipoComida = '$tipoComida3'");
        $rowcount=mysqli_num_rows($result2);
                if($rowcount)
                {                 
                  echo '<div class="alert alert-warning"><strong>Alerta! </strong>ya usted utilizo su cupo de Cena...</div>';
                  //date_default_timezone_set("America/Caracas");
                            echo date("l jS \of F Y H:i:s");                                          
                }
                else
                {
                  echo '<div class="alert alert-success"><strong>Bienvenido...! </strong> Usted tiene un cupo de Cena disponible (noche).</div>';
                      //date_default_timezone_set("America/Caracas");
                    echo date("l jS \of F Y H:i:s");
                  $ret=mysqli_query($con,"INSERT INTO `comida`(idPersona,idHospedaje,tipoComida,fechaComida,horaComida) VALUES ('$idPersona','$idHospedaje','$tipoComida3','$fecha','$hora')");

                  $nombre_impresora = "Generica1"; 

              $connector = new WindowsPrintConnector($nombre_impresora);
              $printer = new Printer($connector);
              echo 1;             
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              try{
                $logo1 = EscposImage::load("img/granvia.png", false);
                  $printer->bitImage($logo1);
              }catch(Exception $e){/*No hacemos nada si hay error*/}
              /*
                Ahora vamos a imprimir un encabezado
              */
                require('bd/conexionLocal.php');
              //$con = mysqli_connect('localhost','root','','hoteleria');
              // Check connection
              if (mysqli_connect_errno())
              {
               echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }
               $resulta=mysqli_query($con,"SELECT * FROM persona WHERE idPersona='$idPersona'");
                    $rowcount1=mysqli_num_rows($resulta);

                    while($row = mysqli_fetch_array($resulta)) {
                                  $nombres = $row ['nombresPersona'];
                                  $Apellidos = $row ['apellidoPersona1']; 

                                  }

              $printer->text("\n"."Tipo de Comida:" . "\n".$tipoComida3);
              $printer->text("\n"."Nombre:" . " ".$nombres." ".$Apellidos."\n");
              $printer->text("Dirección : Angamos" . "\n");

              #La fecha también
              //date_default_timezone_set("America/Caracas");
              $printer->text(date("Y-m-d H:i:s") . "\n");
              $printer->text("-----------------------------" . "\n");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("-----------------------------"."\n");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("Muchas gracias por visitarnos\n");
              $printer->feed(3);
              $printer->cut();
              $printer->pulse();
              $printer->close();

                }                    
    }

 }
}

      /*   if ($hora>= '00:00:00' && $hora <= '03:59') {
                    echo '<div class="alert alert-warning"><strong>Alerta! </strong> No es hora de comer.</div>';
            }*/
/*
            if ($hora>= '09:01:00' && $hora <= '12:59') {
                    echo '<div class="alert alert-warning"><strong>Alerta! </strong> No es hora de comer.</div>';
            }*/

            /*if ($hora>= '14:31:00' && $hora <= '17:59') {
                    echo '<div class="alert alert-warning"><strong>Alerta! </strong> No es hora de comer.</div>';
            }*/

            /*
            if ($hora>= '22:01:00' && $hora <= '23:59') {
                    echo '<div class="alert alert-warning"><strong>Alerta! </strong> No es hora de comer.</div>';
            }*/






?>