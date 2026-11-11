<?php
$id=$_REQUEST['id'];
include '../../bd/conexion.php'; //incluir el archivo de conexion

		$query = mysqli_query($con,"SELECT linea.idLinea,linea.nLinea,linea.presidente,linea.telefono,maquina.idMaquina,maquina.nMaquina,maquina.idLinea
                FROM linea
                INNER JOIN maquina ON maquina.idLinea=linea.idLinea 
                WHERE linea.idLinea = '".$id."' ORDER BY maquina.idMaquina");	
		
		if (mysqli_num_rows($query) > 0){
	
    			while($row = mysqli_fetch_array($query))
                {   	 
                    $idMaquina = $row ['idMaquina'];
                    $nMaquina = $row ['nMaquina'];
                  
                    echo" <option value=".$idMaquina.">".$nMaquina."</option> ";
			     }					
		} else 
            {		          
             echo "No hay datos para mostrar..!"; 
	        }
?>
