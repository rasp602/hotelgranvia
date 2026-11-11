    <?php
require_once 'salida/modelo/salida.php';


class SalidaController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Salida();
    }
    

        public function menuSalidaT(){
        require_once 'includes/header.php'; 
        require_once 'salida/vista/salida_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Salida();
        
        if(isset($_REQUEST['idSalida'])){
            $vte = $this->model->Obtener($_REQUEST['idSalida']);
        }
        
        require_once 'includes/header.php';
        require_once 'salida/vista/salida_edit.php';
        require_once 'includes/footer.php';
    }
        public function Crud1(){
        $vte = new Salida();
        
        if(isset($_REQUEST['idSalida'])){
            $vte = $this->model->Obtener($_REQUEST['idSalida']);
        }
        
        require_once 'includes/header.php';
        require_once 'salida/vista/salida_editar.php';
        require_once 'includes/footer.php';
    }

      


     
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idEntradaT']);
        header('Location: ?c=entradaT&a=menuEntradaT&delete=1');
    }

}

?>