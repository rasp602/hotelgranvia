<?php
include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
$id=$_REQUEST['id'];


mysqli_select_db($con,"ajax_demo");

		$query = mysqli_query($con,"SELECT count(*) AS cantidad FROM persona WHERE idPersona!=''");	
	
		if (mysqli_num_rows($query) > 0){
	
    			while($row = mysqli_fetch_array($query))
                {   	 
                    $cantidad = $row ['cantidad'];
                  

                    if ($row) {
                       echo $cantidad; 
                    }
                    else{
                         echo "sin datos";
                    }
        
                   
			     }					
		} else 
            {		          
             echo "No hay datos para mostrar..!"; 
	        }
?>
