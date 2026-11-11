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
$fecha = date('Y-m-d');

$hora1="00:00:00";
$hora2="08:00:00";
$fechaDefecto="2023-01-08";
    $result=mysqli_query($con,"SELECT 
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
   WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT = '$fecha'");
    $rowcount=mysqli_num_rows($result);

      
            
              if($rowcount)
              {
     
                echo '<div class="alert alert-warning"><strong>Alerta!</strong>Hasta mañana...</div>';
             date_default_timezone_set("America/Argentina/Buenos_Aires"); 
                          echo date("l jS \of F Y H:i:s");

  $consultaEntrada=mysqli_query($con,"SELECT 
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
    WHERE entradat.idTrabajador='$q' and entradat.fechaEntradaT = '$fecha'");
  

    $rowcount=mysqli_num_rows($consultaEntrada);
     while($row1 = mysqli_fetch_array($consultaEntrada))
   {
          
              $idEntrada= $row1['idEntradaT'];
              $fechaEntradaT= $row1['fechaEntradaT'];
              $jornada= $row1['jornada'];

      $actualizarSalida=mysqli_query($con,"UPDATE entradat SET horaSalida = '$hora', fechaSalida='$fecha' WHERE idEntradaT ='$idEntrada'");    

     

      $SumaHoras=mysqli_query($con,"SELECT HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida))) FROM entradat WHERE idEntradaT ='$idEntrada'");

       $resultadoSuma=mysqli_num_rows($SumaHoras);
       while($rowSuma = mysqli_fetch_array($SumaHoras))
               {
                $sumaHoras= $rowSuma['HOUR(SUM(TIMEDIFF(entradat.horaEntrada,entradat.horaSalida)))'];

        $actualizarHorasTrabajadas=mysqli_query($con,"UPDATE entradat SET horasTrabajadas = '$sumaHoras' WHERE idEntradaT ='$idEntrada'");
               }
      $jornada= $row1['jornada'];
      $horasDeTrabajo='8';
      $horasDeArreglo='1';
      
       if ($jornada=='1' && $sumaHoras > 8) {
                  
                $CalculoExtra= $sumaHoras - $horasDeTrabajo - $horasDeArreglo ;

                $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");

            }

      $horasDeTrabajo2='9';
        if ($jornada=='2' && $sumaHoras > 9) {
                  
                $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;

                $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");

            }

      $horasDeTrabajo='8';
      $horasDeArreglo='1';
      
       if ($jornada=='3' && $sumaHoras > 8) {
                  
                $CalculoExtra= $sumaHoras - $horasDeTrabajo - $horasDeArreglo ;

                $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");

            }

        $horasDeTrabajo2='9';
        if ($jornada=='4' && $sumaHoras > 9) {
                  
                $CalculoExtra= $sumaHoras - $horasDeTrabajo2 - $horasDeArreglo ;

                $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");

            }

        
        if ($jornada=='5' && $sumaHoras > 12) {
                  
                $CalculoExtra='0';
                $actualizarHorasExtras=mysqli_query($con,"UPDATE entradat SET horasExtras = '$CalculoExtra' WHERE idEntradaT ='$idEntrada'");

            }



            
    }

                    
                      ?>
              <?php }
              else
              {

                $salidaDefecto="00:00:00";
                $horasTrabajadasDefecto='0';
                $horasExtrasDefecto='0';
        
                echo '<div class="alert alert-success"><strong>Success!</strong> Bienvenido...!</div>';
                              
                date_default_timezone_set("America/Argentina/Buenos_Aires");  
                            echo date("l jS \of F Y H:i:s");

                
                $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$q'");
                  $rowcount1=mysqli_num_rows($resulta);
                     while($row = mysqli_fetch_array($resulta)) {

                      /*Imprimir campo por nombre*/
                      $idTrabajador= $row['idTrabajador'];
              

                 $ret=mysqli_query($con,"INSERT INTO `entradat`(idTrabajador,fechaEntradaT,horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras) VALUES ('$idTrabajador','$fecha','$hora','$fecha','$salidaDefecto','$horasTrabajadasDefecto','$horasExtrasDefecto')");
 


                          
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