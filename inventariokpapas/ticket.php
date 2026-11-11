<?php

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


$id=$_POST['qr'];
      $tipoComida1="Desayuno";
      $tipoComida2="Almuerzo";
      $tipoComida3="Cena";
$estado='A';
 $fechaComida=date("Y-m-d");
 date_default_timezone_set("America/Santiago");
$hora=date('H:i:s');
require('bd/conexionLocal.php');
//$con = mysqli_connect('localhost','root','','hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($hora >= '00:00:00' && $hora <= '13:59:00')
{ 

		$ConsultaSiActivo=mysqli_query($con,"SELECT 
					persona.idPersona,
					persona.qrPersona,
					hospedaje.idHospedaje,
					hospedaje.idPersona,
					hospedaje.estado
					FROM persona 
					INNER JOIN hospedaje ON persona.idPersona=hospedaje.idPersona
			 		WHERE persona.qrPersona = '$id' AND hospedaje.estado ='$estado'");
		    $resultado=mysqli_num_rows($ConsultaSiActivo);

	 if($row= mysqli_fetch_array($ConsultaSiActivo))
  { $idPersona= $row['idPersona'];

					$ConsultaSiComio=mysqli_query($con,"SELECT * FROM comida WHERE idPersona = '$idPersona' AND fechaComida = '$fechaComida' and tipoComida = '$tipoComida1'");
		      		$respuesta=mysqli_num_rows($ConsultaSiComio);

					if ($respuesta) {
						
					echo "error";
					}

							else{
							

					$ConsultaSiComio=mysqli_query($con,"SELECT 
						comida.idComida,
						comida.idPersona,
						comida.tipoComida,
						comida.fechaComida,
						comida.horaComida,

						TIMEDIFF('$hora',comida.horaComida) AS diferencia 
						FROM comida
						WHERE idPersona = '$idPersona' AND fechaComida = '$fechaComida' and tipoComida = '$tipoComida1'");


		      		$respuesta=mysqli_num_rows($ConsultaSiComio);
  						
  						if ($respuesta) {
  		// code...
  


					
			       }
			       else{

         					$nombre_impresora = "Generica"; 

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
							date_default_timezone_set("America/Santiago");
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


if ($hora >= '14:00:00' && $hora <= '17:59:00')
{ 

		$ConsultaSiActivo=mysqli_query($con,"SELECT 
					persona.idPersona,
					persona.qrPersona,
					hospedaje.idHospedaje,
					hospedaje.idPersona,
					hospedaje.estado
					FROM persona 
					INNER JOIN hospedaje ON persona.idPersona=hospedaje.idPersona
			 		WHERE persona.qrPersona = '$id' AND hospedaje.estado ='$estado' ");
		    $resultado=mysqli_num_rows($ConsultaSiActivo);

		 if($row= mysqli_fetch_array($ConsultaSiActivo))
  { $idPersona= $row['idPersona'];

					$ConsultaSiComio=mysqli_query($con,"SELECT * FROM comida WHERE idPersona = '$idPersona' AND fechaComida = '$fechaComida' and tipoComida = '$tipoComida2'");
		      		$respuesta=mysqli_num_rows($ConsultaSiComio);

					if ($respuesta) {
						
					echo "error";
					}

							else{


							$nombre_impresora = "Generica"; 


							$connector = new WindowsPrintConnector($nombre_impresora);
							$printer = new Printer($connector);
							#Mando un numero de respuesta para saber que se conecto correctamente.
							echo 1;
							/*
								Vamos a imprimir un logotipo
								opcional. Recuerda que esto
								no funcionará en todas las
								impresoras

								Pequeña nota: Es recomendable que la imagen no sea
								transparente (aunque sea png hay que quitar el canal alfa)
								y que tenga una resolución baja. En mi caso
								la imagen que uso es de 250 x 250
							*/

							# Vamos a alinear al centro lo próximo que imprimamos
							$printer->setJustification(Printer::JUSTIFY_CENTER);

							/*
								Intentaremos cargar e imprimir
								el logo
							*/
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
							date_default_timezone_set("America/Santiago");
							$printer->text(date("Y-m-d H:i:s") . "\n");
							$printer->text("-----------------------------" . "\n");
							$printer->setJustification(Printer::JUSTIFY_CENTER);


							/*
								Ahora vamos a imprimir los
								productos
							*/
								/*Alinear a la izquierda para la cantidad y el nombre*/

							/*
								Terminamos de imprimir
								los productos, ahora va el total
							*/
							$printer->text("-----------------------------"."\n");



							/*
								Podemos poner también un pie de página
							*/
							$printer->setJustification(Printer::JUSTIFY_CENTER);
							$printer->text("Muchas gracias por visitarnos\n");



							/*Alimentamos el papel 3 veces*/
							$printer->feed(3);

							/*
								Cortamos el papel. Si nuestra impresora
								no tiene soporte para ello, no generará
								ningún error
							*/
							$printer->cut();

							/*
								Por medio de la impresora mandamos un pulso.
								Esto es útil cuando la tenemos conectada
								por ejemplo a un cajón
							*/
							$printer->pulse();

							/*
								Para imprimir realmente, tenemos que "cerrar"
								la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
							*/
							$printer->close();


							}

			}
}


if ($hora >= '18:00:00' && $hora <= '23:59:00')
{ 

		$ConsultaSiActivo=mysqli_query($con,"SELECT 
					persona.idPersona,
					persona.qrPersona,
					hospedaje.idHospedaje,
					hospedaje.idPersona,
					hospedaje.estado
					FROM persona 
					INNER JOIN hospedaje ON persona.idPersona=hospedaje.idPersona
			 		WHERE persona.qrPersona = '$id' AND hospedaje.estado ='$estado' ");
		    $resultado=mysqli_num_rows($ConsultaSiActivo);

			 if($row= mysqli_fetch_array($ConsultaSiActivo))
  { $idPersona= $row['idPersona'];

					$ConsultaSiComio=mysqli_query($con,"SELECT * FROM comida WHERE idPersona = '$idPersona' AND fechaComida = '$fechaComida' and tipoComida = '$tipoComida3'");
		      		$respuesta=mysqli_num_rows($ConsultaSiComio);

					if ($respuesta) {
						
					echo "error";
					}

							else{


							$nombre_impresora = "Generica"; 


							$connector = new WindowsPrintConnector($nombre_impresora);
							$printer = new Printer($connector);
							#Mando un numero de respuesta para saber que se conecto correctamente.
							echo 1;
							/*
								Vamos a imprimir un logotipo
								opcional. Recuerda que esto
								no funcionará en todas las
								impresoras

								Pequeña nota: Es recomendable que la imagen no sea
								transparente (aunque sea png hay que quitar el canal alfa)
								y que tenga una resolución baja. En mi caso
								la imagen que uso es de 250 x 250
							*/

							# Vamos a alinear al centro lo próximo que imprimamos
							$printer->setJustification(Printer::JUSTIFY_CENTER);

							/*
								Intentaremos cargar e imprimir
								el logo
							*/
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
							date_default_timezone_set("America/Santiago");
							$printer->text(date("Y-m-d H:i:s") . "\n");
							$printer->text("-----------------------------" . "\n");
							$printer->setJustification(Printer::JUSTIFY_CENTER);


							/*
								Ahora vamos a imprimir los
								productos
							*/
								/*Alinear a la izquierda para la cantidad y el nombre*/

							/*
								Terminamos de imprimir
								los productos, ahora va el total
							*/
							$printer->text("-----------------------------"."\n");



							/*
								Podemos poner también un pie de página
							*/
							$printer->setJustification(Printer::JUSTIFY_CENTER);
							$printer->text("Muchas gracias por visitarnos\n");



							/*Alimentamos el papel 3 veces*/
							$printer->feed(3);

							/*
								Cortamos el papel. Si nuestra impresora
								no tiene soporte para ello, no generará
								ningún error
							*/
							$printer->cut();

							/*
								Por medio de la impresora mandamos un pulso.
								Esto es útil cuando la tenemos conectada
								por ejemplo a un cajón
							*/
							$printer->pulse();

							/*
								Para imprimir realmente, tenemos que "cerrar"
								la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
							*/
							$printer->close();


							}

			}
}



?>