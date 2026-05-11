<?php

require_once 'contrato/modelo/contrato.php';


class contratoController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Contrato();
    }
    

        public function menuTotales(){
        require_once 'includes/header.php';
        require_once 'contrato/vista/contrato_total.php';
        require_once 'includes/footer.php';
    }
        public function menuContrato(){
        require_once 'includes/header.php';
        require_once 'contrato/vista/contrato_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Contrato();
        
        if(isset($_REQUEST['idContrato'])){
            $vte = $this->model->Obtener($_REQUEST['idContrato']);
        }
        
        require_once 'includes/header.php';
        require_once 'contrato/vista/contrato_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Contrato();
        
        if(isset($_REQUEST['idContrato'])){
            $vte = $this->model->Obtener($_REQUEST['idContrato']);
        }
        require_once 'includes/header.php';
        require_once 'contrato/vista/contrato_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Contrato();
        
        if(isset($_REQUEST['idContrato'])){
            $vte = $this->model->Obtener($_REQUEST['idContrato']);
        }
        
        require_once 'includes/header.php';
        require_once 'contrato/vista/contrato_ver.php';
        require_once 'includes/footer.php';
    }




    public function CrudRepetido(){
        $vte = new Contrato();
        
        if(isset($_REQUEST['idContrato'])){
            $vte = $this->model->Obtener($_REQUEST['idContrato']);
        }
        
        require_once 'includes/header.php';

        require_once 'contrato/vista/contrato_edit.php';

        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Contrato();
                      
        $vte->idContrato = $_REQUEST['idContrato'];
        $vte->nombreContrato = $_REQUEST['nombreContrato'];
        $vte->idEmpresa = $_REQUEST['idEmpresa'];

      
        if ($vte->idContrato !="") {
            $this->model->ActualizarContrato($vte);
             header('Location: ?c=contrato&a=menuContrato&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerNombreContrato($vte->nombreContrato);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=contrato&a=Crud&repetido=1');
                    }
                else
                    {
                   
                        $this->model->Registrar($vte);
                        $this->model->RegistrarRemoteh2($vte);
                        $this->model->RegistrarRemoteh3($vte);
                        $this->model->RegistrarRemoteh4($vte);
              
                        echo "ingresado ok";
                        header('Location: ?c=contrato&a=menuContrato&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idContrato']);
        $this->model->EliminarRemoteh2($_REQUEST['idContrato']);
        $this->model->EliminarRemoteh3($_REQUEST['idContrato']);
        $this->model->EliminarRemoteh4($_REQUEST['idContrato']);
        header('Location: ?c=contrato&a=menuContrato&delete=1');
    }





}
?>