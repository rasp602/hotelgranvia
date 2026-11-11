<?php
include_once '../../bd/conexionLocal.php';
$id=$_REQUEST['id'];
mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM cama WHERE idHabitacion = '".$id."' and estadoCama LIKE 'A'  ";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
    
    while($row = mysqli_fetch_array($result)) {
 
        $idCama = $row ['idCama'];
        $nCama = $row ['nCama'];

    echo" <option value=".$idCama.">".$nCama."</option> ";    
 
}

} else {
    echo "$idCama";
}
mysqli_close($con);
?>
