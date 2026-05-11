<?php
include_once 'trabajador/descanso/conexionLocal.php';
$nombre=$_REQUEST['nombre'];
mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM trabajador WHERE idTrabajador = '".$nombre."'";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
    
    while($row = mysqli_fetch_array($result)) {
 
        $nombre = $row ['nombreTrabajador'];
     

    echo" <option value=".$nombre.">".$nombre."</option> ";    
 
}

} else {
    echo "$nombre";
}
mysqli_close($con);
?>
