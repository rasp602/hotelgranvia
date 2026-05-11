<?php
require_once 'comida/modelo/comida.php';


class comidaController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Comida();
    }
    

        public function menuComida(){
        require_once 'includes/header.php'; 
        require_once 'comida/vista/comida_list.php';
        require_once 'includes/footer.php';
    }
    

        public function menuComidaEmpresa(){
        require_once 'includes/header.php'; 
        require_once 'comida/vista/comida_list_empresa.php';
        require_once 'includes/footer.php';
    }

    public function indicadores(){
        require_once 'includes/header.php'; 
        require_once 'comida/vista/indicadores.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Comida();
        
        if(isset($_REQUEST['idComida'])){
            $vte = $this->model->Obtener($_REQUEST['idComida']);
        }
        
        require_once 'includes/header.php';
        require_once 'comida/vista/comida_edit.php';
        require_once 'includes/footer.php';
    }
        public function Crud1(){
        $vte = new Comida();
        
        if(isset($_REQUEST['idComida'])){
            $vte = $this->model->Obtener($_REQUEST['idComida']);
        }
        
        require_once 'includes/header.php';
        require_once 'comida/vista/comida_editar.php';
        require_once 'includes/footer.php';
    }

    public function Guardar(){
        $vte = new Comida();                      
        $vte->idComida = $_REQUEST['idComida'];
        $vte->tipoComida = $_REQUEST['tipoComida'];
        $vte->horaComida = $_REQUEST['horaComida'];
        $vte->qrPersona = $_REQUEST['qrPersona'];
        $vte->fechaComida = $_REQUEST['fechaComida'];
        $vte->idPersona = $_REQUEST['idPersona'];
        
 if ($vte->idComida=="" && $vte->idPersona != "") 
        {         
         $fecha=date("Y-m-d");

            $consultaQr = $this->model->ObtenerQr($vte->qrPersona);

            if ($consultaQr) { 

                $vte->idPersona = $consultaQr->idPersona;
                            
                $consultaEHospedaje=$this->model->ObtenerEstadoHospedaje($vte->idPersona);

            if ($consultaEHospedaje->estado=='A') {
                 $consulta=$this->model->Obtener($vte->idPersona,$vte->fechaComida,$vte->tipoComida);
                   
                     if ($consulta) 
                                {

                                    header('Location: ?c=comida&a=Crud1&delete=1');
                                }


                            else{

                                $this->model->Registrar($vte);
                  
                                    header('Location: ?c=comida&a=Crud1&success=1');
                                }                



                } elseif ($consultaEHospedaje->estado=='I') {
                    header('Location: ?c=comida&a=Crud1&error=1');
                }







                           }


       } 

         else
            {      

                $consultaQr = $this->model->ObtenerQr($vte->qrPersona);
                $vte->idPersona = $consultaQr->idPersona;
                $this->model->Registrar($vte);      
                header('Location: ?c=comida&a=Crud1&success=1');
            }

         }        
 
    


    public function Actualizar(){
        $vte = new Chip();
                $vte->idCamara = $_REQUEST['idCamara'];
                $vte->idMaquina = $_REQUEST['idMaquina'];
                $vte->nCamara = $_REQUEST['nCamara'];

                   $this->model->Actualizar($vte);
              
                     header('Location: ?c=camara&a=menuComida&update=1');  
     }


     
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idComida']);
        header('Location: ?c=comida&a=menuComida&delete=1');
    }

}

?>