<?php
require_once 'entrada/modelo/entrada.php';


class EntradaController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Entrada();
    }
    

        public function menuEntrada(){
        require_once 'includes/header.php'; 
        require_once 'entrada/vista/entrada_list.php';
        require_once 'includes/footer.php';
    }



        public function menuIngresoCasino(){
        require_once 'includes/header.php'; 
        require_once 'entrada/vista/entrada_casino_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Entrada();
        
        if(isset($_REQUEST['idEntrada'])){
            $vte = $this->model->Obtener($_REQUEST['idEntrada']);
        }
        
        require_once 'includes/header.php';
        require_once 'entrada/vista/entrada_edit.php';
        require_once 'includes/footer.php';
    }
        public function Crud1(){
        $vte = new Entrada();
        
        if(isset($_REQUEST['idEntrada'])){
            $vte = $this->model->Obtener($_REQUEST['identrada']);
        }
        
        require_once 'includes/header.php';
        require_once 'entrada/vista/entrada_editar.php';
        require_once 'includes/footer.php';
    }

    public function Guardar(){
        $vte = new Entrada();                      
        $vte->idEntrada = $_REQUEST['idEntrada'];
        $vte->idPersona = $_REQUEST['idPersona'];
        $vte->fechaEntrada = $_REQUEST['fechaEntrada'];
        $vte->horaEntrada = $_REQUEST['horaEntrada'];

 if ($vte->identrada!="" && $vte->idPersona != "") 
        {         
         $fecha=date("Y-m-d");

            $consultaQr = $this->model->ObtenerQr($vte->qrPersona);

            if ($consultaQr) { 

                $vte->idPersona = $consultaQr->idPersona;
                            
                $consultaEHospedaje=$this->model->ObtenerEstadoHospedaje($vte->idPersona);

            if ($consultaEHospedaje->estado=='A') {
                 $consulta=$this->model->Obtener($vte->idPersona,$vte->fechaentrada,$vte->tipoentrada);
                   
                     if ($consulta) 
                                {

                                    header('Location: ?c=entrada&a=Crud1&delete=1');
                                }


                            else{

                                $this->model->Registrar($vte);
                  
                                    header('Location: ?c=entrada&a=Crud1&success=1');
                                }                



                } elseif ($consultaEHospedaje->estado=='I') {
                    header('Location: ?c=entrada&a=Crud1&error=1');
                }







                           }


       } 

         else
            {      

                $consultaQr = $this->model->ObtenerQr($vte->qrPersona);
                $vte->idPersona = $consultaQr->idPersona;
                $this->model->Registrar($vte);      
                header('Location: ?c=entrada&a=Crud1&success=1');
            }

         }        
 
    




     
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idEntrada']);
        header('Location: ?c=entrada&a=menuEntrada&delete=1');
    }

}

?>