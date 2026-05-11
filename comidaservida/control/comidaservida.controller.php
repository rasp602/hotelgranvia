<?php
require_once 'comidaservida/modelo/comidaServida.php';


class comidaServidaController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new ComidaServida();
    }
    

        public function menuComidaServida(){
        require_once 'includes/header.php'; 
        require_once 'comidaservida/vista/comidaServida_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new ComidaServida();
        
        if(isset($_REQUEST['idComidaservida'])){
            $vte = $this->model->Obtener($_REQUEST['idComidaservida']);
        }
        
        require_once 'includes/header.php';
        require_once 'comidaservida/vista/comidaServida_edit.php';
        require_once 'includes/footer.php';
    }
        public function Crud1(){
        $vte = new ComidaServida();
        
        if(isset($_REQUEST['idComidaservida'])){
            $vte = $this->model->Obtener($_REQUEST['idComidaservida']);
        }
        
        require_once 'includes/header.php';
        require_once 'comidaservida/vista/comidaServida_editar.php';
        require_once 'includes/footer.php';
    }

    public function Guardar(){
        $vte = new ComidaServida();                      
        $vte->idComidaservida = $_REQUEST['idComidaservida'];        
        $vte->idHotel = $_REQUEST['idHotel']; 
        $vte->tipoComida = $_REQUEST['tipoComida'];      
        $vte->fechaComida = $_REQUEST['fechaComida'];
        $vte->cantidad = $_REQUEST['cantidad'];
        $vte->idEmpresa = $_REQUEST['idEmpresa'];

        
 if ($vte->idComidaServida!="") 
    {         
        $this->model->Actualizar($vte);
        header('Location: ?c=comidaservida&a=menuComidaServida&update=1');
    }
else{
        $this->model->Registrar($vte);
        header('Location: ?c=comidaservida&a=menuComidaServida&success=1');
    }                


   }
 
     
     
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idComidaservida']);
        header('Location: ?c=comidaservida&a=menuComidaServida&delete=1');
    }

}

?>