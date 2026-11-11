<?php
include_once '../../bd/conexionLocal.php';
$id=$_REQUEST['id'];
mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM contrato WHERE idEmpresa = '".$id."' ORDER BY idContrato";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
     
    while($row = mysqli_fetch_array($result)) {
 
        $idContrato = $row ['idContrato'];
        $nombreContrato = $row ['nombreContrato'];

    echo" <option value=".$idContrato.">".$nombreContrato."</option> ";
 
}

} else {
    echo $id;
}
mysqli_close($con);
?>
