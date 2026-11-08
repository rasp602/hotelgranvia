<?php
include_once "funciones.php";
session_start();

$lista = isset($_SESSION['lista']) ? $_SESSION['lista'] : [];
?>

<style>
    .carrito-table thead th {
        background: #eef8e8;
        color: #3d7d1e;
        border-bottom: 1px solid #d7e8ca !important;
        font-weight: 700;
    }

    .carrito-table tbody td {
        vertical-align: middle !important;
    }

    .qty-input {
        max-width: 90px;
        min-height: 40px;
        border-radius: 10px !important;
        border: 1px solid #ceddc3 !important;
    }

    .resumen-entrega {
        background: #f3faee;
        border: 1px dashed #cfe2bf;
        border-radius: 14px;
        padding: 16px;
        margin-top: 14px;
    }

    .resumen-linea {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 15px;
        color: #4b5b43;
    }

    .resumen-total {
        font-weight: 700;
        color: #3d7d1e;
        font-size: 18px;
        border-top: 1px solid #dbe8d1;
        padding-top: 12px;
        margin-top: 12px;
    }

    .acciones-carrito {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 18px;
    }

    .acciones-carrito .btn,
    .acciones-carrito form {
        min-width: 200px;
    }

    .acciones-carrito form .btn {
        width: 100%;
    }

    .mobile-item {
        display: none;
    }

    @media (max-width: 767px) {
        .desktop-table {
            display: none;
        }

        .mobile-item {
            display: block;
            background: #fff;
            border: 1px solid #e5eddc;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.04);
        }

        .mobile-item .titulo {
            font-size: 16px;
            font-weight: 700;
            color: #1d2939;
            margin-bottom: 10px;
        }

        .mobile-item .linea {
            font-size: 14px;
            color: #4f5f47;
            margin-bottom: 8px;
        }

        .mobile-item .linea strong {
            color: #3d7d1e;
        }

        .acciones-carrito {
            flex-direction: column;
        }

        .acciones-carrito .btn,
        .acciones-carrito form {
            width: 100%;
        }
    }
</style>

<?php if(empty($lista)) { ?>
    <div class="empty-box">
        <i class="bi bi-bag-x" style="font-size:40px; color:#8ba37c;"></i>
        <div style="margin-top:10px; font-weight:700;">No hay productos en la entrega</div>
        <div style="margin-top:5px;">Agrega productos desde el catálogo.</div>
    </div>
<?php } else { ?>

    <div class="desktop-table">
        <div class="table-responsive">
            <table class="table carrito-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Existencia</th>
                        <th>Cantidad</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalUnidades = 0;
                    foreach($lista as $producto) { 
                        $totalUnidades += (int)$producto->cantidad;
                    ?>
                    <tr>
                        <td><?php echo $producto->codigoBarra; ?></td>
                        <td><?php echo $producto->nombreProducto; ?></td>
                        <td><?php echo $producto->existenciaProducto; ?></td>
                        <td>
                            <input 
                                type="number"
                                class="form-control qty-input input-cantidad"
                                data-id="<?php echo $producto->idProducto; ?>"
                                value="<?php echo $producto->cantidad; ?>"
                                min="1"
                                max="<?php echo $producto->existenciaProducto; ?>">
                        </td>
                        <td>
                            <button 
                                type="button"
                                class="btn btn-danger btn-quitar"
                                data-id="<?php echo $producto->idProducto; ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php foreach($lista as $producto) { ?>
        <div class="mobile-item">
            <div class="titulo"><?php echo $producto->nombreProducto; ?></div>
            <div class="linea"><strong>Código:</strong> <?php echo $producto->codigoBarra; ?></div>
            <div class="linea"><strong>Existencia:</strong> <?php echo $producto->existenciaProducto; ?></div>
            <div class="linea">
                <strong>Cantidad:</strong>
                <input 
                    type="number"
                    class="form-control qty-input input-cantidad"
                    data-id="<?php echo $producto->idProducto; ?>"
                    value="<?php echo $producto->cantidad; ?>"
                    min="1"
                    max="<?php echo $producto->existenciaProducto; ?>">
            </div>
            <div style="margin-top:10px;">
                <button 
                    type="button"
                    class="btn btn-danger btn-block btn-quitar"
                    data-id="<?php echo $producto->idProducto; ?>">
                    <i class="bi bi-trash"></i> Quitar
                </button>
            </div>
        </div>
    <?php } ?>

    <div class="resumen-entrega">
        <div class="resumen-linea">
            <span>Productos distintos</span>
            <strong><?php echo count($lista); ?></strong>
        </div>
        <div class="resumen-linea resumen-total">
            <span>Total unidades a entregar</span>
            <strong><?php echo $totalUnidades; ?></strong>
        </div>
    </div>

    <div class="acciones-carrito">
        <form action="registrar_venta.php" method="post">
            <button type="submit" class="btn btn-success btn-lg" style="background:#5fae32; border-color:#5fae32;">
                <i class="bi bi-check2-circle"></i> Confirmar entrega
            </button>
        </form>

        <a class="btn btn-danger btn-lg" href="cancelar_venta.php">
            <i class="bi bi-x-circle"></i> Cancelar entrega
        </a>
    </div>

<?php } ?>