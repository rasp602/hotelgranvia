<?php
require_once 'hotel/modelo/hotel.php';


class HotelController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new hotel();
    }
    

        public function menuTotales(){
        require_once 'includes/header.php';
        require_once 'hotel/vista/hotel_total.php';
        require_once 'includes/footer.php';
    }
        public function menuHotel(){
        require_once 'includes/header.php';
        require_once 'hotel/vista/hotel_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Hotel();
        
        if(isset($_REQUEST['idHotel'])){
            $vte = $this->model->Obtener($_REQUEST['idHotel']);
        }
        
        require_once 'includes/header.php';
        require_once 'hotel/vista/hotel_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Hotel();
        
        if(isset($_REQUEST['idHotel'])){
            $vte = $this->model->Obtener($_REQUEST['idHotel']);
        }
        require_once 'includes/header.php';
        require_once 'hotel/vista/hotel_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Hotel();
        
        if(isset($_REQUEST['idHotel'])){
            $vte = $this->model->Obtener($_REQUEST['idHotel']);
        }
        
        require_once 'includes/header.php';
        require_once 'hotel/vista/hotel_ver.php';
        require_once 'includes/footer.php';
    }




    public function CrudRepetido(){
        $vte = new Hotel();
        
        if(isset($_REQUEST['idhotel'])){
            $vte = $this->model->Obtener($_REQUEST['idhotel']);
        }
        
        require_once 'includes/header.php';

        require_once 'hotel/vista/hotel_editRepetido.php';

        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Hotel();
                      
        $vte->idHotel = $_REQUEST['idHotel'];
        $vte->rutHotel = $_REQUEST['rutHotel'];
        $vte->nombreHotel = $_REQUEST['nombreHotel'];
        $vte->capacidadHotel = $_REQUEST['capacidadHotel'];
        $vte->direccion = $_REQUEST['direccion'];
      
        if ($vte->idHotel !="") {
            $this->model->ActualizarHotel($vte);
             header('Location: ?c=hotel&a=menuHotel&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerRutHotel($vte->rutHotel);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=hotel&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=hotel&a=menuHotel&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idHotel']);
        header('Location: ?c=hotel&a=menuHotel&delete=1');
    }





}
?>