
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
$idVentaGet=$_POST['idVenta'];
$idVentaUltimo=$idVentaGet; 
$fecha = date('Y-m-d');
$fechaSET = date('d/m/Y');
$DiaAntes=date("Y-m-d",strtotime($fecha."- 1 days")); 
//$hint = "";

// lookup all hints from array if $q is different from ""

  $fecha = date('Y-m-d'); 
  require('bd/conexionLocal.php');
  //$con = mysqli_connect('localhost','root','','ventas_php');
  // Check connection
  if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
  date_default_timezone_set("America/Santiago");
      //date_default_timezone_set("America/Caracas");
      $hora=date('H:i:s');
 

     /*TICKET*/
              $nombre_impresora = "Generica";
              $connector = new WindowsPrintConnector($nombre_impresora);
              $printer = new Printer($connector);
              echo 1;             
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              try{
                 $logo1 = EscposImage::load("img/fiestas.jpg", false);
                 $printer->bitImage($logo1);


                 $printer->setJustification(Printer::JUSTIFY_LEFT);
                 $printer->text("\n"."RAZON SOCIAL:SERVICIOS DE ALIMENTACIÓN Y ASEO MR" . ""."\n");
                 $printer->text("RUT: 76.828.687-6" . " "."\n");
                 $printer->text("BOLETA ELECTRONICA No. " .$idVentaUltimo. " "."\n");
                 $printer->text("FECHA EMISION: " .$fechaSET. " "."\n");
                 
              }catch(Exception $e){/*No hacemos nada si hay error*/}
              /*
                Ahora vamos a imprimir un encabezado
              */
             

             
               $resulta=mysqli_query($con,"SELECT productos_ventas.id,productos_ventas.cantidad,productos_ventas.precio,
               productos_ventas.idProducto,productos_ventas.idVenta,productos_ventas.cantidad,productos.id,productos.codigo,productos.nombre,
               productos.venta,ventas.fecha,ventas.total,ventas.idUsuario,ventas.idCliente FROM `productos_ventas` 
               INNER JOIN productos on productos_ventas.idProducto = productos.id
               INNER JOIN ventas on productos_ventas.idVenta = ventas.id
               WHERE ventas.id =$idVentaUltimo");
               $printer->text("----------------------------------------------" . "\n");
               $printer->text("\n"."CANTIDAD        DESCRIPCION           VALOR" . " "."\n");
               $printer->text("----------------------------------------------" . "\n");
               $rowcount1=mysqli_num_rows($resulta);

                    while($row = mysqli_fetch_array($resulta)) {
                     
                                  $nombresProducto = $row ['nombre'];
                                  $precio = $row ['venta']; 
                                  $total = $row ['total']; 
                                  $cantidad = $row ['cantidad']; 

                                  $valorFormateado = number_format($precio, 0, ',', '.');    

              
              $printer->text("\n".$cantidad."          ".$nombresProducto."----------"."$".$valorFormateado."\n");
           
            }
            
            $totalFormateado = number_format($total, 0, ',', '.');  
              $printer->text("-------------------------------------------" . "\n");
              $printer->text("TOTAL:" . "-------------------------------"."$".$totalFormateado." \n");
              $printer->text("-------------------------------------------" . "\n");
              #La fecha también
              //date_default_timezone_set("America/Caracas");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("-----------------------------" . "\n");
              
              $printer->text("-----------------------------"."\n");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("Muchas gracias por visitarnos\n");
              $printer->feed(3);
              $printer->cut();
              $printer->pulse();
              $printer->close();            

    /************************** */   
           
  

?>