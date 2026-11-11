<?php
require_once 'usuarios/modelo/usuarios.php';

class UsuariosController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Alumno();
    }

    public function menuVisit()
    {
        require_once 'includes/vista/header.php';
        require_once 'usuarios/vista/visit_list.php';
        require_once 'includes/vista/footer.php';
    }

    public function menuUsuario()
    {
        require_once 'includes/header.php';
        require_once 'usuarios/vista/User_list.php';
        require_once 'includes/footer.php';
    }

    public function Crud()
    {
        $alm = new Alumno();

        if (isset($_REQUEST['idUsuario']) && !empty($_REQUEST['idUsuario'])) {
            $alm = $this->model->Obtener((int)$_REQUEST['idUsuario']);
        }

        require_once 'includes/header.php';
        require_once 'usuarios/vista/User_edit.php';
        require_once 'includes/footer.php';
    }

    public function Guardar()
    {
        $alm = new Alumno();

        $alm->idUsuario = isset($_REQUEST['idUsuario']) ? (int)$_REQUEST['idUsuario'] : 0;
        $alm->Rut       = isset($_REQUEST['Rut']) ? trim($_REQUEST['Rut']) : '';
        $alm->Nombre    = isset($_REQUEST['Nombre']) ? trim($_REQUEST['Nombre']) : '';
        $alm->Apellido  = isset($_REQUEST['Apellido']) ? trim($_REQUEST['Apellido']) : '';
        $alm->Fechacrea = isset($_REQUEST['Fechacrea']) ? trim($_REQUEST['Fechacrea']) : date('Y-m-d');
        $alm->Genero    = isset($_REQUEST['Genero']) ? trim($_REQUEST['Genero']) : '';
        $alm->Email     = isset($_REQUEST['Email']) ? trim($_REQUEST['Email']) : '';
        $alm->Usuario   = isset($_REQUEST['Usuario']) ? trim($_REQUEST['Usuario']) : '';
        $alm->Password  = isset($_REQUEST['Password']) ? trim($_REQUEST['Password']) : '';
        $alm->Nivel     = isset($_REQUEST['Nivel']) ? trim($_REQUEST['Nivel']) : 'U';

        if ($alm->idUsuario > 0) {
            $this->model->Actualizar($alm);
        } else {
            $this->model->Registrar($alm);
        }

        header('Location: ?c=usuarios&a=menuUsuario');
        exit;
    }

    public function Eliminar()
    {
        if (isset($_REQUEST['idUsuario']) && !empty($_REQUEST['idUsuario'])) {
            $this->model->Eliminar((int)$_REQUEST['idUsuario']);
        }

        header('Location: ?c=usuarios&a=menuUsuario');
        exit;
    }
}