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
    <div class="card shadow-sm border-0">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="mb-0"><i class="fa fa-users"></i> Gestión de Usuarios</h3>
                    <small>Listado y administración de usuarios del sistema</small>
                </div>

                <a href="?c=usuarios&a=Crud" class="btn btn-light btn-sm mt-2 mt-md-0">
                    <i class="fa fa-plus-circle"></i> Agregar usuario
                </a>
            </div>
        </div>

        <div class="card-body" style="background-color: #f4f8ff;">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label><strong>Buscar por nombre, apellido, rut, usuario o correo</strong></label>
                    <input type="text" id="txtBuscarUsuario" class="form-control" placeholder="Escribe para buscar...">
                </div>
            </div>

            <div id="resultadoUsuarios"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    cargarUsuarios(1);

    $("#txtBuscarUsuario").keyup(function () {
        cargarUsuarios(1);
    });
});

function cargarUsuarios(page) {
    var buscar = $("#txtBuscarUsuario").val();

    $.ajax({
        url: 'usuarios/vista/usuarios_ajax.php',
        type: 'GET',
        data: {
            action: 'ajax',
            page: page,
            buscar: buscar
        },
        beforeSend: function () {
            $("#resultadoUsuarios").html(
                '<div class="text-center p-4">' +
                '<div class="spinner-border text-primary" role="status"></div>' +
                '<div class="mt-2">Cargando usuarios...</div>' +
                '</div>'
            );
        },
        success: function (data) {
            $("#resultadoUsuarios").html(data);
        }
    });
}
</script>
</div>