<?php
include_once "funciones.php";
include_once "encabezado.php";
session_start(); 
?>

<?php

$ultimoId = $_REQUEST['ultimoId'];


date_default_timezone_set("America/Santiago");
require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// Array with names
 //require('bd/conexionLocal.php');
// get the q parameter from URL
 
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

      //date_default_timezone_set("America/Caracas");
      $hora=date('H:i:s');
 

     /*TICKET*/
              $nombre_impresora = "Generica1";
              $connector = new WindowsPrintConnector($nombre_impresora);
              $printer = new Printer($connector);
              echo 1;             
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              try{
                 $logo1 = EscposImage::load("img/granvia.png", false);
                 $printer->bitImage($logo1);


                 $printer->setJustification(Printer::JUSTIFY_LEFT);
               
                 $printer->text("ORDEN DE ENTREGA No. " .$ultimoId. " "."\n");
                 $printer->text("FECHA EMISION: " .$fechaSET. " "."\n");
                 
              }catch(Exception $e){/*No hacemos nada si hay error*/}
              /*
                Ahora vamos a imprimir un encabezado
              */
             

             
               $resulta=mysqli_query($con,"SELECT productos_preparados.id,productos_preparados.cantidad,productos_preparados.precio,
               productos_preparados.idProducto,productos_preparados.idVenta,productos_preparados.cantidad,              
               producto.idProducto,producto_prepa.codigoBarra,producto_preap.nombreProducto,
               producto_prepa,ventas_preparadas.fecha,ventas_preparadas.total,ventas_preparadas.idUsuario,ventas_preparadas.idHotel,ventas_preparadas.tipoEntrega,
               hotel.idHotel,hotel.nombreHotel,tblusuario.idUsuario,tblusuario.nombre,tblusuario.apellido            
               FROM `productos_preparados` 
               INNER JOIN producto on productos_preparados.idProducto = producto.idProducto
               INNER JOIN ventas_preparadas on productos_preparados.idVenta = ventas_preparadas.id
               INNER JOIN hotel on ventas_preparadas.idHotel = hotel.idHotel
               INNER JOIN tblusuario on ventas_preparadas.idUsuario = tblusuario.idUsuario
               WHERE ventas_preparadas.id =$ultimoId");
               $printer->text("----------------------------------------------" . "\n");
               $printer->text("\n"."CANTIDAD              DESCRIPCION          " . " "."\n");
               $printer->text("----------------------------------------------" . "\n");
               $rowcount1=mysqli_num_rows($resulta);

                    while($row = mysqli_fetch_array($resulta)) {
                                  $usuario = $row ['nombre']." ".$row ['apellido'];
                                  $lugar = $row ['nombreHotel'];
                                  $nombresProducto = $row ['nombreProducto'];
                                 
                                  $total = $row ['total']; 
                                  $cantidad = $row ['cantidad']; 
                                  $tipoEntrega = $row ['tipoEntrega'];
                                  if($tipoEntrega== "L")
                                  {
                                    $tipoEntrega = "LONCHERA";
                                  }
                                  if($tipoEntrega== "E")
                                  {
                                    $tipoEntrega = "EMPAQUETADO";
                                  }

                                  $valorFormateado = number_format($precio, 0, ',', '.');    
                                  $sub=$precio*$cantidad;
                                  $valorFormateado = number_format($sub, 0, ',', '.');

              
              $printer->text("\n".$cantidad."          ".$nombresProducto."\n");
           
            }
            
            
              $printer->text("-------------------------------------------" . "\n");
              $printer->text("DESPACHADO POR: ".$usuario." \n");
              $printer->text("LUGAR DE ENTREGA: ".$lugar." \n");
              $printer->text("TIPO DE ENTREGA: ".$tipoEntrega." \n");
              $printer->text("-------------------------------------------" . "\n");
              #La fecha también
              //date_default_timezone_set("America/Caracas");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("-----------------------------" . "\n");
              
              $printer->text("-----------------------------"."\n");
              $printer->setJustification(Printer::JUSTIFY_CENTER);
              $printer->text("Firma quien recibe\n");
              $printer->feed(3);
              $printer->cut();
              $printer->pulse();
              $printer->close();            

    /************************** */   
           
echo "
<script type='text/javascript'>
    window.location.href='cancelar_venta_preparado.php'
    alert('Venta realizada con éxito N° .$ultimoId')
</script>";
  

?>