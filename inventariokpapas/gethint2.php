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
$con = mysqli_connect('localhost','root','','hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// lookup all hints from array if $q is different from ""
if ($q !="") {
  /*$q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= ", $name";
      }
    }
  }*/
date_default_timezone_set("America/caracas"); 
$hora=date('H:i:s');


if ($hora >= '12:00:00' && $hora <= '23:59:59')
{   
    $fecha = date('Y-m-d');
    $result=mysqli_query($con,"SELECT * FROM persona WHERE qrPersona='$q'");
    $rowcount=mysqli_num_rows($result);

          
              if($rowcount)
              {
                  $consulta=$rowcount ['idPersona'];
           



echo '<div class="alert alert-warning"><strong>Alerta!</strong>Usted no se encuentra en nuestra base de datos...</div>';
                date_default_timezone_set("America/caracas"); 
                          echo date("l jS \of F Y H:i:s");

  
                    
                      ?>
              <?php }
              else
              {
                            echo '<div class="alert alert-success"><strong>Success!</strong> Lectura de Qr Correcta...</div>';
                          
                date_default_timezone_set("America/caracas"); 
                            echo date("l jS \of F Y H:i:s");
  
              }
                  
}




}




?>