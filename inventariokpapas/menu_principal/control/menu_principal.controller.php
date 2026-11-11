<?php
require_once 'persona/modelo/persona.php';

class Menu_principalController{    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Persona();
    }


        public function menu_principal(){
        require_once 'includes/header.php';
        require_once 'menu_principal/vista/Menu_admin.php';
        require_once 'includes/footer.php';
    }
        public function menu_usuarios(){
        $consulta = new Persona();
        
        $consulta=$this->model->Personas();
            require_once 'includes/header.php';      
            require_once 'menu_principal/vista/Menu_User.php';
            require_once 'includes/footer.php';
    }
    
        public function menu_fiscalizador(){
        $consulta = new Persona();
        
        $consulta=$this->model->Personas();
            require_once 'includes/header.php';      
            require_once 'menu_principal/vista/Menu_FiscalizadorE.php';
            require_once 'includes/footer.php';
        }
        public function menu_trabajador(){
        $consulta = new Persona();
        
        $consulta=$this->model->Personas();
            require_once 'includes/header.php';      
            require_once 'menu_principal/vista/Menu_Trabajador.php';
            require_once 'includes/footer.php';
        }

        public function menu_Inventario(){
            $consulta = new Persona();
            
            $consulta=$this->model->Personas();
                require_once 'includes/header.php';      
                require_once 'menu_principal/vista/Menu_Invent.php';
                require_once 'includes/footer.php';
            }


}

