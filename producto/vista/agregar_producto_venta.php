<?php   
    include_once "producto/vista/funciones.php";
    session_start();
    if(isset($_POST['agregar'])){
    
        if(isset($_POST['codigo'])) {
            $codigo = $_POST['codigo'];
            $producto = obtenerProductoPorCodigo($codigo);
            if(!$producto) {
                echo "
                <script type='text/javascript'>
                    window.location.href='g_orden.php'
                    alert('No se ha encontrado el producto')
                </script>";
                return;
            }
            
            print_r($producto);
            $_SESSION['lista'] = agregarProductoALista($producto,  $_SESSION['lista']);
            unset($_POST['codigo']);
            header("location: g_orden.php");
        }
    }

?>