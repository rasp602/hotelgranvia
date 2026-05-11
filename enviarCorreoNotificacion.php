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

/*CONEXION*/

require "bd/conexionLocal.php";

/*Fin Conexion*/
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



/*Enviar Correo*/
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
$mañana=date("Y-m-d",strtotime($fecha."+ 1 days")); 
$subject = "Pedido de Cocina";// El valor entre corchetes son los atributos name del formulario html
$msg = "Hola se ha realizado un pedido desde cocina".$fecha." a las ".$hora."";
$from = "mrrojastirado@gmail.com";

// El from DEBE corresponder a una cuenta de correo real creada en el servidor
$headers = "From: cocinah1@hotelgranvia.online\r\n"; 
$headers .= "Reply-To: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n"; 
  
if (mail($from, $subject, $msg, $headers)) {
    echo "<script>
        alert('Correo enviado correctamente.');
        window.location.href = 'http://190.163.13.239/inventario/venderPedido.php';
    </script>";
    exit();
} else {
    $errorMessage = error_get_last()['message'] ?? 'Error desconocido al enviar el correo.';
    echo "<script>
        alert('Error al enviar el correo: $errorMessage');
        window.location.href = 'http://190.163.13.239/inventario/venderPedido.php';
    </script>";
    exit();
}
            

?>