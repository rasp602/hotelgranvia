<?php
include_once '../../bd/conexion.php';
$id=$_REQUEST['id'];
mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM trabajador WHERE qrTrabajador = '".$id."'";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
    
    while($row = mysqli_fetch_array($result)) {
 
        $idTrabajador = $row ['idTrabajador'];
      

    echo "<option value=".$idTrabajador.">".$idTrabajador."</option>";    
 
}

} else {
    echo $idTrabajador;
}
mysqli_close($con);
?>
