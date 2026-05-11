<?php
require_once 'trabajador/modelo/trabajador.php';


class TrabajadorController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Trabajador();
    }
    

        public function menuTotales(){
        require_once 'includes/header.php';
        require_once 'trabajador/vista/trabajador_total.php';
        require_once 'includes/footer.php';
    }
        public function menuTrabajador(){
        require_once 'includes/header.php';
        require_once 'trabajador/vista/trabajador_list.php';
        require_once 'includes/footer.php';
    }

        public function Descanso(){
        require_once 'includes/header.php';
        require_once 'trabajador/vista/trabajador_descanso.php';
        require_once 'includes/footer.php';
    }


    
    public function Crud(){
        $vte = new Trabajador();
        
        if(isset($_REQUEST['idTrabajador'])){
            $vte = $this->model->Obtener($_REQUEST['idTrabajador']);
        }
        
        require_once 'includes/header.php';
        require_once 'trabajador/vista/trabajador_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Trabajador();
        
        if(isset($_REQUEST['idTrabajador'])){
            $vte = $this->model->Obtener($_REQUEST['idTrabajador']);
        }
        require_once 'includes/header.php';
        require_once 'trabajador/vista/trabajador_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Trabajador();
        
        if(isset($_REQUEST['idTrabajador'])){
            $vte = $this->model->Obtener($_REQUEST['idTrabajador']);
        }
        
        require_once 'includes/header.php';
        require_once 'trabajador/vista/trabajador_ver.php';
        require_once 'includes/footer.php';
    }

        public function condicion(){
        $vte = new Trabajador();
        
        if(isset($_REQUEST['idTrabajador'])){
            $vte = $this->model->Obtener($_REQUEST['idTrabajador']);
        }
        
        require_once 'includes/header.php';
        require_once 'trabajador/vista/trabajador_condicion.php';
        require_once 'includes/footer.php';
    }

    public function CambiarCondicion(){
        $vte = new Trabajador();
                      
        $vte->idTrabajador = $_REQUEST['idTrabajador'];
        $vte->condicion = $_REQUEST['condicion'];
  
        if ($vte->idTrabajador !="") {
            $this->model->ValidarCondicion($vte);
             header('Location: ?c=ingreso&a=menuIngreso&update=1');
        }
 }

    public function CrudRepetido(){
        $vte = new Trabajador();
        
        if(isset($_REQUEST['idTrabajador'])){
            $vte = $this->model->Obtener($_REQUEST['idTrabajador']);
        }
        
        require_once 'includes/header.php';

        require_once 'trabajador/vista/trabajador_editRepetido.php';

        require_once 'includes/footer.php';
    }

    
        public function DescansoGuardar(){
        $vte = new Trabajador();
                      
        $vte->idTrabajador = $_REQUEST['idTrabajador'];
        $vte->evento = $_REQUEST['evento'];
        $f_inicio = $_REQUEST['fecha_inicio'];        
        $vte->fecha_inicio=date('Y-m-d', strtotime($f_inicio)); 


        $f_fin = $_REQUEST['fecha_fin']; 
        $vte->fecha_fin  = date('Y-m-d', strtotime($f_fin)-1);
        $vte->color_evento = "";
        $vte->tipo_evento = $_REQUEST['tipo_evento'];

        if ( $vte->tipo_evento == 'Descanso')
        {
            $vte->color_evento = '#FF6969' ; 
        }

        if ( $vte->tipo_evento == 'Licencia')         
        {
            $vte->color_evento = '#0000FF' ; 
        }

        if ( $vte->tipo_evento == 'Vacaciones')
        {
            $vte->color_evento = '#00a2ff' ; 
        }
         
        
        if ($vte->idTrabajador !="") {

             $consultaNombre = $this->model->ObtenerNombre($vte->idTrabajador);
             $vte->evento=$consultaNombre->nombreTrabajador.' '.$consultaNombre->apellidoTrabajador1;
             $this->model->RegistrarDescanso($vte);

             $idTrabajador=$vte->idTrabajador;
             header('Location: ?c=trabajador&a=Descanso&idTrabajador='.$idTrabajador);
        }
 }
    
    public function Guardar(){
        $vte = new Trabajador();
                      
        $vte->idTrabajador = $_REQUEST['idTrabajador'];
        $vte->rutTrabajador = $_REQUEST['rutTrabajador'];
        $vte->nombreTrabajador = $_REQUEST['nombreTrabajador'];
        $vte->apellidoTrabajador1 = $_REQUEST['apellidoTrabajador1'];
        $vte->apellidoTrabajador2 = $_REQUEST['apellidoTrabajador2'];
        $vte->genero = $_REQUEST['genero'];
        $vte->fechaCreado = $_REQUEST['fechaCreado'];
        $vte->horaCreado = $_REQUEST['horaCreado'];
        $vte->fotoTrabajador = $_REQUEST['imagen'];
        $vte->qrTrabajador = $_REQUEST['qrTrabajador'];
        $vte->idHotel = $_REQUEST['idHotel'];
        $vte->estado = $_REQUEST['estado'];
        $vte->fechaIngreso = $_REQUEST['fechaIngreso'];
        $vte->labor = $_REQUEST['labor'];
        $vte->jornada = $_REQUEST['jornada']; 
        $vte->diasTrabajo = $_REQUEST['diasTrabajo'];  
        $vte->sueldo = $_REQUEST['sueldo'];
        $vte->condicion = $_REQUEST['condicion'];   

        if ($vte->idTrabajador !="") {
            $this->model->ActualizarT($vte);
             header('Location: ?c=trabajador&a=menuTrabajador&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerRut($vte->rutTrabajador);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=trabajador&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->RegistrarTrabajador($vte);
                        $consultaRut = $this->model->ObtenerRut($vte->rutTrabajador);

                        if ($consultaRut) {                           
                       
                        require_once'library/phpqrcode/qrlib.php';
                        $id = $consultaRut->idTrabajador;
                        $año = '2024';


                        // Obtener el año, mes, día, hora, minutos y segundos actuales
                        $ano = date("Y");
                        $mes = date("m");
                        $dia = date("d");
                        $hora = date("H");
                        $minutos = date("i");
                        $segundos = date("s");

                        // Variable que concatena la fecha y hora sin separación
                        $fechaHoraSinSeparacion = $ano . $mes . $dia . $hora . $minutos . $segundos;

                        // Imprimir la variable             


                    
                        QRcode::png($fechaHoraSinSeparacion,"trabajador/codigosQR/qr_".$fechaHoraSinSeparacion.".png",'L',10,5);
                        $consultaRut->qrTrabajador = $fechaHoraSinSeparacion;
                        $this->model->ActualizarQr($consultaRut);
                        echo "ingresado ok";
                        header('Location: ?c=trabajador&a=menuTrabajador&success=1');
                         }
                    }

            }
        

        }


    public function GuardarQR(){
        $vte = new Persona();
                      
        $vte->idTrabajador = $_REQUEST['idTrabajador'];
  
        $vte->qrTrabajador = $_REQUEST['qrTrabajador'];
       
      
        if ($vte->idTrabajador !="") {
            $this->model->ActualizarQr($vte);
             header('Location: ?c=trabajador&a=menuTrabajador&update=1');
        }
       
    

        }
         
    public function Eliminar(){
        $this->model->EliminarEntradas($_REQUEST['idTrabajador']);
        $this->model->Eliminar($_REQUEST['idTrabajador']);
        header('Location: ?c=trabajador&a=menuTrabajador&delete=1');
    }


/************************ */
    public function Documentos()
{
    $vte = new Trabajador();
    $documentos = null;

    if (isset($_REQUEST['idTrabajador'])) {
        $vte = $this->model->Obtener($_REQUEST['idTrabajador']);
        $documentos = $this->model->ObtenerDocumentos($_REQUEST['idTrabajador']);
    }

    require_once 'includes/header.php';
    require_once 'trabajador/vista/trabajador_documentos.php';
    require_once 'includes/footer.php';
}

private function subirDocumento($campo, $idTrabajador)
{
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] != 0) {
        return null;
    }

    $permitidos = array('pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx');
    $nombreOriginal = $_FILES[$campo]['name'];
    $tmp = $_FILES[$campo]['tmp_name'];
    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

    if (!in_array($extension, $permitidos)) {
        die("Formato no permitido para el archivo: " . $nombreOriginal);
    }

    if ($_FILES[$campo]['size'] > 10485760) {
        die("El archivo supera los 10MB: " . $nombreOriginal);
    }

    $carpeta = "trabajador/documentos/";

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $nombreArchivo = $idTrabajador . "_" . $campo . "_" . date("YmdHis") . "." . $extension;
    $rutaFinal = $carpeta . $nombreArchivo;

    if (move_uploaded_file($tmp, $rutaFinal)) {
        return $rutaFinal;
    }

    return null;
}

public function GuardarDocumentos()
{
    $vte = new Trabajador();

    $idTrabajador = $_REQUEST['idTrabajador'];
    $documentosActuales = $this->model->ObtenerDocumentos($idTrabajador);

    $vte->idTrabajador = $idTrabajador;

    $vte->fichaPersonal = $this->subirDocumento("fichaPersonal", $idTrabajador);
    $vte->curriculum = $this->subirDocumento("curriculum", $idTrabajador);
    $vte->carnet = $this->subirDocumento("carnet", $idTrabajador);
    $vte->certificadoAfp = $this->subirDocumento("certificadoAfp", $idTrabajador);
    $vte->fonasa = $this->subirDocumento("fonasa", $idTrabajador);
    $vte->ultimoFiniquito = $this->subirDocumento("ultimoFiniquito", $idTrabajador);

    if ($documentosActuales) {
        if ($vte->fichaPersonal == null) $vte->fichaPersonal = $documentosActuales->fichaPersonal;
        if ($vte->curriculum == null) $vte->curriculum = $documentosActuales->curriculum;
        if ($vte->carnet == null) $vte->carnet = $documentosActuales->carnet;
        if ($vte->certificadoAfp == null) $vte->certificadoAfp = $documentosActuales->certificadoAfp;
        if ($vte->fonasa == null) $vte->fonasa = $documentosActuales->fonasa;
        if ($vte->ultimoFiniquito == null) $vte->ultimoFiniquito = $documentosActuales->ultimoFiniquito;
    }

    $this->model->GuardarDocumentos($vte);

    header("Location: ?c=trabajador&a=Documentos&idTrabajador=".$idTrabajador."&success=1");
}



}
?>