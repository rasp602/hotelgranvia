<?php

require_once 'bd/conexionLocal.php';

header('Content-Type: application/json; charset=utf-8');


/*
===========================================================
CÓDIGO
===========================================================
*/

if (!isset($_POST['codigoBarra'])) {

    echo json_encode([
        'success' => false,
        'message' => 'Código de barras del producto no proporcionado.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


$codigoBarra =
    trim($_POST['codigoBarra']);


if ($codigoBarra === '') {

    echo json_encode([
        'success' => false,
        'message' => 'Código de barras del producto no proporcionado.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}



/*
===========================================================
CANTIDAD
===========================================================
*/

if (
    !isset($_POST['cantidad']) ||
    trim($_POST['cantidad']) === ''
) {

    echo json_encode([
        'success' => false,
        'message' => 'Cantidad no proporcionada.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


$cantidad =
    (int)$_POST['cantidad'];


if ($cantidad <= 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Cantidad inválida.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}



/*
===========================================================
USUARIO
===========================================================
*/

$usuarioRegistro =
    isset($_POST['usuarioRegistro'])
        ? (int)$_POST['usuarioRegistro']
        : 0;


if ($usuarioRegistro <= 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Usuario del registro inválido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}



/*
===========================================================
MODO CAJA MANUAL

IMPORTANTE:
NO usamos producto.caja.

Este módulo permite decidir en cada movimiento
si se ingresa detallado o por caja.
===========================================================
*/

$ingresoPorCaja =
    isset($_POST['ingresoPorCaja'])
        ? (int)$_POST['ingresoPorCaja']
        : 0;


$unidadesPorCaja = 1;


if ($ingresoPorCaja === 1) {

    $unidadesPorCaja =
        isset($_POST['unidadesPorCaja'])
            ? (int)$_POST['unidadesPorCaja']
            : 0;


    if ($unidadesPorCaja <= 1) {

        echo json_encode([
            'success' => false,
            'message' => 'La cantidad de unidades por caja debe ser mayor a 1.'
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }

}



/*
===========================================================
CALCULAR CANTIDAD REAL
===========================================================
*/

if ($ingresoPorCaja === 1) {

    $cantidadReal =
        $cantidad *
        $unidadesPorCaja;

}
else {

    $cantidadReal =
        $cantidad;

}



/*
===========================================================
VARIABLES
===========================================================
*/

$stmt = null;
$updateStmt = null;
$insertStmt = null;


/*
===========================================================
TRANSACCIÓN

Esto evita que producto se actualice si falla inventario.
===========================================================
*/

$conn->begin_transaction();


try {


    /*
    =======================================================
    BUSCAR PRODUCTO

    NO necesitamos producto.caja.
    =======================================================
    */

    $sql = "
        SELECT

            idProducto,
            nombreProducto,
            existenciaProducto,
            imagenProducto

        FROM producto

        WHERE codigoBarra = ?

        LIMIT 1
    ";


    $stmt =
        $conn->prepare(
            $sql
        );


    if (!$stmt) {

        throw new Exception(
            "Error preparando consulta: " .
            $conn->error
        );

    }


    $stmt->bind_param(
        "s",
        $codigoBarra
    );


    if (!$stmt->execute()) {

        throw new Exception(
            "Error ejecutando consulta: " .
            $stmt->error
        );

    }


    $result =
        $stmt->get_result();


    if (
        $result->num_rows <= 0
    )
    {

        throw new Exception(
            "Producto no encontrado. Código: " .
            $codigoBarra
        );

    }


    $producto =
        $result->fetch_assoc();


    $idProducto =
        (int)$producto['idProducto'];


    $nombreProducto =
        $producto['nombreProducto'];


    $oldExistencia =
        (int)$producto['existenciaProducto'];


    $imagenProducto =
        $producto['imagenProducto'];


    /*
    =======================================================
    NUEVO STOCK
    =======================================================
    */

    $newExistencia =
        $oldExistencia +
        $cantidadReal;



    /*
    =======================================================
    ACTUALIZAR PRODUCTO
    =======================================================
    */

    $updateSql = "
        UPDATE producto

        SET existenciaProducto = ?

        WHERE idProducto = ?
    ";


    $updateStmt =
        $conn->prepare(
            $updateSql
        );


    if (!$updateStmt) {

        throw new Exception(
            "Error preparando actualización: " .
            $conn->error
        );

    }


    $updateStmt->bind_param(

        "ii",

        $newExistencia,

        $idProducto

    );


    if (!$updateStmt->execute()) {

        throw new Exception(
            "Error actualizando producto: " .
            $updateStmt->error
        );

    }



    /*
    =======================================================
    INVENTARIO

    cantRegistro = unidades realmente agregadas
    =======================================================
    */

    $insertSql = "
        INSERT INTO inventario
        (
            idInventario,
            fechaRegistro,
            horaRegistro,
            idProducto,
            cantRegistro,
            tipoRegistro,
            ultimoStock,
            idUsuario
        )

        VALUES
        (
            NULL,
            CURDATE(),
            CURTIME(),
            ?,
            ?,
            'I',
            ?,
            ?
        )
    ";


    $insertStmt =
        $conn->prepare(
            $insertSql
        );


    if (!$insertStmt) {

        throw new Exception(
            "Error preparando inventario: " .
            $conn->error
        );

    }


    $insertStmt->bind_param(

        "iiii",

        $idProducto,

        $cantidadReal,

        $newExistencia,

        $usuarioRegistro

    );


    if (!$insertStmt->execute()) {

        throw new Exception(
            "Error registrando inventario: " .
            $insertStmt->error
        );

    }



    /*
    =======================================================
    CONFIRMAR
    =======================================================
    */

    $conn->commit();



    /*
    =======================================================
    MENSAJE
    =======================================================
    */

    if ($ingresoPorCaja === 1) {

        $mensaje =

            '✔️ Ingreso realizado correctamente. ' .

            $cantidad .

            ' caja(s) × ' .

            $unidadesPorCaja .

            ' unidades = ' .

            $cantidadReal .

            ' unidades ingresadas.';

    }
    else {

        $mensaje =

            '✔️ Se ingresaron ' .

            $cantidadReal .

            ' unidad(es) correctamente.';

    }



    /*
    =======================================================
    RESPUESTA
    =======================================================
    */

    echo json_encode([

        'success' =>
            true,

        'message' =>
            $mensaje,

        'details' => [

            'idProducto' =>
                $idProducto,

            'codigoBarra' =>
                $codigoBarra,

            'nombre' =>
                $nombreProducto,

            'oldExistencia' =>
                $oldExistencia,

            /*
            Cantidad digitada:
            cajas si ingresoPorCaja = 1
            unidades si ingresoPorCaja = 0
            */

            'cantidadSolicitada' =>
                $cantidad,

            'ingresoPorCaja' =>
                $ingresoPorCaja,

            'unidadesPorCaja' =>
                $unidadesPorCaja,

            /*
            Cantidad efectivamente agregada
            */

            'cantidadIngresada' =>
                $cantidadReal,

            'newExistencia' =>
                $newExistencia,

            'imagenProducto' =>
                $imagenProducto,

            'idUsuario' =>
                $usuarioRegistro

        ]

    ], JSON_UNESCAPED_UNICODE);


}
catch(Exception $e)
{

    /*
    =======================================================
    REVERTIR TODO
    =======================================================
    */

    $conn->rollback();


    error_log(
        $e->getMessage()
    );


    echo json_encode([

        'success' =>
            false,

        'message' =>
            $e->getMessage()

    ], JSON_UNESCAPED_UNICODE);

}
finally
{

    if ($stmt) {
        $stmt->close();
    }

    if ($updateStmt) {
        $updateStmt->close();
    }

    if ($insertStmt) {
        $insertStmt->close();
    }

    $conn->close();
}

?>