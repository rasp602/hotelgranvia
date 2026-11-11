<?php

define("PASSWORD_PREDETERMINADA", "$2y$10$423UIQT9e.VO075rZHNek.pnMs08Ddx5Y0cgKHXoPYwKf2agl5Eg.");
define("HOY", date("Y-m-d"));
date_default_timezone_set("America/Santiago");

function iniciarSesion($usuario, $password){
    $sentencia = "SELECT idUsuario, usuario FROM usuario WHERE usuario  = ?";
    $resultado = select($sentencia, [$usuario]);
    if($resultado){
        $usuario = $resultado[0];
        $verificaPass = verificarPassword($usuario->usuario, $password);
        if($verificaPass) return $usuario;
    }
}

function verificarPassword($usuario, $password){
    $sentencia = "SELECT password FROM usuario WHERE usuario = ?";
    $contrasenia = select($sentencia, [$usuario])[0]->password;
    $verifica = password_verify($password, $contrasenia);
    if($verifica) return true;
}

function cambiarPassword($idUsuario, $password){
    $nueva = password_hash($password, PASSWORD_DEFAULT);
    $sentencia = "UPDATE usuario SET password = ? WHERE idUsuario = ?";
    return editar($sentencia, [$nueva, $idUsuario]);
}

function eliminarUsuario($idUsuario){
    $sentencia = "DELETE FROM usuario WHERE idUsuario = ?";
    return eliminar($sentencia, $idUsuario);
}

function editarUsuario($usuario, $nombre, $telefono, $direccion, $idUsuario){
    $sentencia = "UPDATE usuario SET usuario = ?, nombre = ?, telefono = ?, direccion = ? WHERE idUsuario = ?";
    $parametros = [$usuario, $nombre, $telefono, $direccion, $idUsuario];
    return editar($sentencia, $parametros);
}

function obtenerUsuarioPorId($idUsuario){
    $sentencia = "SELECT idUsuario, usuario, nombre, telefono, direccion FROM usuario WHERE idUsuario = ?";
    return select($sentencia, [$idUsuario])[0];
}

function obtenerUsuarios(){
    $sentencia = "SELECT idUsuario, usuario, nombre, telefono, direccion FROM usuario";
    return select($sentencia);
}

function registrarUsuario($usuario, $nombre, $telefono, $direccion){
    $password = password_hash(PASSWORD_PREDETERMINADA, PASSWORD_DEFAULT);
    $sentencia = "INSERT INTO usuarios (usuario, nombre, telefono, direccion, password) VALUES (?,?,?,?,?)";
    $parametros = [$usuario, $nombre, $telefono, $direccion, $password];
    return insertar($sentencia, $parametros);
}


function eliminarCliente($id){
    $sentencia = "DELETE FROM clientes WHERE id = ?";
    return eliminar($sentencia, $id);
}

function editarCliente($nombre, $telefono, $direccion, $id){
    $sentencia = "UPDATE clientes SET nombre = ?, telefono = ?, direccion = ? WHERE id = ?";
    $parametros = [$nombre, $telefono, $direccion, $id];
    return editar($sentencia, $parametros);
}

function obtenerClientePorId($idHotel){
    $sentencia = "SELECT * FROM hotel WHERE idHotel = ?";
    $cliente = select($sentencia, [$idHotel]);
    if($cliente) return $cliente[0];
}

function obtenerClientes(){
    $sentencia = "SELECT * FROM hotel";
    return select($sentencia);
}
function obteneridVenta(){
    $sentencia = "SELECT MAX( id ) FROM ventas";
    $cliente1 = select($sentencia, []);
    if($cliente1) return $cliente1[0];
}

function registrarCliente($nombre, $telefono, $direccion){
    $sentencia = "INSERT INTO clientes (nombre, telefono, direccion) VALUES (?,?,?)";
    $parametros = [$nombre, $telefono, $direccion];
    return insertar($sentencia, $parametros);
}

function obtenerNumeroVentas(){
    $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM ventas";
    return select($sentencia)[0]->total;
}

function obtenerNumeroUsuarios(){
    $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM usuarios";
    return select($sentencia)[0]->total;
}

function obtenerNumeroClientes(){
    $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM clientes";
    return select($sentencia)[0]->total;
}


function obtenerVentasPorUsuario(){
    $sentencia = "SELECT SUM(ventas.total) AS total,SUM(ventas.gananciaG) AS ganancia, usuarios.usuario, COUNT(*) AS numeroVentas 
    FROM ventas
    INNER JOIN usuarios ON usuarios.idUsuario = ventas.idUsuario
    GROUP BY ventas.idUsuario
    ORDER BY total DESC";
    return select($sentencia);
}

function obtenerVentasPorCliente(){
    $sentencia = "SELECT SUM(ventas.total) AS total, IFNULL(clientes.nombre, 'MOSTRADOR') AS cliente,
    COUNT(*) AS numeroCompras
    FROM ventas
    LEFT JOIN clientes ON clientes.id = ventas.idCliente
    GROUP BY ventas.idCliente
    ORDER BY total DESC";
    return select($sentencia);
}

function obtenerProductosMasVendidos(){
    $sentencia = "SELECT SUM(productos_ventas.cantidad * productos_ventas.precio) AS total, SUM(productos_ventas.cantidad) AS unidades,
    productos.nombre FROM productos_ventas INNER JOIN productos ON productos.id = productos_ventas.idProducto
    GROUP BY productos_ventas.idProducto
    ORDER BY total DESC
    LIMIT 10";
    return select($sentencia);
}

function obtenerTotalVentas($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas";
    if(isset($idUsuario)){
        $sentencia .= " WHERE idUsuario = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function obtenerTotalVentasHoy($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas WHERE DATE(fecha) = CURDATE() ";
    if(isset($idUsuario)){
        $sentencia .= " AND idUsuario = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function obtenerTotalVentasSemana($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas  WHERE WEEK(fecha) = WEEK(NOW())";
    if(isset($idUsuario)){
        $sentencia .= " AND  idUsuario = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function obtenerTotalVentasMes($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas  WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
    if(isset($idUsuario)){
        $sentencia .= " AND  idUsuario = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function calcularTotalVentas($ventas){
    $total = 0;
    foreach ($ventas as $venta) {
        $total += $venta->total;
    }
    return $total;
}

function calcularProductosVendidos($ventas){
    $total = 0;
    foreach ($ventas as $venta) {
        foreach ($venta->productos as $producto) {
            $total += $producto->cantidad;
        }
    }
    return $total;
}

function obtenerGananciaVentas1($ventas){
    $total = 0;
    foreach ($ventas as $venta) {
        foreach ($venta->productos as $producto) {
            $total += $producto->cantidad * ($producto->precio - $producto->compra);
        }
    }
    return $total;
}

function obtenerGananciaVentas($ventas){
    $total = 0;
    foreach ($ventas as $venta) {
       
            $total += $venta->gananciaG;
        
    }
    return $total;
}

function obtenerVentas($fechaInicio, $fechaFin, $cliente, $usuario) {
    $parametros = [];
    $sentencia  = "SELECT ventas.*, usuarios.usuario, IFNULL(clientes.nombre, 'MOSTRADOR') AS cliente
                   FROM ventas 
                   INNER JOIN usuarios ON usuarios.idUsuario = ventas.idUsuario
                   LEFT JOIN clientes ON clientes.id = ventas.idCliente ";

    $condiciones = [];

    if (isset($usuario)) {
        $condiciones[] = "ventas.idUsuario = ?";
        array_push($parametros, $usuario);
    }

    if (isset($cliente)) {
        $condiciones[] = "ventas.idCliente = ?";
        array_push($parametros, $cliente);
    }

    if (empty($fechaInicio) && empty($fechaFin)) {
        $condiciones[] = "DATE(ventas.fecha) = ?";
        array_push($parametros, HOY);
    } elseif (isset($fechaInicio) && isset($fechaFin)) {
        $condiciones[] = "DATE(ventas.fecha) >= ? AND DATE(ventas.fecha) <= ?";
        array_push($parametros, $fechaInicio, $fechaFin);
    }

    // Si hay condiciones, las agregamos a la consulta
    if (count($condiciones) > 0) {
        $sentencia .= " WHERE " . implode(" AND ", $condiciones);
    }

    // Ordenamos por id de mayor a menor
    $sentencia .= " ORDER BY ventas.id DESC";

    // Ejecutamos la consulta
    $ventas = select($sentencia, $parametros);

    // Retornamos las ventas con los productos vendidos agregados
    return agregarProductosVendidos($ventas);
}
function agregarProductosVendidos($ventas){
    foreach($ventas as $venta){
        $venta->productos = obtenerProductosVendidos($venta->id);
    }
    return $ventas;
}

function obtenerProductosVendidos($idVenta){
    $sentencia = "SELECT productos_ventas.cantidad, productos_ventas.precio, productos.nombre,
    productos.compra
    FROM productos_ventas
    INNER JOIN productos ON productos.id = productos_ventas.idProducto
    WHERE idVenta  = ? ";
    return select($sentencia, [$idVenta]);
}



function registrarVenta($productos, $idUsuario, $idHotel, $total,$tipoEntrega,$gananciaG){
    $sentencia =  "INSERT INTO ventas (fecha, total, idUsuario, idHotel,tipoEntrega,gananciaG) VALUES (?,?,?,?,?,?)";
    $parametros = [date("Y-m-d H:i:s"), $total, $idUsuario, $idHotel,$tipoEntrega,$gananciaG];

    $resultadoVenta = insertar($sentencia, $parametros);
    if($resultadoVenta){
        $idVenta = obtenerUltimoIdVenta();
        $productosRegistrados = registrarProductosVenta($productos, $idVenta);
        return $resultadoVenta && $productosRegistrados;
        
    }
}
function registrarVentaPreparado($productos, $idUsuario, $idHotel, $total,$tipoEntrega,$gananciaG){
    $sentencia =  "INSERT INTO ventas_preparada (fecha, total, idUsuario, idHotel,tipoEntrega,gananciaG) VALUES (?,?,?,?,?,?)";
    $parametros = [date("Y-m-d H:i:s"), $total, $idUsuario, $idHotel,$tipoEntrega,$gananciaG];

    $resultadoVenta = insertar($sentencia, $parametros);
    if($resultadoVenta){
        $idVentaPreparada = obtenerUltimoIdVentaPreparada();
        $productosRegistrados = registrarProductosVentaPreparada($productos, $idVentaPreparada);
        return $resultadoVenta && $productosRegistrados;
        
    }
}
/*CALCULAR PORCENTAJE*/
function registrarProductosVenta($productos, $idVenta) {
    $sentencia = "INSERT INTO productos_ventas (cantidad, precio, idProducto, idVenta) VALUES (?,?,?,?)";
    
    foreach ($productos as $producto) {
        // Insertar la venta de cada producto
        $parametros = [$producto->cantidad, $producto->precioProducto, $producto->idProducto, $idVenta];
        insertar($sentencia, $parametros);
        
        // Descontar la cantidad vendida del inventario
        descontarProductos($producto->idProducto, $producto->cantidad);
        
        // Registrar el descuento en el inventario
        registrarDescuento($producto);
    }
    
    return true;
}

function registrarDescuento($producto) {
    // Obtener el stock actual del producto antes de registrar el movimiento
    //$stockActual = obtenerStockProducto($producto->idProducto); // Necesitas definir esta función para obtener el stock actual

    // Sentencia para registrar el movimiento en el inventario
    $sentencia =  "INSERT INTO inventario (fechaRegistro, horaRegistro, idProducto, cantRegistro, tipoRegistro, ultimoStock) VALUES (?,?,?,?,?,?)";
    
    // Parámetros para el registro de la salida del inventario
    $parametros = [date("Y-m-d"), date("H:i:s"), $producto->idProducto, $producto->cantidad, "E", $producto->existenciaProducto];
    
    // Insertar el registro de la salida de inventario
    insertar($sentencia, $parametros);
    
    return true;
}


function registrarProductosVentaPreparada($productos, $idVentaPreparada){
    $sentencia = "INSERT INTO productos_preparados (cantidad, precio, idProductoPreparado, idVenta_Preparado) VALUES (?,?,?,?)";
    foreach ($productos as $producto ) {
        $parametros = [$producto->cantidad, $producto->precioProducto, $producto->idProductoPreparado, $idVentaPreparada];
        insertar($sentencia, $parametros);
        descontarProductos($producto->idProductoPreparado, $producto->cantidad);
    }
    return true;
}

function descontarProductos($idProducto, $cantidad){
    $sentencia =  "UPDATE producto SET existenciaProducto  = existenciaProducto - ? WHERE idProducto = ?";
    $parametros = [$cantidad, $idProducto];
    return editar($sentencia, $parametros);
}

function obtenerUltimoIdVenta(){
    $sentencia  = "SELECT id FROM ventas ORDER BY id DESC LIMIT 1";
    return select($sentencia)[0]->id;
}

function obtenerUltimoIdVentaPreparada(){
    $sentencia  = "SELECT id FROM ventas_preparada ORDER BY id DESC LIMIT 1";
    return select($sentencia)[0]->id;
}


/*
function calcularTotalLista($lista){
    $total = 0;
    foreach($lista as $producto){
        $total += floatval($producto->venta * $producto->cantidad);
    }
    return $total;
}*/

function agregarProductoALista($producto, $listaProductos){
    if($producto->existenciaProducto < 1) return $listaProductos;
    $producto->cantidad = 1;
    
    $existe = verificarSiEstaEnLista($producto->idProducto, $listaProductos);

    if(!$existe){
        array_push($listaProductos, $producto);
    } else{
        $existenciaAlcanzada = verificarExistencia($producto->idProducto, $listaProductos, $producto->existenciaProducto);
        
        if($existenciaAlcanzada)return $listaProductos;

        $listaProductos = agregarCantidad($producto->idProducto, $listaProductos);
        }
        
    return $listaProductos;
    
}

function agregarProductoAListaPreparado($producto, $listaProductos){
    if($producto->existenciaProducto < 1) return $listaProductos;
    $producto->cantidad = 1;
    
    $existe = verificarSiEstaEnLista($producto->idProductoPreparado, $listaProductos);

    if(!$existe){
        array_push($listaProductos, $producto);
    } else{
        $existenciaAlcanzada = verificarExistencia($producto->idProidProductoPreparadoducto, $listaProductos, $producto->existenciaProducto);
        
        if($existenciaAlcanzada)return $listaProductos;

        $listaProductos = agregarCantidad($producto->idProductoPreparado, $listaProductos);
        }
        
    return $listaProductos;
    
}

function verificarExistencia($idProducto, $listaProductos, $existencia){
    foreach($listaProductos as $producto){
        if($producto->id == $idProducto){
           if($existencia <= $producto->cantidad) return true; 
        }
    }
    return false;
}

function verificarSiEstaEnLista($idProducto, $listaProductos){
    foreach($listaProductos as $producto){
        if($producto->id == $idProducto){
            return true;
        }
    }
    return false;
}

function agregarCantidad($idProducto, $listaProductos){
    foreach($listaProductos as $producto){
        if($producto->id == $idProducto){
            $producto->cantidad++;
        }
    }
    return $listaProductos;
}

function obtenerProductoPorCodigo($codigo){
    $sentencia = "SELECT * FROM producto WHERE idProducto = ?";
    $producto = select($sentencia, [$codigo]);
    if($producto) return $producto[0];
    return [];
}

function obtenerProductoPreparadoPorCodigo($codigo){
    $sentencia = "SELECT * FROM producto_prepa WHERE idProductoPreparado = ?";
    $producto = select($sentencia, [$codigo]);
    if($producto) return $producto[0];
    return [];
}

function obtenerNumeroProductos(){
    $sentencia = "SELECT IFNULL(SUM(existencia),0) AS total FROM productos";
    $fila = select($sentencia);
    if($fila) return $fila[0]->total;
}

function obtenerTotalInventario(){
    $sentencia = "SELECT IFNULL(SUM(existencia * venta),0) AS total FROM productos";
    $fila = select($sentencia);
    if($fila) return $fila[0]->total;
}

function calcularGananciaProductos(){
    $sentencia = "SELECT IFNULL(SUM(existencia*venta) - SUM(existencia*compra),0) AS total FROM productos";
    $fila = select($sentencia);
    if($fila) return $fila[0]->total;
}

function eliminarProducto($id){
    $sentencia = "DELETE FROM productos WHERE id = ?";
    return eliminar($sentencia, $id);
}

function editarProducto($codigo, $nombre, $compra, $venta, $existencia, $id){
    $sentencia = "UPDATE productos SET codigo = ?, nombre = ?, compra = ?, venta = ?, existencia = ? WHERE id = ?";
    $parametros = [$codigo, $nombre, $compra, $venta, $existencia, $id];
    return editar($sentencia, $parametros);
}

function obtenerProductoPorId($id){
    $sentencia = "SELECT * FROM productos WHERE id = ?";
    return select($sentencia, [$id])[0];
}

function obtenerProductos($busqueda = null){
    $parametros = [];
    $sentencia = "SELECT * FROM productos ";
    if(isset($busqueda)){
        $sentencia .= " WHERE nombre LIKE ? OR codigo LIKE ?";
        array_push($parametros, "%".$busqueda."%", "%".$busqueda."%"); 
    } 
    return select($sentencia, $parametros);
}

function registrarProducto($codigo, $nombre, $compra, $venta, $existencia){
    $sentencia = "INSERT INTO productos(codigo, nombre, compra, venta, existencia) VALUES (?,?,?,?,?)";
    $parametros = [$codigo, $nombre, $compra, $venta, $existencia];
    return insertar($sentencia, $parametros);
}

function select($sentencia, $parametros = []){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute($parametros);
    return $respuesta->fetchAll();
}

function insertar($sentencia, $parametros ){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    return $respuesta->execute($parametros);
}

function eliminar($sentencia, $id ){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    return $respuesta->execute([$id]);
}

function editar($sentencia, $parametros ){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    return $respuesta->execute($parametros);
}

function conectarBaseDatos() {
	$host = "190.101.222.6";
	$db   = "hoteleria";
	$user = "hotel";
	$pass = "chile2023$";
	$charset = 'utf8mb4';

	$options = [
	    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
	    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
	    \PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	try {
	     $pdo = new \PDO($dsn, $user, $pass, $options);
	     return $pdo;
	} catch (\PDOException $e) {
	     throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
}