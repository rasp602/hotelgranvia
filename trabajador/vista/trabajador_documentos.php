
<div class="container-fluid">
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
               }               
         ?> 

    <h2 class="titulos text-center">Documentos del Trabajador</h2>

    <?php if (isset($_GET["success"])): ?>
        <div class="alert alert-success">Documentos guardados correctamente.</div>
    <?php endif; ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <strong>
                <?php echo utf8_encode($vte->nombreTrabajador . " " . $vte->apellidoTrabajador1 . " " . $vte->apellidoTrabajador2); ?>
            </strong>
            <br>
            RUT: <?php echo utf8_encode($vte->rutTrabajador); ?>
        </div>

        <div class="panel-body">

            <form action="?c=trabajador&a=GuardarDocumentos" method="post" enctype="multipart/form-data">

                <input type="hidden" name="idTrabajador" value="<?php echo $vte->idTrabajador; ?>">

                <?php
                function mostrarDocumento($ruta) {
                    if ($ruta != "") {
                        echo '<a href="'.$ruta.'" target="_blank" class="btn btn-success btn-xs">Ver documento</a>';
                    } else {
                        echo '<span class="label label-danger">Sin cargar</span>';
                    }
                }
                ?>

                <div class="row">

                    <div class="col-md-6">
                        <label>Ficha Personal</label>
                        <input type="file" name="fichaPersonal" class="form-control">
                        <br>
                        <?php mostrarDocumento(isset($documentos->fichaPersonal) ? $documentos->fichaPersonal : ""); ?>
                    </div>

                    <div class="col-md-6">
                        <label>Currículo</label>
                        <input type="file" name="curriculum" class="form-control">
                        <br>
                        <?php mostrarDocumento(isset($documentos->curriculum) ? $documentos->curriculum : ""); ?>
                    </div>

                    <div class="col-md-6">
                        <label>Carnet</label>
                        <input type="file" name="carnet" class="form-control">
                        <br>
                        <?php mostrarDocumento(isset($documentos->carnet) ? $documentos->carnet : ""); ?>
                    </div>

                    <div class="col-md-6">
                        <label>Certificado AFP</label>
                        <input type="file" name="certificadoAfp" class="form-control">
                        <br>
                        <?php mostrarDocumento(isset($documentos->certificadoAfp) ? $documentos->certificadoAfp : ""); ?>
                    </div>

                    <div class="col-md-6">
                        <label>Fonasa</label>
                        <input type="file" name="fonasa" class="form-control">
                        <br>
                        <?php mostrarDocumento(isset($documentos->fonasa) ? $documentos->fonasa : ""); ?>
                    </div>

                    <div class="col-md-6">
                        <label>Último Finiquito</label>
                        <input type="file" name="ultimoFiniquito" class="form-control">
                        <br>
                        <?php mostrarDocumento(isset($documentos->ultimoFiniquito) ? $documentos->ultimoFiniquito : ""); ?>
                    </div>

                </div>

                <hr>

                <button type="submit" class="btn btn-primary">
                    Guardar Documentos
                </button>

                <a href="?c=trabajador&a=menuTrabajador" class="btn btn-default">
                    Volver
                </a>

            </form>

        </div>
    </div>
</div>