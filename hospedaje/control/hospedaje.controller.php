<?php
require_once 'hospedaje/modelo/hospedaje.php';


class hospedajeController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Hospedaje();
    }
    

        public function menuTotales(){
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_total.php';
        require_once 'includes/footer.php';
    }
        public function menuHospedaje(){
       

        $vte = new Hospedaje();
        date_default_timezone_set("America/Santiago");
        $vte->hasta = date("Y-m-d");
     
        $consultaEstado=$this->model->ObtenerEstado($vte->hasta);

/*
            foreach ($this->model->ListarEstados() as $consultaEstado ) {         
         
            
            $consultaH=$this->model->ObtenerHabitacion($consultaEstado->idHabitacion);
            $disponibles=$consultaH->capacidadHabitacion;
            $mas='1';
            $vte->capacidadHabitacion=$disponibles+$mas;
            $vte->idHabitacion=$consultaH->idHabitacion;
            $this->model->ActualizarHabitacion($vte);



            $consultaEstado->estado='I';
            $consultaEstado->estadoCama='A';
                           
            $this->model->ActualizarEstado($consultaEstado);
            $this->model->ActualizarCama($consultaEstado);


            
    

    }*/

       require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_list.php';
        require_once 'includes/footer.php';
       
    }

    
    public function ajuste(){
       

        $vte = new Hospedaje();
        date_default_timezone_set("America/Santiago");
        $vte->hasta = date("Y-m-d");
     
        $consultaEstado=$this->model->ObtenerEstado($vte->hasta);


            foreach ($this->model->ListarEstados() as $consultaEstado ) {         
         
            
            $consultaH=$this->model->ObtenerHabitacion($consultaEstado->idHabitacion);
            $disponibles=$consultaH->capacidadHabitacion;
            $mas='1';
            $vte->capacidadHabitacion=$disponibles+$mas;
            $vte->idHabitacion=$consultaH->idHabitacion;
            $this->model->ActualizarHabitacion($vte);



            $consultaEstado->estado='I';
            $consultaEstado->estadoCama='A';
                           
            $this->model->ActualizarEstado($consultaEstado);
            $this->model->ActualizarCama($consultaEstado);            
    

    }

echo "Ajuste realizado";
       
    }


 public function ajustepza(){
    
     $vte = new Hospedaje();
        date_default_timezone_set("America/Santiago");
        $vte->hasta = date("Y-m-d");
            foreach ($this->model->ListarEstados() as $consultaEstado ) {       
            
            $consultaH=$this->model->ObtenerHabitacion($consultaEstado->idHabitacion);
            $disponibles=$consultaH->capacidadHabitacion;
            $mas='1';
            $vte->capacidadHabitacion=$disponibles+$mas;
            $vte->idHabitacion=$consultaH->idHabitacion;
            $this->model->ActualizarHabitacion($vte);
            $consultaEstado->estado='I';
            $consultaEstado->estadoCama='A';                           
            $this->model->ActualizarEstado($consultaEstado);
            $this->model->ActualizarCama($consultaEstado);       
    

    }

    }



        public function menuHospedajeDiario(){
        $vte = new Hospedaje();

        $vte->hasta = date("Y-m-d");
     
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_Diario.php';
        require_once 'includes/footer.php';
       
    }

        public function menuResumenPago(){
        $vte = new Hospedaje();

        $vte->hasta = date("Y-m-d");
     
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_ResumenPago.php';
        require_once 'includes/footer.php';
       
    }


            public function menuDisponible(){


       require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_disponible.php';
        require_once 'includes/footer.php';
       
    }

        public function salidaHospedaje(){


       require_once 'includes/header.php';
        require_once 'hospedaje/vista/salida_lector.php';
        require_once 'includes/footer.php';
       
    }


    
    public function Crud(){
        $vte = new Hospedaje();
        
        if(isset($_REQUEST['idHospedaje'])){
            $vte = $this->model->Obtener($_REQUEST['idHospedaje']);
        }
        
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_edit.php';
        require_once 'includes/footer.php';
       
    }

        public function CrudRapido(){
        $vte = new Hospedaje();
        
        if(isset($_REQUEST['idHospedaje'])){
            $vte = $this->model->Obtener($_REQUEST['idHospedaje']);
        }
        
            foreach ($this->model->ObtenerEstadoError() as $consultaEstadoError) {

        $idCama=$consultaEstadoError->idCama;
        $consultaEstadoError->estadoCama='I';  

            $this->model->ActualizarCamaError($consultaEstadoError);
      
            }


        
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_editF.php';
        require_once 'includes/footer.php';
       
    }


        public function CrudRapidoNuevo(){
        $vte = new Hospedaje();
        
        if(isset($_REQUEST['idHospedaje'])){
            $vte = $this->model->Obtener($_REQUEST['idHospedaje']);
        }
        
            foreach ($this->model->ObtenerEstadoError() as $consultaEstadoError) {

        $idCama=$consultaEstadoError->idCama;
        $consultaEstadoError->estadoCama='I';  

            $this->model->ActualizarCamaError($consultaEstadoError);
      
            }

        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_editFNuevo.php';
        require_once 'includes/footer.php';
       
    }   

        public function CrudNombre(){
        $vte = new Hospedaje();
        
        if(isset($_REQUEST['idHospedaje'])){
            $vte = $this->model->Obtener($_REQUEST['idHospedaje']);
        }
        

        foreach ($this->model->ObtenerEstadoError() as $consultaEstadoError) {

        $idCama=$consultaEstadoError->idCama;
        $consultaEstadoError->estadoCama='I';  

            $this->model->ActualizarCamaError($consultaEstadoError);
      
            }
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_edit_nombre.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Hospedaje();
        
        if(isset($_REQUEST['idHospedaje'])){
            $vte = $this->model->Obtener($_REQUEST['idHospedaje']);
        }
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Hospedaje();
        
        if(isset($_REQUEST['idHospedaje'])){
            $vte = $this->model->Obtener($_REQUEST['idHospedaje']);
        }
        
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/hospedaje_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Hospedaje();
        
        if(isset($_REQUEST['idHospedaje'])){
            $vte = $this->model->Obtener($_REQUEST['idHospedaje']);
        }
        
        require_once 'includes/header.php';
        require_once 'hospedaje/vista/CrudRapidoNuevo.php';
        require_once 'includes/footer.php';
    }

    
    
    public function Guardar(){
        $vte = new Hospedaje();
                      
        $vte->idHospedaje = $_REQUEST['idHospedaje'];
        $vte->qrPersona = $_REQUEST['qrPersona'];
        $vte->idHotel = $_REQUEST['idHotel'];
        $vte->idHabitacion = $_REQUEST['idHabitacion'];
        $vte->idCama = $_REQUEST['idCama'];
        $vte->desde = $_REQUEST['desde'];
        $vte->hasta = $_REQUEST['hasta'];
        $vte->estado = $_REQUEST['estado'];
        $vte->estadoCama = 'I'; 
        $vte->FechaR = $_REQUEST['desde'];
        $vte->fechaDespedida = 'null';
        $vte->horaDespedida = 'null';
        $vte->tipoHabitacion = $_REQUEST['tipoHabitacion'];
        $vte->Act = '1';    
   
        if ($vte->idHospedaje > 0) {
            $this->model->Actualizar($vte);
             header('Location: ?c=hospedaje&a=menuHospedaje&update=1');
        }
        else{
            $consultaRepetido=$this->model->ObtenerPersona($vte->qrPersona,$vte->estado);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=hospedaje&a=CrudRapidoNuevo&repetido=1');
                    }
                else
                    {       

                          $consultaIngreso=$this->model->ObtenerPersonaqr($vte->qrPersona);

                          echo $consultaIngreso->idPersona;
                            
                          $vte->idPersona = $consultaIngreso->idPersona;                   
                       /*Actualiza cama*/
                       $this->model->ActualizarCama($vte);
                       /*Fin actualiza cama*/

                       /*Actualizar Habitación*/
                       $consultaH=$this->model->ObtenerHabitacion($vte->idHabitacion);
                       $disponibles=$consultaH->capacidadHabitacion;
                       $menos='1';
                       $capacidadReal=$consultaH->capacidadReal;
                       $cero=0;

                       if ($disponibles<$cero) 
                            {
                                $this->model->ActualizarHabitacionCero($vte);
                                $this->model->ActualizarCama($vte);
                            }

                        if ($disponibles>$capacidadReal) 
                            {
                                $capacidadReal=$consultaH->capacidadReal;
                                $this->model->ActualizarHabitacionCapacidadReal($capacidadReal);
                                $this->model->ActualizarCama($vte);
                            }

                        else 
                        {
                            $habitacion=$vte->idHabitacion;
                            $vte->capacidadHabitacion=$disponibles-$menos;
                            $this->model->ActualizarHabitacion($vte);
                            $this->model->ActualizarCama($vte);
                        }
                        /*Fin Actualiza Habitación*/                        
                        
                        $this->model->Registrar($vte);
                                             
                       
                        echo "ingresado ok";
                        header('Location: ?c=hospedaje&a=CrudRapidoNuevo&success=1');                      

                    }
                }
        
        }

   public function GuardarQr(){
        $vte = new Hospedaje();
                      
        $vte->idHospedaje = $_REQUEST['idHospedaje'];
        $vte->qrPersona = $_REQUEST['qrPersona'];
        $vte->idHotel = $_REQUEST['idHotel'];
        $vte->idHabitacion = $_REQUEST['idHabitacion'];
        $vte->idCama = $_REQUEST['idCama'];
        $vte->desde = $_REQUEST['desde'];
        $vte->hasta = $_REQUEST['hasta'];
        $vte->estado = $_REQUEST['estado'];
        $vte->estadoCama = 'I'; 
        $vte->FechaR = $_REQUEST['desde'];
        $vte->fechaDespedida = 'null';
        $vte->horaDespedida = 'null';
        $vte->tipoHabitacion = $_REQUEST['tipoHabitacion'];
        $vte->Act = '1';    
   
        if ($vte->idHospedaje > 0) {
            $this->model->Actualizar($vte);
             header('Location: ?c=hospedaje&a=menuHospedaje&update=1');
        }
        else{
            $consultaRepetido=$this->model->ObtenerPersona($vte->qrPersona,$vte->estado);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=hospedaje&a=CrudRapidoNuevo&repetido=1');
                    }
                else
                    {       

                          $consultaIngreso=$this->model->ObtenerPersonaqr($vte->qrPersona);

                          echo $consultaIngreso->idPersona;
                            
                          $vte->idPersona = $consultaIngreso->idPersona;                   
                       /*Actualiza cama*/
                       $this->model->ActualizarCama($vte);
                       /*Fin actualiza cama*/

                       /*Actualizar Habitación*/
                       $consultaH=$this->model->ObtenerHabitacion($vte->idHabitacion);
                       $disponibles=$consultaH->capacidadHabitacion;
                       $menos='1';
                       $capacidadReal=$consultaH->capacidadReal;
                       $cero=0;

                       if ($disponibles<$cero) 
                            {
                                $this->model->ActualizarHabitacionCero($vte);
                                $this->model->ActualizarCama($vte);
                            }

                        if ($disponibles>$capacidadReal) 
                            {
                                $capacidadReal=$consultaH->capacidadReal;
                                $this->model->ActualizarHabitacionCapacidadReal($capacidadReal);
                                $this->model->ActualizarCama($vte);
                            }

                        else 
                        {
                            $habitacion=$vte->idHabitacion;
                            $vte->capacidadHabitacion=$disponibles-$menos;
                            $this->model->ActualizarHabitacion($vte);
                            $this->model->ActualizarCama($vte);
                        }
                        /*Fin Actualiza Habitación*/                        
                        
                        $this->model->Registrar($vte);
                                             
                       
                        echo "ingresado ok";
                        header('Location: ?c=hospedaje&a=CrudRapidoNuevo&success=1');                      

                    }
                }
        
        }      

    public function GuardarNombreNuevo(){
        $vte = new Hospedaje();
                      
        $vte->idHospedaje = $_REQUEST['idHospedaje'];
        $vte->idPersona = $_REQUEST['idPersona'];
        $vte->idHotel = $_REQUEST['idHotel'];
        $vte->idHabitacion = $_REQUEST['idHabitacion'];
        $vte->idCama = $_REQUEST['idCama'];
        $vte->desde = $_REQUEST['desde'];
        $vte->hasta = $_REQUEST['hasta'];
        $vte->estado = $_REQUEST['estado'];
        $vte->estadoCama = 'I'; 
        $vte->FechaR = $_REQUEST['desde'];
        $vte->fechaDespedida = 'null';
        $vte->horaDespedida = 'null';
        $vte->tipoHabitacion = $_REQUEST['tipoHabitacion'];
        $vte->Act = '1';     
        if ($vte->idHospedaje > 0) {
            $this->model->Actualizar($vte);
             header('Location: ?c=hospedaje&a=menuHospedaje&update=1');
        }
        else{
            $consultaRepetido=$this->model->ObtenerPersonaRegistro($vte->idPersona,$vte->estado);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=hospedaje&a=CrudRapido&repetido=1');
                    }
                else
                    {
                       /*Actualiza cama*/
                   

                       $this->model->ActualizarCama($vte);
                       /*Fin actualiza cama*/

                       /*Actualizar Habitación*/
                       $consultaH=$this->model->ObtenerHabitacion($vte->idHabitacion);
                       $disponibles=$consultaH->capacidadHabitacion;
                       $menos='1';
                       $capacidadReal=$consultaH->capacidadReal;
                       $cero=0;

                       if ($disponibles<$cero) 
                            {
                                $this->model->ActualizarHabitacionCero($vte);
                                $this->model->ActualizarCama($vte);
                            }

                        if ($disponibles>$capacidadReal) 
                            {
                                $capacidadReal=$consultaH->capacidadReal;
                                $this->model->ActualizarHabitacionCapacidadReal($capacidadReal);
                                $this->model->ActualizarCama($vte);
                            }

                        else 
                        {
                            $habitacion=$vte->idHabitacion;
                            $vte->capacidadHabitacion=$disponibles-$menos;
                            $this->model->ActualizarHabitacion($vte);
                            $this->model->ActualizarCama($vte);
                        }
                        /*Fin Actualiza Habitación*/                        
                        
                        $this->model->Registrar($vte);
                                             
                       
                        echo "ingresado ok";
                        header('Location: ?c=hospedaje&a=CrudRapido&success=1');
                         }
                    }
    

        }  


public function GuardarNombre(){
        $vte = new Hospedaje();
                      
        $vte->idHospedaje = $_REQUEST['idHospedaje'];
        $vte->idPersona = $_REQUEST['idPersona'];
        $vte->idHotel = $_REQUEST['idHotel'];
        $vte->idHabitacion = $_REQUEST['idHabitacion'];
        $vte->idCama = $_REQUEST['idCama'];
        $vte->desde = $_REQUEST['desde'];
        $vte->hasta = $_REQUEST['hasta'];
        $vte->estado = $_REQUEST['estado'];
        $vte->estadoCama = 'I'; 
        $vte->FechaR = $_REQUEST['desde'];
        $vte->fechaDespedida = 'null';
        $vte->horaDespedida = 'null';
        $vte->tipoHabitacion = $_REQUEST['tipoHabitacion'];
        $vte->Act = '1';     
        if ($vte->idHospedaje > 0) {
            $this->model->Actualizar($vte);
             header('Location: ?c=hospedaje&a=menuHospedaje&update=1');
        }
        else{
            $consultaRepetido=$this->model->ObtenerPersonaRegistro($vte->idPersona,$vte->estado);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=hospedaje&a=CrudRapido&repetido=1');
                    }
                else
                    {
                       $consultaH=$this->model->ObtenerHabitacion($vte->idHabitacion);
                       $disponibles=$consultaH->capacidadHabitacion;
                       $menos='1';
                       $vte->capacidadHabitacion=$disponibles-$menos;

                       $habitacion=$vte->idHabitacion;

                        $this->model->ActualizarHabitacion($vte);

                        $this->model->ActualizarCama($vte);
                        
                        $this->model->Registrar($vte);
                        /*actualiza estado habitacion*/                       
                       
                        echo "ingresado ok";
                        header('Location: ?c=hospedaje&a=CrudRapido&success=1');
                         }
                    }    

        }                      
       

public function GuardarNombreF(){
        $vte = new Hospedaje();
                      
        $vte->idHospedaje = $_REQUEST['idHospedaje'];
        $vte->idPersona = $_REQUEST['idPersona'];
        $vte->idHotel = $_REQUEST['idHotel'];
        $vte->idHabitacion = $_REQUEST['idHabitacion'];
        $vte->idCama = $_REQUEST['idCama'];
        $vte->desde = $_REQUEST['desde'];
        $vte->hasta = $_REQUEST['hasta'];
        $vte->estado = $_REQUEST['estado'];
        $vte->estadoCama = 'I'; 
        $vte->FechaR = $_REQUEST['desde'];
        $vte->fechaDespedida = 'null';
        $vte->horaDespedida = 'null';
        $vte->tipoHabitacion = $_REQUEST['tipoHabitacion'];
        $vte->Act = '1';     
        if ($vte->idHospedaje > 0) {
            $this->model->Actualizar($vte);
             header('Location: ?c=hospedaje&a=menuHospedaje&update=1');
        }
        else{
            $consultaRepetido=$this->model->ObtenerPersonaRegistro($vte->idPersona,$vte->estado);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=hospedaje&a=CrudRapido&repetido=1');
                    }
                else
                    {
                       $consultaH=$this->model->ObtenerHabitacion($vte->idHabitacion);
                       $disponibles=$consultaH->capacidadHabitacion;
                       $menos='1';
                       $vte->capacidadHabitacion=$disponibles-$menos;

                       $habitacion=$vte->idHabitacion;

                        $this->model->ActualizarHabitacion($vte);

                        $this->model->ActualizarCama($vte);
                        
                        $this->model->Registrar($vte);
                        /*actualiza estado habitacion*/                       
                       
                        echo "ingresado ok";
                        header('Location: ?c=hospedaje&a=CrudRapido&success=1');
                         }
                    }    

        } 




    public function Eliminar(){
   $vte = new Hospedaje();
   $vte->idHospedaje = $_REQUEST['idHospedaje'];
   if ($vte->idHospedaje > 0) 
        {
       date_default_timezone_set("America/Santiago");

           $consultaIdHospedaje=$this->model->Obtener($vte->idHospedaje);

            $consultaH=$this->model->ObtenerHabitacion($consultaIdHospedaje->idHabitacion);
            $disponibles=$consultaH->capacidadHabitacion;
            $menos='1';
            $vte->capacidadHabitacion=$disponibles+$menos;
            $vte->idHabitacion=$consultaH->idHabitacion;
            $this->model->ActualizarHabitacion($vte);
        
            $consultaIdHospedaje->estado='I';
            $consultaIdHospedaje->estadoCama='A';
            $consultaIdHospedaje->fechaDespedida=date("Y-m-d");
            $consultaIdHospedaje->horaDespedida=date('H:i:s');

                   
            $this->model->ActualizarEstado($consultaIdHospedaje);
            $this->model->ActualizarCama($consultaIdHospedaje);
            $this->model->EliminarResumenDiario($consultaIdHospedaje);


           //$this->model->Eliminar($_REQUEST['idHospedaje']);
                header('Location: ?c=hospedaje&a=menuHospedaje&delete=1');


        }
    
    }




}
?>