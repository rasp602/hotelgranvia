<?php
include_once '../../bd/conexionLocal.php';
$id=$_REQUEST['id'];

mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM persona WHERE idPersona='$id'";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
	
	while($row = mysqli_fetch_array($result)) {
		  $nombre = $row ['nombresPersona'];
		
		
    echo  $nombre;
}

} else {
	echo $nombre;
}
mysqli_close($con);
?>
