<?php
require_once 'comidaespecial/modelo/comidaespecial.php';


class comidaEspecialController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new ComidaEspecial();
    }
    

        public function menuComidaEspecial(){
        require_once 'includes/header.php'; 
        require_once 'comidaespecial/vista/comidaespecial_list.php';
        require_once 'includes/footer.php';
    }

      
     
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idComidaEspecial']);
        header('Location: ?c=comidaEspecial&a=menuComida&delete=1');
    }

}

?>