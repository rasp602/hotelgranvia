<?php 
$usuario = null;

if (isset($_SESSION["usuarioInventario"])) {

    $usuario = $_SESSION["usuarioInventario"];

    if ($usuario->nivel == "U") {
        include_once 'menu_principal/vista/Menu_Usuarios.php'; 
    } elseif ($usuario->nivel == "F") {
        include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
    } elseif ($usuario->nivel == "I") {
        include_once 'menu_principal/vista/Menu_Inventario.php';   
    } 

    // ID del usuario que realizará el egreso
    $usuarioRegistro = $usuario->idUsuario;
}
?> 

<?php

$registros = isset($movimientos['registros'])
    ? $movimientos['registros']
    : array();

$totalRegistros = isset($movimientos['totalRegistros'])
    ? $movimientos['totalRegistros']
    : 0;

$paginaActual = isset($movimientos['paginaActual'])
    ? $movimientos['paginaActual']
    : 1;

$totalPaginas = isset($movimientos['totalPaginas'])
    ? $movimientos['totalPaginas']
    : 1;


function valorFiltro($nombre)
{
    return isset($_GET[$nombre])
        ? htmlspecialchars($_GET[$nombre])
        : '';
}

?>


<style>

/*
=============================================
PÁGINA
=============================================
*/

.historial-page{
    padding:20px 0 35px;
}

.historial-shell{
    max-width:1500px;
    margin:0 auto;
}


/*
=============================================
CABECERA
=============================================
*/

.historial-header{
    background:linear-gradient(
        135deg,
        #0d6efd,
        #0a58ca
    );

    color:#fff;

    padding:24px;

    border-radius:18px;

    margin-bottom:20px;

    box-shadow:
        0 8px 24px
        rgba(0,0,0,.10);
}


.historial-header h2{

    margin:0;

    font-size:28px;

    font-weight:700;

}


.historial-header p{

    margin:7px 0 0;

    opacity:.92;

}



/*
=============================================
RESUMEN
=============================================
*/

.resumen-grid{

    display:grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(190px,1fr)
        );

    gap:15px;

    margin-bottom:20px;

}


.resumen-card{

    background:#fff;

    border-radius:16px;

    padding:18px;

    border:1px solid #e9ecef;

    box-shadow:
        0 5px 15px
        rgba(0,0,0,.07);

}


.resumen-icon{

    width:46px;

    height:46px;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:21px;

    margin-bottom:12px;

}


.icon-total{

    background:#e7f1ff;

    color:#0d6efd;

}


.icon-ingreso{

    background:#e9f9ee;

    color:#198754;

}


.icon-egreso{

    background:#fdecec;

    color:#dc3545;

}


.icon-productos{

    background:#fff4e5;

    color:#fd7e14;

}


.resumen-title{

    color:#667085;

    font-size:13px;

    font-weight:600;

}


.resumen-value{

    color:#1d2939;

    font-size:25px;

    font-weight:800;

    margin-top:3px;

}



/*
=============================================
FILTROS
=============================================
*/

.filtros-card{

    background:#fff;

    border-radius:18px;

    padding:20px;

    border:1px solid #e9ecef;

    box-shadow:
        0 5px 18px
        rgba(0,0,0,.07);

    margin-bottom:20px;

}


.filtros-title{

    color:#0d6efd;

    font-size:20px;

    font-weight:700;

    margin-bottom:18px;

}


.filtros-card label{

    font-size:13px;

    font-weight:700;

    color:#344054;

    margin-bottom:6px;

}


.filtros-card .form-control{

    min-height:44px;

    border-radius:10px !important;

    border:
        1px solid
        #d0d5dd !important;

}


.filtros-card .form-control:focus{

    border-color:
        #0d6efd !important;

    box-shadow:
        0 0 0 .15rem
        rgba(
            13,
            110,
            253,
            .12
        ) !important;

}



/*
=============================================
TABLA
=============================================
*/

.tabla-card{

    background:#fff;

    border-radius:18px;

    overflow:hidden;

    border:1px solid #e9ecef;

    box-shadow:
        0 5px 18px
        rgba(0,0,0,.07);

}


.tabla-header{

    padding:18px 20px;

    display:flex;

    justify-content:
        space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:10px;

}


.tabla-header h4{

    margin:0;

    font-size:20px;

    font-weight:700;

    color:#1d2939;

}


.table{

    margin-bottom:0;

}


.table thead th{

    background:#f8fafc;

    color:#475467;

    font-size:12px;

    text-transform:uppercase;

    letter-spacing:.4px;

    border-bottom:
        1px solid #eaecf0;

    white-space:nowrap;

}


.table tbody td{

    vertical-align:middle;

    color:#344054;

    font-size:14px;

}


/*
=============================================
PRODUCTO
=============================================
*/

.producto-cell{

    display:flex;

    align-items:center;

    gap:10px;

}


.producto-img{

    width:46px;

    height:46px;

    border-radius:10px;

    object-fit:contain;

    border:1px solid #e4e7ec;

    background:#fff;

    padding:3px;

}


.producto-nombre{

    font-weight:700;

    color:#1d2939;

}


.producto-codigo{

    font-size:12px;

    color:#667085;

}



/*
=============================================
USUARIO
=============================================
*/

.usuario-nombre{

    font-weight:700;

    color:#344054;

}


.usuario-rut{

    font-size:12px;

    color:#667085;

}



/*
=============================================
BADGES
=============================================
*/

.badge-ingreso{

    background:#e9f9ee;

    color:#198754;

    border:
        1px solid
        #c9edd5;

    padding:7px 11px;

    border-radius:999px;

    font-weight:700;

}


.badge-egreso{

    background:#fdecec;

    color:#dc3545;

    border:
        1px solid
        #f5c2c7;

    padding:7px 11px;

    border-radius:999px;

    font-weight:700;

}


.stock-final{

    font-weight:800;

    color:#0d6efd;

}



/*
=============================================
PAGINACIÓN
=============================================
*/

.pagination{

    margin-bottom:0;

}


.page-link{

    color:#0d6efd;

}


.page-item.active .page-link{

    background:#0d6efd;

    border-color:#0d6efd;

}



/*
=============================================
SIN REGISTROS
=============================================
*/

.sin-registros{

    padding:50px 20px;

    text-align:center;

    color:#667085;

}


.sin-registros i{

    display:block;

    font-size:46px;

    color:#98a2b3;

    margin-bottom:12px;

}



/*
=============================================
RESPONSIVE
=============================================
*/

@media(max-width:767px){

    .historial-page{

        padding:
            10px 7px 25px;

    }


    .historial-header{

        padding:18px;

    }


    .historial-header h2{

        font-size:22px;

    }


    .resumen-grid{

        grid-template-columns:
            repeat(
                2,
                1fr
            );

    }


    .filtros-card{

        padding:15px;

    }


    .table-responsive{

        border-radius:
            0 0 18px 18px;

    }


    .producto-img{

        width:38px;

        height:38px;

    }

}

</style>


<div class="container-fluid historial-page">

<div class="historial-shell">


<!-- ======================================
CABECERA
====================================== -->

<div class="historial-header">

    <h2>

        <i class="bi bi-clock-history"></i>

        Historial de Inventario

    </h2>

    <p>

        Control y trazabilidad de todos los
        ingresos y egresos realizados en el inventario.

    </p>

</div>



<!-- ======================================
RESUMEN
====================================== -->

<div class="resumen-grid">


<div class="resumen-card">

    <div class="resumen-icon icon-total">

        <i class="bi bi-arrow-left-right"></i>

    </div>

    <div class="resumen-title">

        Movimientos

    </div>

    <div class="resumen-value">

        <?php
        echo number_format(
            (int)$resumenInventario->totalMovimientos,
            0,
            ',',
            '.'
        );
        ?>

    </div>

</div>



<div class="resumen-card">

    <div class="resumen-icon icon-ingreso">

        <i class="bi bi-box-arrow-in-down"></i>

    </div>

    <div class="resumen-title">

        Unidades ingresadas

    </div>

    <div class="resumen-value">

        <?php
        echo number_format(
            (int)$resumenInventario->unidadesIngresadas,
            0,
            ',',
            '.'
        );
        ?>

    </div>

</div>



<div class="resumen-card">

    <div class="resumen-icon icon-egreso">

        <i class="bi bi-box-arrow-up"></i>

    </div>

    <div class="resumen-title">

        Unidades egresadas

    </div>

    <div class="resumen-value">

        <?php
        echo number_format(
            (int)$resumenInventario->unidadesEgresadas,
            0,
            ',',
            '.'
        );
        ?>

    </div>

</div>



<div class="resumen-card">

    <div class="resumen-icon icon-productos">

        <i class="bi bi-box-seam"></i>

    </div>

    <div class="resumen-title">

        Productos involucrados

    </div>

    <div class="resumen-value">

        <?php
        echo number_format(
            (int)$resumenInventario->productosMovidos,
            0,
            ',',
            '.'
        );
        ?>

    </div>

</div>


</div>



<!-- ======================================
FILTROS
====================================== -->

<div class="filtros-card">


<div class="filtros-title">

    <i class="bi bi-funnel"></i>

    Filtros de búsqueda

</div>


<form method="GET">


<input
    type="hidden"
    name="c"
    value="producto"
>


<input
    type="hidden"
    name="a"
    value="menuHistorialInventario"
>


<div class="row">


<div class="col-lg-3 col-md-6">

    <div class="form-group">

        <label>

            Buscar producto

        </label>

        <input
            type="text"
            name="buscar"
            class="form-control"
            value="<?php echo valorFiltro('buscar'); ?>"
            placeholder="Nombre, código, usuario o RUT"
        >

    </div>

</div>



<div class="col-lg-2 col-md-6">

    <div class="form-group">

        <label>

            Desde

        </label>

        <input
            type="date"
            name="fechaDesde"
            class="form-control"
            value="<?php echo valorFiltro('fechaDesde'); ?>"
        >

    </div>

</div>



<div class="col-lg-2 col-md-6">

    <div class="form-group">

        <label>

            Hasta

        </label>

        <input
            type="date"
            name="fechaHasta"
            class="form-control"
            value="<?php echo valorFiltro('fechaHasta'); ?>"
        >

    </div>

</div>



<div class="col-lg-2 col-md-6">

    <div class="form-group">

        <label>

            Usuario

        </label>

        <select
            name="idUsuario"
            class="form-control"
        >

            <option value="">

                Todos

            </option>


            <?php
            foreach(
                $usuariosInventario
                as $usuarioItem
            ):
            ?>

            <option

                value="<?php
                echo $usuarioItem->idUsuario;
                ?>"

                <?php
                echo (
                    valorFiltro('idUsuario')
                    == $usuarioItem->idUsuario
                )
                    ? 'selected'
                    : '';
                ?>

            >

                <?php

                echo htmlspecialchars(
                    trim(
                        $usuarioItem->nombre .
                        ' ' .
                        $usuarioItem->apellido
                    )
                );

                ?>

            </option>


            <?php endforeach; ?>


        </select>

    </div>

</div>



<div class="col-lg-2 col-md-6">

    <div class="form-group">

        <label>

            Movimiento

        </label>


        <select
            name="tipo"
            class="form-control"
        >

            <option value="">

                Todos

            </option>


            <option
                value="I"
                <?php
                echo valorFiltro('tipo') == 'I'
                    ? 'selected'
                    : '';
                ?>
            >

                Ingresos

            </option>


            <option
                value="E"
                <?php
                echo valorFiltro('tipo') == 'E'
                    ? 'selected'
                    : '';
                ?>
            >

                Egresos

            </option>


        </select>

    </div>

</div>



<div
    class="col-lg-1 col-md-6"
    style="
        display:flex;
        align-items:flex-end;
    "
>

    <div
        class="form-group"
        style="width:100%;"
    >

        <button
            type="submit"
            class="btn btn-primary"
            style="
                width:100%;
                min-height:44px;
                border-radius:10px;
            "
        >

            <i class="bi bi-search"></i>

        </button>

    </div>

</div>


</div>


<div
    style="
        margin-top:10px;
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    "
>


<button
    type="submit"
    class="btn btn-primary"
>

    <i class="bi bi-funnel-fill"></i>

    Aplicar filtros

</button>



<a
    href="?c=producto&a=menuHistorialInventario"
    class="btn btn-outline-secondary"
>

    <i class="bi bi-arrow-counterclockwise"></i>

    Limpiar

</a>


</div>


</form>


</div>



<!-- ======================================
TABLA
====================================== -->

<div class="tabla-card">


<div class="tabla-header">

    <h4>

        <i class="bi bi-list-check"></i>

        Movimientos registrados

    </h4>


    <span class="badge badge-primary">

        <?php echo $totalRegistros; ?>

        registros

    </span>

</div>



<?php if(count($registros) > 0): ?>


<div class="table-responsive">


<table class="table table-hover">


<thead>

<tr>

    <th>#</th>

    <th>Fecha / Hora</th>

    <th>Producto</th>

    <th>Movimiento</th>

    <th>Cantidad</th>

    <th>Stock resultante</th>

    <th>Realizado por</th>

    <th>RUT</th>

</tr>

</thead>



<tbody>


<?php foreach($registros as $registro): ?>


<tr>


<td>

    <?php
    echo $registro->idInventario;
    ?>

</td>



<td>

    <strong>

        <?php

        echo date(
            'd-m-Y',
            strtotime(
                $registro->fechaRegistro
            )
        );

        ?>

    </strong>

    <br>

    <small class="text-muted">

        <?php
        echo substr(
            $registro->horaRegistro,
            0,
            5
        );
        ?>

    </small>

</td>



<td>


<div class="producto-cell">


<img

    class="producto-img"

    src="<?php

    if(
        !empty(
            $registro->imagenProducto
        )
    ){

        echo 'img/productos/' .
        htmlspecialchars(
            $registro->imagenProducto
        );

    } else {

        echo 'img/no-image.png';

    }

    ?>"

    onerror="
        this.onerror=null;
        this.src='img/no-image.png';
    "
>


<div>


<div class="producto-nombre">

    <?php

    echo htmlspecialchars(
        $registro->nombreProducto
        ?? 'Producto eliminado'
    );

    ?>

</div>


<div class="producto-codigo">

    <?php

    echo htmlspecialchars(
        $registro->codigoBarra
        ?? ''
    );

    ?>

</div>


</div>


</div>


</td>



<td>


<?php if($registro->tipoRegistro == 'I'): ?>


<span class="badge-ingreso">

    <i class="bi bi-arrow-down-circle"></i>

    INGRESO

</span>


<?php else: ?>


<span class="badge-egreso">

    <i class="bi bi-arrow-up-circle"></i>

    EGRESO

</span>


<?php endif; ?>


</td>



<td>


<strong>

<?php

echo number_format(
    $registro->cantRegistro,
    0,
    ',',
    '.'
);

?>

</strong>


</td>



<td>


<span class="stock-final">

<?php

echo number_format(
    $registro->ultimoStock,
    0,
    ',',
    '.'
);

?>

</span>


</td>



<td>


<?php if($registro->idUsuario): ?>


<div class="usuario-nombre">

    <i class="bi bi-person-circle"></i>

    <?php

    echo htmlspecialchars(
        trim(
            ($registro->nombreUsuario ?? '') .
            ' ' .
            ($registro->apellidoUsuario ?? '')
        )
    );

    ?>

</div>


<small class="text-muted">

    ID:
    <?php
    echo $registro->idUsuario;
    ?>

</small>


<?php else: ?>


<span class="text-muted">

    <i class="bi bi-person-x"></i>

    Sin identificar

</span>


<?php endif; ?>


</td>



<td>


<span class="usuario-rut">

<?php

echo htmlspecialchars(
    $registro->rutUsuario
    ?? '-'
);

?>

</span>


</td>


</tr>


<?php endforeach; ?>


</tbody>


</table>


</div>



<!-- ======================================
PAGINACIÓN
====================================== -->


<?php if($totalPaginas > 1): ?>


<div
    style="
        padding:18px;
        display:flex;
        justify-content:center;
    "
>


<ul class="pagination">


<?php


$queryActual = $_GET;

unset(
    $queryActual['pagina']
);


function urlPagina(
    $pagina,
    $queryActual
){

    $queryActual['pagina'] =
        $pagina;

    return '?' .
        http_build_query(
            $queryActual
        );

}


?>


<li
class="page-item
<?php
echo $paginaActual <= 1
    ? 'disabled'
    : '';
?>
"
>

<a
class="page-link"

href="<?php
echo urlPagina(
    max(
        1,
        $paginaActual - 1
    ),
    $queryActual
);
?>"
>

&laquo;

</a>

</li>



<?php


$inicio =
    max(
        1,
        $paginaActual - 2
    );

$fin =
    min(
        $totalPaginas,
        $paginaActual + 2
    );


for(
    $p=$inicio;
    $p<=$fin;
    $p++
):

?>


<li
class="page-item
<?php
echo $p == $paginaActual
    ? 'active'
    : '';
?>
"
>

<a
class="page-link"

href="<?php
echo urlPagina(
    $p,
    $queryActual
);
?>"
>

<?php echo $p; ?>

</a>

</li>


<?php endfor; ?>



<li
class="page-item
<?php
echo $paginaActual >= $totalPaginas
    ? 'disabled'
    : '';
?>
"
>

<a
class="page-link"

href="<?php
echo urlPagina(
    min(
        $totalPaginas,
        $paginaActual + 1
    ),
    $queryActual
);
?>"
>

&raquo;

</a>

</li>


</ul>


</div>


<?php endif; ?>



<?php else: ?>


<div class="sin-registros">

    <i class="bi bi-inbox"></i>

    <strong>

        No se encontraron movimientos

    </strong>

    <div>

        Prueba cambiando los filtros de búsqueda.

    </div>

</div>


<?php endif; ?>


</div>


</div>

</div>