<?php
ob_start();
?>
<?php
require_once 'login/modelo/usuarios.php';

class LoginController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Alumno();
    }
          

    public function Procesar() {
            
            $alm = new Alumno(); 
            $alm->Email = $_REQUEST["txtUsuario"];
            $alm->Password = $_REQUEST["txtPassword"];

            if ($alm->Email!="" || $alm->Password!="") {

           

    $operador=$this->model->validarUsuario($alm->Email,$alm->Password);
             
      if ($operador != null) {



    $nivel=$this->model->validarNivel($alm->Email);
    

        if ($nivel->nivel == "I") {
                session_start();
                $_SESSION["usuarioInventario"] = $operador;
                header("Location: ?c=menu_principal&a=menu_Inventario");
        }

        if ($nivel->nivel == "F") {
                session_start();
                $_SESSION["usuarioInventario"] = $operador;
                header("Location: ?c=menu_principal&a=menu_fiscalizador");
        }

        if ($nivel->nivel == "T") {
                session_start();
                $_SESSION["usuarioInventario"] = $operador;
                header("Location: ?c=ingreso&a=miIngreso");
        }

        elseif ($nivel->nivel == "U") {
                session_start();
                $_SESSION["usuarioInventario"] = $operador;
                header("Location: ?c=menu_principal&a=menu_usuarios");

        }               
         
                
            } else {
                header("Location: login/vista/login.php?error=1");
            }

        }

    }


     public function ProcesarRegistro() {
            
            $alm = new Alumno(); 
            $alm->Email = $_REQUEST["txtUsuarios"];
           

            if ($alm->Email=='') {
                $operadores=1;
           

   
                session_start();
                $_SESSION["usuario"] = $operadores;
                header("Location: ?c=menu_principal&a=menu_principal");

   

        }

    }

}
?>
<?php
ob_end_flush();
?>