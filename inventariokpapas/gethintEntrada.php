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
//require('bd/conexionLocal.php');
$con = mysqli_connect('localhost','root','','hoteleria');
//$con = mysqli_connect('localhost','u410124118_rasp602','Rodrigo2410$','u410124118_hoteleria');
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
 date_default_timezone_set("America/Santiago");
$hora=date('H:i:s');


$consultaEstado=mysqli_query($con,"SELECT   
      persona.idPersona,
      persona.qrPersona,
      hospedaje.idHospedaje,
      hospedaje.idPersona,
      hospedaje.estado

   FROM persona 

    INNER JOIN hospedaje ON persona.idPersona=hospedaje.idPersona

   WHERE persona.qrPersona LIKE '%".$q."%' and hospedaje.estado = 'A'");

    $rowcount1=mysqli_num_rows($consultaEstado);

 if($rowcount1)
{

    $entrada="E";
    $salida="S";
   
    $fecha = date('Y-m-d');
    $fechaHora = date('H:i:s');

    $result2=mysqli_query($con,"SELECT 
      entrada.idEntrada,
      entrada.idPersona,
      entrada.fechaEntrada,
      entrada.fechaHora,
      entrada.tipoRegistro,

      persona.idPersona,
      persona.qrPersona,
      persona.nombresPersona,
      persona.apellidoPersona1,
      max(idEntrada) AS ultimoid
     FROM entrada 
     INNER JOIN persona ON entrada.idPersona = persona.idPersona  
     WHERE persona.qrPersona LIKE '$q' and entrada.fechaEntrada='$fecha'");

    $rowcount2=mysqli_num_rows($result2);
   if ($row2= mysqli_fetch_array($result2))
         {    
            
              $ultimoid= $row2['ultimoid'];    
            
              if($ultimoid > 0)
              {       $entrada='E';
                      $salida='S';  
                      echo '<div class="alert alert-success"><strong>Salida...! </strong> </div>';
                      $resulta=mysqli_query($con,"SELECT * FROM persona WHERE qrPersona='$q'");
                      $rowcount1=mysqli_num_rows($resulta);
                      while($row = mysqli_fetch_array($resulta))
                      {
                        /*Imprimir campo por nombre*/
                        $idPersona= $row['idPersona']; 

                        $resulta2=mysqli_query($con,"SELECT * FROM entrada WHERE idEntrada='$ultimoid'");
                        $rowcount1=mysqli_num_rows($resulta2);
                        while($row3 = mysqli_fetch_array($resulta2))
                        {  
                          $tipoRegistro=$row3['tipoRegistro'];

                            if ($tipoRegistro==$entrada) 
                            {                                             
                                                             
                             $ret=mysqli_query($con,"INSERT INTO `entrada`(idPersona,fechaEntrada,fechaHora,tipoRegistro) VALUES ('$idPersona','$fecha','$fechaHora','$salida')");
                            } 

                            if ($tipoRegistro==$salida) 
                            {                                             
                                                             
                             $ret=mysqli_query($con,"INSERT INTO `entrada`(idPersona,fechaEntrada,fechaHora,tipoRegistro) VALUES ('$idPersona','$fecha','$fechaHora','$entrada')");
                            }
                        }
                      }      
              }



/*PRIMERA ENTRADA*/
              else
              {       $entrada='E';
                      $salida='S';  
                      echo '<div class="alert alert-success"><strong>Entrada Nueva...! </strong> </div>';
                      $resulta=mysqli_query($con,"SELECT * FROM persona WHERE qrPersona='$q'");
                      $rowcount1=mysqli_num_rows($resulta);
                      while($row = mysqli_fetch_array($resulta))
                      {
                        /*Imprimir campo por nombre*/
                        $idPersona= $row['idPersona'];   
                    
                        $ret=mysqli_query($con,"INSERT INTO `entrada`(idPersona,fechaEntrada,fechaHora,tipoRegistro) VALUES ('$idPersona','$fecha','$fechaHora','$entrada')");
                      }      
              }              


                  
          }

}

else {

                echo '<div class="alert alert-warning"><strong>Alerta!</strong> Sin Hospedaje...</div>';
                date_default_timezone_set("America/caracas"); 
                          echo date("l jS \of F Y H:i:s");
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