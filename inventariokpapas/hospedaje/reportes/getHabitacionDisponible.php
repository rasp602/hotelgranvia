<?php
include_once '../../bd/conexionLocal.php';
$id=$_REQUEST['id'];
mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM habitacion WHERE idHotel = '".$id."' and estado = 'A' ORDER BY nHabitacion";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
   echo" <option value=".$idHabitacion.">Selecione una habitación</option> "; 
    while($row = mysqli_fetch_array($result)) {
 
        $idHabitacion = $row ['idHabitacion'];
        $nHabitacion = $row ['nHabitacion'];

    echo" <option value=".$idHabitacion.">".$nHabitacion."</option> ";
 
}

} else {
    echo "$id";
}
mysqli_close($con);
?>
