<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'bd/database.php';
require_once 'bd/databaseServer.php';
require_once 'bd/databaseServerh2.php';
require_once 'bd/databaseServerh3.php';
require_once 'bd/databaseServerh4.php';




// Todo esta lógica hara el papel de un FrontController
if(!isset($_REQUEST['c']))
{
    $controller = $_REQUEST['c'];
    require_once $_REQUEST['c']."/control/$controller.controller.php";
    $controller = ucwords($controller) . 'Controller';
    $controller = new $controller;
    $controller->Index();    
}
else
{
    // Obtenemos el controlador que queremos cargar
    $controller = strtolower($_REQUEST['c']);
    $accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';
    
    // Instanciamos el controlador
    require_once $_REQUEST['c']."/control/$controller.controller.php";
    $controller = ucwords($controller) . 'Controller';
    $controller = new $controller;
    
    // Llama la accion
    call_user_func( array( $controller, $accion ) );
}
?>
