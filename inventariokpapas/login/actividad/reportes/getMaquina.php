<?php
include_once '../../bd/conexion.php';
$id=$_REQUEST['id'];
mysqli_select_db($con,"ajax_demo");
$sql="SELECT linea.idLinea,linea.nLinea,linea.presidente,linea.telefono,maquina.idMaquina,maquina.nMaquina,maquina.idLinea
				FROM linea
				INNER JOIN maquina ON maquina.idLinea=linea.idLinea 
				WHERE linea.idLinea = '".$id."' ORDER BY maquina.idMaquina";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
	
	while($row = mysqli_fetch_array($result)) {
		$idMaquina = $row ['idMaquina'];
		$nMaquina = $row ['nMaquina'];
		
    echo" <option value=".$idMaquina.">".$nMaquina."</option> ";
}

} else {
	echo $id;
}
mysqli_close($con);
?>
