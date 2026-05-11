<?php
$idUsuario = isset($alm->idUsuario) ? $alm->idUsuario : 0;
?>
<?php 
          $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                                echo "hola usuario";
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                                echo "hola Fiscalizador";
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
                        if ($usuario->nivel == "I") 
                        {
                                echo "hola Inventario";
                                include_once 'menu_principal/vista/Menu_Inventario.php';   
                        } 
               }          
         ?>
<div class="container-fluid mt-3">
    <div class="card shadow border-0">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
            <h3 class="mb-0">
                <i class="fa fa-user-plus"></i>
                <?php echo ($idUsuario > 0) ? 'Editar usuario' : 'Registrar usuario'; ?>
            </h3>
        </div>

        <div class="card-body" style="background-color: #f4f8ff;">
            <form method="post" action="?c=usuarios&a=Guardar" autocomplete="off">
                <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label><strong>Rut</strong></label>
                        <input type="text" name="Rut" class="form-control" required
                               value="<?php echo isset($alm->rut) ? htmlspecialchars($alm->rut) : ''; ?>"
                               placeholder="Ej: 26299304-3">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Nombre</strong></label>
                        <input type="text" name="Nombre" class="form-control" required
                               value="<?php echo isset($alm->nombre) ? htmlspecialchars($alm->nombre) : ''; ?>"
                               placeholder="Nombre">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Apellido</strong></label>
                        <input type="text" name="Apellido" class="form-control" required
                               value="<?php echo isset($alm->apellido) ? htmlspecialchars($alm->apellido) : ''; ?>"
                               placeholder="Apellido">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Fecha de registro</strong></label>
                        <input type="date" name="Fechacrea" class="form-control" required
                               value="<?php echo isset($alm->fechacrea) ? $alm->fechacrea : date('Y-m-d'); ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Género</strong></label>
                        <select name="Genero" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <option value="M" <?php echo (isset($alm->genero) && $alm->genero == 'M') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="F" <?php echo (isset($alm->genero) && $alm->genero == 'F') ? 'selected' : ''; ?>>Femenino</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Usuario</strong></label>
                        <input type="text" name="Usuario" class="form-control"
                               value="<?php echo isset($alm->usuario) ? htmlspecialchars($alm->usuario) : ''; ?>"
                               placeholder="Nombre de usuario">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label><strong>Correo electrónico</strong></label>
                        <input type="email" name="Email" class="form-control" required
                               value="<?php echo isset($alm->email) ? htmlspecialchars($alm->email) : ''; ?>"
                               placeholder="correo@dominio.com">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label><strong>Nivel</strong></label>
                        <select name="Nivel" class="form-control" required>
                            <option value="U" <?php echo (isset($alm->nivel) && $alm->nivel == 'U') ? 'selected' : ''; ?>>Usuario</option>
                            <option value="A" <?php echo (isset($alm->nivel) && $alm->nivel == 'A') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label><strong>Password</strong></label>
                        <input type="password" name="Password" class="form-control"
                               <?php echo ($idUsuario == 0) ? 'required' : ''; ?>
                               placeholder="<?php echo ($idUsuario > 0) ? 'Dejar vacío para no cambiar' : 'Ingrese password'; ?>">
                        <small class="text-muted">
                            <?php echo ($idUsuario > 0) ? 'Solo se cambia si escribes una nueva clave.' : 'Se guardará con formato MD5.'; ?>
                        </small>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between flex-wrap">
                    <a href="?c=usuarios&a=menuUsuario" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Volver
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        <?php echo ($idUsuario > 0) ? 'Actualizar usuario' : 'Guardar usuario'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>