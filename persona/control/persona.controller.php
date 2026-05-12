<?php
require_once 'persona/modelo/persona.php';


class personaController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Persona();
    }
    

        public function menuTotales(){
        require_once 'includes/header.php';
        require_once 'persona/vista/persona_total.php';
        require_once 'includes/footer.php';
    }
        public function menuPersona(){
        require_once 'includes/header_Persona.php';
        require_once 'persona/vista/persona_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Persona();
        
        if(isset($_REQUEST['idPersona'])){
            $vte = $this->model->Obtener($_REQUEST['idPersona']);
        }
        
        require_once 'includes/header_Npersona.php';
        require_once 'persona/vista/persona_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Persona();
        
        if(isset($_REQUEST['idPersona'])){
            $vte = $this->model->Obtener($_REQUEST['idPersona']);
        }
        require_once 'includes/header.php';
        require_once 'persona/vista/persona_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Persona();
        
        if(isset($_REQUEST['idPersona'])){
            $vte = $this->model->Obtener($_REQUEST['idPersona']);
        }
        
        require_once 'includes/header.php';
        require_once 'persona/vista/persona_ver.php';
        require_once 'includes/footer.php';
    }




    public function CrudRepetido(){
        $vte = new Persona();
        
        if(isset($_REQUEST['Persona'])){
            $vte = $this->model->Obtener($_REQUEST['Persona']);
        }
        
        require_once 'includes/header.php';

        require_once 'persona/vista/persona_editRepetido.php';

        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Persona();
        $ceros1="00";
        $ceros2="000";
        $vte->idPersona = $_REQUEST['idPersona'];
        $vte->rutPersona = $_REQUEST['rutPersona'];
        $vte->nombresPersona = $_REQUEST['nombresPersona'];
        $vte->apellidoPersona1 = $_REQUEST['apellidoPersona1'];
        $vte->apellidoPersona2 = $_REQUEST['apellidoPersona2'];
        $vte->genero = $_REQUEST['genero'];
        $vte->fechaCreado = $_REQUEST['fechaCreado'];
        $vte->horaCreado = $_REQUEST['horaCreado'];
        $vte->fotoPersona = $_REQUEST['imagen'];
        $vte->qrPersona = $_REQUEST['qrPersona'];
        $vte->idEmpresa = $_REQUEST['idEmpresa']; 
        $vte->idContrato = $_REQUEST['idContrato'];       

        $q = $vte->rutPersona;
        $mystring = $q;
        $codigo=mb_strlen($mystring);
        if ($codigo <=9) 
        {
            $vte->card =$ceros2."".$_REQUEST['card'];
                
        }
        else
        {
            $vte->card =$ceros1."".$_REQUEST['card'];
            
        }


        if ($vte->idPersona !="") {
            $this->model->ActualizarP($vte);
             header('Location: ?c=persona&a=menuPersona&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerRut($vte->rutPersona);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=persona&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                       /* $consultaRut = $this->model->ObtenerRut($vte->rutPersona);

                        if ($consultaRut) {                           
                       
                        require_once'library/phpqrcode/qrlib.php';
                        $id = $consultaRut->idPersona;
                        QRcode::png($id,"persona/codigosQR/qr_".$id.".png",'L',10,5);
                        $consultaRut->qrPersona = $id;
                        $this->model->ActualizarQr($consultaRut);*/
                        echo "ingresado ok";
                        header('Location: ?c=persona&a=Crud&success=1');
                        
                    }

            }
        

        }


    public function GuardarQR(){
        $vte = new Persona();
                      
        $vte->idPersona = $_REQUEST['idPersona'];
  
        $vte->qrPersona = $_REQUEST['qrPersona'];
       
      
        if ($vte->idPersona !="") {
            $this->model->ActualizarQr($vte);
             header('Location: ?c=persona&a=menuPersona&update=1');
        }
       
    

        }


         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idPersona']);
        header('Location: ?c=persona&a=menuPersona&delete=1');
    }





}
?>