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
date_default_timezone_set("America/Argentina/Buenos_Aires");  
$hora=date('H:i:s');
$fecha = date('Y-m-d');

    $result=mysqli_query($con,"SELECT * FROM salidat WHERE idTrabajador='$q' and fechaSalidaT = '$fecha'");
    $rowcount=mysqli_num_rows($result);

        /*$ret=mysqli_query($con,"INSERT INTO `minero`(name,Time,fecha,horaComida,tipoComida) VALUES ('$q',NOW(),'$fecha', '$hora','$tipoComida1')");*/
            
              if($rowcount)
              {
     
                echo '<div class="alert alert-warning"><strong>Alerta!</strong> Ya usted Registro su salida...</div>';
                date_default_timezone_set("America/Argentina/Buenos_Aires"); 
                          echo date("l jS \of F Y H:i:s");
                    
                      ?>
              <?php }
              else
              {

                echo '<div class="alert alert-success"><strong>Success!</strong> Hasta mañana...!</div>';
                              
              date_default_timezone_set("America/Argentina/Buenos_Aires"); 
                            echo date("l jS \of F Y H:i:s");

                
          $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                  $rowcount1=mysqli_num_rows($resulta);
                     while($row = mysqli_fetch_array($resulta)) {

                      /*Imprimir campo por nombre*/
                      $idTrabajador= $row['idTrabajador'];
              

                 $ret=mysqli_query($con,"INSERT INTO `salidat`(idTrabajador,fechaSalidaT,horaSalida) VALUES ('$idTrabajador','$fecha','$hora')");
 


                          
            }







              }
                  


/*
else{
echo 'Persona registrada';  
echo '<div class="alert alert-success"><strong>Success!</strong> employee successfully registered (No es la hora de comer)

</div>';

date_default_timezone_set("America/caracas"); 
                            echo date("l jS \of F Y H:i:s");


}*/

}





// Output "no suggestion" if no hint was found or output correct values
//echo $hint === "" ? "no suggestion" : $hint;
?>