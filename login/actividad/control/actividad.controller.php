<?php
require_once 'actividad/modelo/actividad.php';


class actividadController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Actividad();
    }
    

        public function menuActividad(){
        require_once 'includes/header.php';
        require_once 'actividad/vista/actividad_list.php';
        require_once 'includes/footer.php';
    }
        public function menuActividades(){
        require_once 'includes/header.php';
        require_once 'actividad/vista/actividad_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Actividad();
        
        if(isset($_REQUEST['idActividad'])){
            $vte = $this->model->Obtener($_REQUEST['idActividad']);
        }
        
        require_once 'includes/header.php';
        require_once 'actividad/vista/actividad_edit.php';
        require_once 'includes/footer.php';
    }

    public function Crud1(){
        $vte = new Actividad();
        
        if(isset($_REQUEST['idActividad'])){
            $vte = $this->model->Obtener($_REQUEST['idActividad']);
        }
        require_once 'includes/header.php';
        require_once 'actividad/vista/actividad_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Actividad();
        
        if(isset($_REQUEST['idActividad'])){
            $vte = $this->model->Obtener($_REQUEST['idActividad']);
        }
        
        require_once 'includes/header.php';
        require_once 'actividad/vista/actividad_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Actividad();
        
        if(isset($_REQUEST['Actividad'])){
            $vte = $this->model->Obtener($_REQUEST['Actividad']);
        }
        
        require_once 'includes/header.php';

        require_once 'actividad/vista/actividad_editRepetido.php';

        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Actividad();
                      
        $vte->idActividad = $_REQUEST['idActividad'];
        $vte->descripcion = $_REQUEST['descripcion'];
        $vte->tipoA = $_REQUEST['tipoA'];
        $vte->idMaquina = $_REQUEST['idMaquina'];
        $vte->fechaA = $_REQUEST['fechaA'];
        $vte->horaA = $_REQUEST['horaA'];
        $vte->id_user = $_REQUEST['id_user'];
        $vte->statusA = $_REQUEST['statusA'];
        $vte->imagen = $_REQUEST['imagen'];
        $vte->imagen2 = $_REQUEST['imagen2'];
 
        $vte->idActividad > 0 
            ? $this->model->Actualizar($vte)

            : $this->model->Registrar($vte);
      
             header('Location: ?c=actividad&a=menuActividad&success=1');


        }

  public function Asignar(){
    $vte = new Actividad();

        $vte->idInscripcion = $_REQUEST['idInscripcion'];
        $vte->fechaAsignada = $_REQUEST['fechaAsignada'];
        $vte->horaAsignada = $_REQUEST['horaAsignada'];

        $vte->idInscripcion > 0 
            ? $this->model->AsignarFecha($vte)

            : $this->model->RegistrarFecha($vte);
      
             header('Location: ?c=inscripcion&a=menuInscripciones');
    }


      
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idActividad']);
        header('Location: ?c=actividad&a=menuActividad&delete=1');
    }

    public function Aprobar(){
    $vte = new Actividad();

        $vte->idActividad = $_REQUEST['idActividad'];
        
        $vte->idInscripcion > 0 
            ? $this->model->Aprobar($vte)

            : $this->model->RegistrarFecha($vte);
      
             header('Location: ?c=actividad&a=menuActividad');
    }

    public function ajax(){
    $vte = new Actividad();
        $vte->tipoA= $_REQUEST['tipoA'];
        $vte->idLinea = $_REQUEST['idLinea'];
        $vte->estado = $_REQUEST['estado'];
        $resultados = $this->model->ajax();

    }

    public function ajax1(){
    $vte = new Actividad();
        $vte->tipoA= $_REQUEST['tipoA'];
        $vte->idLinea = $_REQUEST['idLinea'];
        $vte->estado = $_REQUEST['estado'];
        require_once 'actividad/reportes/tipoA.php';
    } 

}
?>