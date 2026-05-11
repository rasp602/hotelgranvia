<?php
require_once 'comidaextra/modelo/comidaExtra.php';


class comidaextraController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new ComidaExtra();
    }
    

        public function menuComidaExtra(){
        require_once 'includes/header.php'; 
        require_once 'comidaextra/vista/comidaExtra_list.php';
        require_once 'includes/footer.php';
    }

        public function menuComidaExtraEmpresa(){
        require_once 'includes/header.php'; 
        require_once 'comidaextra/vista/comidaExtra_list_empresa.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new ComidaExtra();
        
        if(isset($_REQUEST['idComidaExtra'])){
            $vte = $this->model->Obtener($_REQUEST['idComidaExtra']);
        }
        
        require_once 'includes/header.php';
        require_once 'comidaextra/vista/comidaExtra_edit.php';
        require_once 'includes/footer.php';
    }
        public function Crud1(){
        $vte = new ComidaExtra();
        
        if(isset($_REQUEST['idComidaExtra'])){
            $vte = $this->model->Obtener($_REQUEST['idComidaExtra']);
        }
        
        require_once 'includes/header.php';
        require_once 'comidaextra/vista/comidaExtra_editar.php';
        require_once 'includes/footer.php';
    }

    public function Guardar(){
        $vte = new ComidaExtra();                      
        $vte->idComidaExtra = $_REQUEST['idComidaExtra'];
        $vte->tipoComida = $_REQUEST['tipoComida'];
        $vte->horaComida = $_REQUEST['horaComida'];
       
        $vte->fechaComida = $_REQUEST['fechaComida'];
        $vte->persona = $_REQUEST['persona'];
        $vte->observacion = $_REQUEST['observacion'];
        $vte->idEmpresa = $_REQUEST['idEmpresa'];
        
 if ($vte->idComida!="") 
    {         
        $this->model->Actualizar($vte);
        header('Location: ?c=comidaextra&a=menuComidaExtra&update=1');
    }
else{
        $this->model->Registrar($vte);
        header('Location: ?c=comidaextra&a=menuComidaExtra&success=1');
    }                


   }
 
     
     
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idComidaExtra']);
        header('Location: ?c=comidaExtra&a=menuComidaExtra&delete=1');
    }

}

?>