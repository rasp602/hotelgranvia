<?php
require_once 'producto/modelo/producto.php';


class productoController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Producto();
    }
            public function menuProducto(){
        require_once 'includes/header_producto.php'; 
        require_once 'producto/vista/producto_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        }
        
        require_once 'includes/header_producto.php'; 
        require_once 'producto/vista/producto_ingreso.php';
        require_once 'includes/footer.php';
   
    }
    public function CrudOrden(){
        $vte = new Producto();
        
        
        require_once 'includes/header_producto.php'; 
        require_once 'producto/vista/g_orden.php';
        require_once 'includes/footer.php';
   
    }

        public function CrudIngreso(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        }
        
        require_once 'includes/header_producto.php'; 
        require_once 'producto/vista/producto_ingreso_varios_lector.php';
        require_once 'includes/footer.php';
   
    }

        public function CrudIngresoDescripcion(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        }
        
        require_once 'includes/header_producto.php'; 
        require_once 'producto/vista/producto_ingreso_varios.php';
        require_once 'includes/footer.php';
   
    }
       
    public function Crud2(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        
}
        require_once 'includes/header_producto.php'; 
        require_once 'producto/vista/producto_egreso.php';
        require_once 'includes/footer.php';
   
    
}

    public function Crud4(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        
}
        require_once 'includes/header_producto.php'; 
        require_once 'producto/vista/producto_egreso_varios.php';
        require_once 'includes/footer.php';
   
    
}


        public function Crud1(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        }
        
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/producto_editar.php';
        require_once 'includes/footer.php';
    }

        public function verPedido(){
        $vte = new Producto();
    
        if(isset($_GET['idPedido'])){ // Usamos $_GET para obtener el id de la URL
            $id = $_GET['idPedido']; // Capturamos el ID
        } else {
            $id = null; // En caso de que no haya ID
        }
    
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/pedido_ver.php'; // $id estará disponible aquí
        require_once 'includes/footer.php';
    }

    public function Crud3(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        }
        
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/producto_edit.php';
        require_once 'includes/footer.php';
    }
    public function verOrden(){
        $vte = new Producto();
    
        if(isset($_GET['id'])){ // Usamos $_GET para obtener el id de la URL
            $id = $_GET['id']; // Capturamos el ID
        } else {
            $id = null; // En caso de que no haya ID
        }
    
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/orden_ver.php'; // $id estará disponible aquí
        require_once 'includes/footer.php';
    }
    public function verOrdenPreparada(){
        $vte = new Producto();
    
        if(isset($_GET['id'])){ // Usamos $_GET para obtener el id de la URL
            $id = $_GET['id']; // Capturamos el ID
        } else {
            $id = null; // En caso de que no haya ID
        }
    
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/orden_ver_preparada.php'; // $id estará disponible aquí
        require_once 'includes/footer.php';
    }
    
        public function menuPedidos(){
        $vte = new Producto();
        
          
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/pedidos_list.php';
        require_once 'includes/footer.php';
    }
    
    public function menuOrdenes(){
        $vte = new Producto();
        
          
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/ordenes_list.php';
        require_once 'includes/footer.php';
    }
    public function menuOrdenesPreparadas(){
        $vte = new Producto();
        
        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        }
        
        require_once 'includes/header_producto.php';
        require_once 'producto/vista/ordenes_preparadas_list.php';
        require_once 'includes/footer.php';
    }

public function Guardar(){
    $vte = new producto();

    $vte->idProducto         = isset($_REQUEST['idProducto']) ? $_REQUEST['idProducto'] : "";
    $vte->nombreProducto     = isset($_REQUEST['nombreProducto']) ? $_REQUEST['nombreProducto'] : "";
    $vte->precioProducto     = isset($_REQUEST['precioProducto']) ? $_REQUEST['precioProducto'] : 0;
    $vte->codigoBarra        = isset($_REQUEST['codigoBarra']) ? $_REQUEST['codigoBarra'] : "";
    $vte->existenciaProducto = isset($_REQUEST['existenciaProducto']) ? $_REQUEST['existenciaProducto'] : 0;
    $vte->fechaIngreso       = isset($_REQUEST['fechaIngreso']) ? $_REQUEST['fechaIngreso'] : date('Y-m-d');
    $vte->idTipoProducto     = isset($_REQUEST['idTipoProducto']) ? $_REQUEST['idTipoProducto'] : "";
    $vte->imagenProducto     = "";
    $vte->estado     = 1;

    $carpetaDestino = "img/productos/";

    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    if (isset($_FILES["imagenProducto"]) && $_FILES["imagenProducto"]["error"] == 0) {

        $nombreOriginal = $_FILES["imagenProducto"]["name"];
        $tmpArchivo     = $_FILES["imagenProducto"]["tmp_name"];
        $tamanoArchivo  = $_FILES["imagenProducto"]["size"];

        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        $extPermitidas = array("jpg", "jpeg", "png", "webp");

        if (in_array($extension, $extPermitidas) && $tamanoArchivo <= 2000000) {
            $nombreNuevo = time() . "_" . mt_rand(1000,9999) . "." . $extension;
            $rutaFinal   = $carpetaDestino . $nombreNuevo;

            if (move_uploaded_file($tmpArchivo, $rutaFinal)) {
                $vte->imagenProducto = $nombreNuevo;
            }
        }
    }

    if ($vte->idProducto != "") {

        if ($vte->imagenProducto == "") {
            $vte->imagenProducto = isset($_REQUEST['imagenActual']) ? $_REQUEST['imagenActual'] : "";
        }

        $this->model->Actualizar($vte);
        header('Location: ?c=producto&a=menuProducto&update=1');
        exit;

    } else {

        $this->model->Registrar($vte);
        header('Location: ?c=producto&a=menuProducto&success=1');
        exit;
    }
}
     

    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idProducto']);
        header('Location: ?c=producto&a=menuProducto&delete=1');
    }


    public function EliminarOrden()
{
    $idVenta = $_REQUEST['id'];
    $this->model->EliminarOrden($_REQUEST['id']);
    // Obtener los productos relacionados con la venta
    $productos = $this->model->ObtenerProductosVentaEliminar($_REQUEST['id']);

    // Actualizar las cantidades en la tabla producto
    foreach ($productos as $producto) {
        $this->model->ActualizarCantidadProducto($producto['idProducto'], $producto['cantidad']);
    }

    // Eliminar la orden de productos_ventas
    $this->model->EliminarProductosOrden($_REQUEST['id']);

    // Redirigir después de eliminar
    header('Location: ?c=producto&a=menuOrdenes&delete=1');
}

    public function EliminarPedido()
{
    $idPedido = $_REQUEST['idPedido'];
    $this->model->EliminarPedido($idPedido);
    // Obtener los productos relacionados con la venta

    // Redirigir después de eliminar
    header('Location: ?c=producto&a=menuPedidos&delete=1');
}


public function EliminarOrdenPreparadas(){
    $this->model->EliminarOrdenPreparada($_REQUEST['id']);

    $this->model->EliminarProductosOrdenPreparada($_REQUEST['id']);
    header('Location: ?c=producto&a=menuOrdenesPreparadas&delete=1');
}

public function MarcarEntregado(){
    $id = $_REQUEST['id'];
    $this->model->MarcarEntregado($id);
    header("Location: ?c=producto&a=menuOrdenes");
}

public function menuHistorialInventario()
{
    $filtros = array(
        'fechaDesde' => isset($_GET['fechaDesde']) ? trim($_GET['fechaDesde']) : '',
        'fechaHasta' => isset($_GET['fechaHasta']) ? trim($_GET['fechaHasta']) : '',
        'idUsuario'  => isset($_GET['idUsuario']) ? trim($_GET['idUsuario']) : '',
        'tipo'       => isset($_GET['tipo']) ? trim($_GET['tipo']) : '',
        'buscar'     => isset($_GET['buscar']) ? trim($_GET['buscar']) : '',
        'pagina'     => isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1
    );

    $movimientos = $this->model->ListarMovimientosInventario($filtros);

    $usuariosInventario = $this->model->ListarUsuariosInventario();

    $resumenInventario = $this->model->ResumenMovimientosInventario($filtros);

    require_once 'includes/header_producto.php';
    require_once 'producto/vista/inventario_historial.php';
    require_once 'includes/footer.php';
}
    public function CrudEgresoDescripcion(){
        $vte = new Producto();

        if(isset($_REQUEST['idProducto'])){
            $vte = $this->model->Obtener($_REQUEST['idProducto']);
        }

        require_once 'includes/header_producto.php';
        require_once 'producto/vista/producto_egreso_descripcion.php';
        require_once 'includes/footer.php';
    }

    public function ApiEgresoDescripcion()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        try {
            if (empty($_SESSION['usuarioInventario']->idUsuario)) {
                http_response_code(403);
                throw new InvalidArgumentException('Debe iniciar sesión en inventario.');
            }
            $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
            if ($accion === 'buscar') {
                $resultado = array('success' => true, 'productos' => $this->model->BuscarProductosEgreso(isset($_POST['busqueda']) ? trim($_POST['busqueda']) : ''));
            } elseif ($accion === 'ultimos') {
                $resultado = array('success' => true, 'movimientos' => $this->model->UltimosEgresosDescripcion());
            } elseif ($accion === 'egresar') {
                $token = isset($_POST['token']) ? $_POST['token'] : '';
                if (empty($_SESSION['csrfEgresoDescripcion']) || !is_string($token) || !hash_equals($_SESSION['csrfEgresoDescripcion'], $token)) {
                    throw new InvalidArgumentException('Sesión vencida. Recargue la página.');
                }
                $id = isset($_POST['idProducto']) ? $_POST['idProducto'] : '';
                $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
                if (filter_var($id, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) === false ||
                    filter_var($cantidad, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) === false) {
                    throw new InvalidArgumentException('Seleccione un producto y una cantidad entera mayor que cero.');
                }
                $details = $this->model->EgresarPorDescripcion((int)$id, (int)$cantidad, (int)$_SESSION['usuarioInventario']->idUsuario);
                $resultado = array('success' => true, 'message' => 'Egreso registrado correctamente.', 'details' => $details);
            } else {
                throw new InvalidArgumentException('Acción inválida.');
            }
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        } catch (InvalidArgumentException $e) {
            echo json_encode(array('success' => false, 'message' => $e->getMessage()), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        } catch (Exception $e) {
            error_log('Egreso por descripción: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(array('success' => false, 'message' => 'No se pudo completar la operación. Revise la conexión y el registro de errores.'));
        }
        exit;
    }

}

?>