<?php
require_once 'ingreso/modelo/ingreso.php';


class IngresoController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Ingreso();
    }
    

        public function menuIngreso(){
        require_once 'includes/header.php'; 
        require_once 'ingreso/vista/ingreso_list.php';
        require_once 'includes/footer.php';
    }

        public function miIngreso(){
        require_once 'includes/header.php'; 
        require_once 'ingreso/vista/ingreso_miResumen.php';
        require_once 'includes/footer.php';
    }

            public function miDescanso(){
        require_once 'includes/header.php'; 
        require_once 'ingreso/vista/ingreso_list_trabajador.php';
        require_once 'includes/footer.php';
    }


        public function resumenIngreso(){
        require_once 'includes/header.php'; 
        require_once 'ingreso/vista/resumenIngreso.php';
        require_once 'includes/footer.php';
    }

 public function IngresoDiario(){
        $vte = new Ingreso();

            foreach ($this->model->ConsultaTrabajadores() as $consultaTrabajadores) {

        $idTrabajador=$consultaTrabajadores->idTrabajador;
        $consultaTrabajadores->fecha=date("Y-m-d");  

            $this->model->RegistrarIngresoDiario($consultaTrabajadores);
      
            }

    }

     public function IngresoDiarioPrueba(){
        $vte = new Ingreso();

            foreach ($this->model->ConsultaTrabajadoresInativos() as $consultaTrabajadores) {

        $idTrabajador=$consultaTrabajadores->idTrabajador;
        $consultaTrabajadores->Fecha=date("Y-m-d");  

            $this->model->RegistrarIngresoDiarioPrueba($consultaTrabajadores);
      
            }

    }
    
    public function Crud(){
        $vte = new Ingreso();
        
        if(isset($_REQUEST['idEntradaT'])){
            $vte = $this->model->Obtener($_REQUEST['idEntradaT']);
        }
        
        require_once 'includes/header.php';
        require_once 'ingreso/vista/ingreso_edit.php';
        require_once 'includes/footer.php';
    }
        public function Crud1(){
        $vte = new Ingreso();
        
        if(isset($_REQUEST['idEntradaT'])){
            $vte = $this->model->Obtener($_REQUEST['idEntradaT']);
        }
        
        require_once 'includes/header.php';
        require_once 'ingreso/vista/ingreso_editar.php';
        require_once 'includes/footer.php';
    }

    public function CrudLector(){
        $vte = new Ingreso();
        
        if(isset($_REQUEST['idEntradaT'])){
            $vte = $this->model->Obtener($_REQUEST['idEntradaT']);
        }
        
        require_once 'includes/header.php';
        require_once 'ingreso/vista/ingreso_lector.php';
        require_once 'includes/footer.php';
    }

            public function Crud2(){
        $vte = new Ingreso();
        
        if(isset($_REQUEST['idEntradaT'])){
            $vte = $this->model->ObtenerID($_REQUEST['idEntradaT']);
        }
        
        require_once 'includes/header.php';
        require_once 'ingreso/vista/ingreso_validar.php';
        require_once 'includes/footer.php';
    }


    public function ValidarExtra(){
        $vte = new Ingreso();
                      
        $vte->idEntradaT = $_REQUEST['idEntradaT'];
        $vte->validacion = $_REQUEST['validacion'];
  
        if ($vte->idEntradaT !="") {
            $this->model->ValidarEtra($vte);
             header('Location: ?c=ingreso&a=menuIngreso&update=1');
        }
       
    

        }



     
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idEntradaT']);
        header('Location: ?c=ingreso&a=menuIngreso&delete=1');
    }

}

?>