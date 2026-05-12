if ($idLinea!="") {
    $where="where linea.idLinea ='".$idLinea."' AND usuario.id_user = '".$usuario."'";
   /* echo "if idlinea"; */
}

if ($estado!="") {
    $where="where actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
    /*echo "if status"; */
}

if ($descripcion!="") {
    $where="where actividad.descripcion LIKE '%".$descripcion."%' OR maquina.nMaquina LIKE '%".$descripcion."%' AND usuario.id_user = '".$usuario."'";
   /* echo "if descripcion"; */
}


if ($tipoA!="" && $idLinea!="" && $estado=="" && $descripcion=="") {
    $where="where actividad.tipoA LIKE '".$tipoA."' AND linea.idLinea ='".$idLinea."' AND usuario.id_user = '".$usuario."'";
    /*echo "actividad y linea"; */   
}

if ($tipoA=="1" && $idMaquina!=112 ) {
    $where="where actividad.tipoA LIKE '".$tipoA."' AND linea.idLinea ='".$idLinea."' AND actividad.idMaquina ='".$idMaquina."' AND usuario.id_user = '".$usuario."'";
    /*echo "actividad y linea"; */   
}

if ($tipoA!="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND linea.idLinea ='".$idLinea."' AND  actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
   /* echo "actividad,linea,estado"; */  
}
if ($tipoA=="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where linea.idLinea ='".$idLinea."' AND  actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
    /*echo "linea,estado";  */ 
}

if ($tipoA!="" && $idLinea==""  && $estado!="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND actividad.StatusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
    /*echo "actividad,estado";    */
}

if ($tipoA=="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where linea.idLinea ='".$idLinea."' AND  actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
   /* echo "linea,estado"; */
}
if ($tipoA=="" && $idLinea!=""  && $estado=="" && $descripcion=="") {
    $where="where linea.idLinea ='".$idLinea."' AND usuario.id_user = '".$usuario."'";
    /*echo "linea";    */
}

if ($tipoA!="" && $idLinea!="" && $estado=="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND linea.idLinea ='".$idLinea."'  AND usuario.id_user = '".$usuario."'";
    /*echo "actividad,linea";    */
}
if ($tipoA!="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND linea.idLinea ='".$idLinea."' AND actividad.StatusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
    /*echo "actividad,linea,estado";  */  
}
if ($tipoA=="" && $idLinea=="" && $estado=="" && $descripcion=="" && $desde!="" && $hasta!="") {
    $where="where actividad.fechaA BETWEEN '".$desde."' AND '".$hasta."' AND usuario.id_user = '".$usuario."'";
   /* echo "actividad,linea,estado";    */
}

elseif ($tipoA!="" && $idLinea!="" && $estado!="" && $descripcion!=""){
     $where="where actividad.tipoA LIKE '".$tipoA."' AND linea.idLinea ='".$idLinea."' AND actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
   /* echo "if todo"; */
}