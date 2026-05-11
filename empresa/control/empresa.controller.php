<?php

require_once 'empresa/modelo/empresa.php';


class empresaController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Empresa();
    }
    

        public function menuTotales(){
        require_once 'includes/header.php';
        require_once 'empresa/vista/empresa_total.php';
        require_once 'includes/footer.php';
    }
        public function menuEmpresa(){
        require_once 'includes/header.php';
        require_once 'empresa/vista/empresa_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Empresa();
        
        if(isset($_REQUEST['idEmpresa'])){
            $vte = $this->model->Obtener($_REQUEST['idEmpresa']);
        }
        
        require_once 'includes/header.php';
        require_once 'empresa/vista/empresa_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Empresa();
        
        if(isset($_REQUEST['idEmpresa'])){
            $vte = $this->model->Obtener($_REQUEST['idEmpresa']);
        }
        require_once 'includes/header.php';
        require_once 'empresa/vista/empresa_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Empresa();
        
        if(isset($_REQUEST['idEmpresa'])){
            $vte = $this->model->Obtener($_REQUEST['idEmpresa']);
        }
        
        require_once 'includes/header.php';
        require_once 'empresa/vista/empresa_ver.php';
        require_once 'includes/footer.php';
    }




    public function CrudRepetido(){
        $vte = new Empresa();
        
        if(isset($_REQUEST['idEmpresa'])){
            $vte = $this->model->Obtener($_REQUEST['idEmpresa']);
        }
        
        require_once 'includes/header.php';

        require_once 'empresa/vista/empresa_editRepetido.php';

        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Empresa();
                      
        $vte->idEmpresa = $_REQUEST['idEmpresa'];
        $vte->rutEmpresa = $_REQUEST['rutEmpresa'];
        $vte->nombreEmpresa = $_REQUEST['nombreEmpresa'];
        $vte->ContratoEmpresa = $_REQUEST['ContratoEmpresa'];
        $vte->contratoEmpresa1 = $_REQUEST['contratoEmpresa1'];
        $vte->horaSalida = $_REQUEST['horaSalida'];
      
        if ($vte->idEmpresa !="") {
            $this->model->ActualizarEmpresa($vte);
             header('Location: ?c=empresa&a=menuEmpresa&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerRutEmpresa($vte->rutEmpresa);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=empresa&a=Crud&repetido=1');
                    }
                else
                    {
                   
                        $this->model->Registrar($vte);
                        $this->model->RegistrarRemoteh2($vte);
                        $this->model->RegistrarRemoteh3($vte);
                        $this->model->RegistrarRemoteh4($vte);
              
                        echo "ingresado ok";
                        header('Location: ?c=empresa&a=menuEmpresa&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idEmpresa']);
        $this->model->EliminarRemoteh2($_REQUEST['idEmpresa']);
        $this->model->EliminarRemoteh3($_REQUEST['idEmpresa']);
        $this->model->EliminarRemoteh4($_REQUEST['idEmpresa']);
        header('Location: ?c=empresa&a=menuEmpresa&delete=1');
    }





}
?>