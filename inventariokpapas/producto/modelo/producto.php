<?php

class Producto
{
    private $pdo;

    public $idProducto;
    public $nombreProducto;
    public $precioProducto;
    public $codigoBarra;
    public $existenciaProducto;

    // NUEVO
    public $caja;

    public $fechaIngreso;
    public $idTipoProducto;
    public $imagenProducto;
    public $estado;


    public function __CONSTRUCT()
    {
        try
        {
            $this->pdo = DatabaseLocal::ConectarLocal();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function MarcarEntregado($id)
    {
        $sql = "UPDATE ventas SET estado = 1 WHERE id = ?";

        $stm = $this->pdo->prepare($sql);

        $stm->execute([$id]);
    }


    public function ListarProducto()
    {
        try
        {
            $stm = $this->pdo->prepare("
                SELECT *
                FROM producto
                ORDER BY producto.idProducto
            ");

            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function ListarTipoProducto()
    {
        try
        {
            $stm = $this->pdo->prepare("
                SELECT *
                FROM tipoproducto
                ORDER BY tipoproducto.idTipoProducto
            ");

            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    /*
    ============================================================
    REGISTRAR PRODUCTO
    ============================================================
    */

    public function Registrar(Producto $data)
    {
        try
        {
            $sql = "INSERT INTO producto (
                        nombreProducto,
                        precioProducto,
                        codigoBarra,
                        existenciaProducto,
                        caja,
                        fechaIngreso,
                        idTipoProducto,
                        imagenProducto,
                        estado
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $this->pdo
                 ->prepare($sql)
                 ->execute(
                    array(
                        $data->nombreProducto,
                        $data->precioProducto,
                        $data->codigoBarra,
                        $data->existenciaProducto,

                        // NUEVO
                        $data->caja,

                        $data->fechaIngreso,
                        $data->idTipoProducto,
                        $data->imagenProducto,
                        $data->estado
                    )
                );

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    /*
    ============================================================
    ACTUALIZAR PRODUCTO
    ============================================================
    */

    public function Actualizar($data)
    {
        try
        {
            $sql = "UPDATE producto SET

                        nombreProducto = ?,
                        precioProducto = ?,
                        codigoBarra = ?,

                        caja = ?,

                        fechaIngreso = ?,
                        idTipoProducto = ?,
                        imagenProducto = ?

                    WHERE idProducto = ?";

            $this->pdo
                 ->prepare($sql)
                 ->execute(
                    array(
                        $data->nombreProducto,
                        $data->precioProducto,
                        $data->codigoBarra,

                        // NUEVO
                        $data->caja,

                        $data->fechaIngreso,
                        $data->idTipoProducto,
                        $data->imagenProducto,
                        $data->idProducto
                    )
                );

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function ListarHotel()
    {
        try
        {
            $stm = $this->pdo->prepare("
                SELECT *
                FROM hotel
                ORDER BY idHotel
            ");

            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function Eliminar($idProducto)
    {
        try
        {
            $stm = $this->pdo->prepare("
                UPDATE producto
                SET estado = 0
                WHERE idProducto = ?
            ");

            $stm->execute(array($idProducto));
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function EliminarOrden($id)
    {
        try
        {
            $stm = $this->pdo->prepare("
                DELETE FROM ventas
                WHERE id = ?
            ");

            $stm->execute(array($id));
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function EliminarPedido($idPedido)
    {
        try
        {
            $stm = $this->pdo->prepare("
                DELETE FROM ventas_pedidos
                WHERE idPedido = ?
            ");

            $stm->execute(array($idPedido));
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


public function Obtener($idProducto)
{
    try
    {
        $stm = $this->pdo->prepare("
            SELECT *
            FROM producto
            WHERE idProducto = ?
        ");

        $stm->execute(array($idProducto));

        return $stm->fetch(PDO::FETCH_OBJ);

    }
    catch(Exception $e)
    {
        die($e->getMessage());
    }
}


    public function ObtenerProductosVenta($id)
    {
        try
        {
            $stm = $this->pdo->prepare("
                SELECT *
                FROM producto
                WHERE id = ?
            ");

            $stm->execute(array($id));

            return $stm->fetch(PDO::FETCH_OBJ);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function EliminarProductosOrden($id)
    {
        try
        {
            $stm = $this->pdo->prepare("
                DELETE FROM productos_ventas
                WHERE idVenta = ?
            ");

            $stm->execute(array($id));
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function ObtenerProductosVentaEliminar($id)
    {
        try
        {
            $stm = $this->pdo->prepare("
                SELECT
                    idProducto,
                    cantidad
                FROM productos_ventas
                WHERE idVenta = ?
            ");

            $stm->execute([$id]);

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function ActualizarCantidadProducto($idProducto, $cantidad)
    {
        try
        {
            $stm = $this->pdo->prepare("
                UPDATE producto
                SET existenciaProducto = existenciaProducto + ?
                WHERE idProducto = ?
            ");

            $stm->execute([
                $cantidad,
                $idProducto
            ]);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function EliminarOrdenPreparada($id)
    {
        try
        {
            $stm = $this->pdo->prepare("
                DELETE FROM ventas_preparada
                WHERE id = ?
            ");

            $stm->execute(array($id));
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function EliminarProductosOrdenPreparada($id)
    {
        try
        {
            $stm = $this->pdo->prepare("
                DELETE FROM productos_preparados
                WHERE idVenta_Preparado = ?
            ");

            $stm->execute(array($id));
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function ListarUsuariosInventario()
    {
        try
        {
            $sql = "SELECT
                        idUsuario,
                        rut,
                        nombre,
                        apellido
                    FROM tblusuario
                    ORDER BY nombre ASC, apellido ASC";

            $stm = $this->pdo->prepare($sql);

            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function ListarMovimientosInventario($filtros = array())
    {
        try
        {
            $where = array();
            $params = array();

            if (
                isset($filtros['fechaDesde']) &&
                $filtros['fechaDesde'] != ''
            )
            {
                $where[] = "i.fechaRegistro >= ?";
                $params[] = $filtros['fechaDesde'];
            }

            if (
                isset($filtros['fechaHasta']) &&
                $filtros['fechaHasta'] != ''
            )
            {
                $where[] = "i.fechaRegistro <= ?";
                $params[] = $filtros['fechaHasta'];
            }

            if (
                isset($filtros['idUsuario']) &&
                $filtros['idUsuario'] != ''
            )
            {
                $where[] = "i.idUsuario = ?";
                $params[] = $filtros['idUsuario'];
            }

            if (
                isset($filtros['tipo']) &&
                $filtros['tipo'] != ''
            )
            {
                $where[] = "i.tipoRegistro = ?";
                $params[] = $filtros['tipo'];
            }

            if (
                isset($filtros['buscar']) &&
                $filtros['buscar'] != ''
            )
            {
                $buscar = "%" . $filtros['buscar'] . "%";

                $where[] = "(
                    p.nombreProducto LIKE ?
                    OR p.codigoBarra LIKE ?
                    OR u.nombre LIKE ?
                    OR u.apellido LIKE ?
                    OR u.rut LIKE ?
                )";

                $params[] = $buscar;
                $params[] = $buscar;
                $params[] = $buscar;
                $params[] = $buscar;
                $params[] = $buscar;
            }

            $whereSql = "";

            if (count($where) > 0)
            {
                $whereSql =
                    " WHERE " .
                    implode(" AND ", $where);
            }


            $pagina = isset($filtros['pagina'])
                ? max(1, (int)$filtros['pagina'])
                : 1;

            $porPagina = 50;

            $offset =
                ($pagina - 1) *
                $porPagina;


            $sqlCount = "
                SELECT COUNT(*) AS total

                FROM inventario i

                LEFT JOIN producto p
                    ON p.idProducto = i.idProducto

                LEFT JOIN tblusuario u
                    ON u.idUsuario = i.idUsuario

                $whereSql
            ";

            $stmCount =
                $this->pdo->prepare(
                    $sqlCount
                );

            $stmCount->execute(
                $params
            );

            $resultadoCount =
                $stmCount->fetch(
                    PDO::FETCH_OBJ
                );

            $totalRegistros =
                $resultadoCount
                    ? (int)$resultadoCount->total
                    : 0;


            $sql = "
                SELECT

                    i.idInventario,

                    i.fechaRegistro,
                    i.horaRegistro,

                    i.idProducto,
                    i.cantRegistro,
                    i.tipoRegistro,
                    i.ultimoStock,
                    i.idUsuario,

                    p.codigoBarra,
                    p.nombreProducto,
                    p.imagenProducto,

                    u.rut AS rutUsuario,
                    u.nombre AS nombreUsuario,
                    u.apellido AS apellidoUsuario

                FROM inventario i

                LEFT JOIN producto p
                    ON p.idProducto = i.idProducto

                LEFT JOIN tblusuario u
                    ON u.idUsuario = i.idUsuario

                $whereSql

                ORDER BY
                    i.fechaRegistro DESC,
                    i.horaRegistro DESC,
                    i.idInventario DESC

                LIMIT $porPagina
                OFFSET $offset
            ";

            $stm =
                $this->pdo->prepare(
                    $sql
                );

            $stm->execute(
                $params
            );

            $registros =
                $stm->fetchAll(
                    PDO::FETCH_OBJ
                );

            $totalPaginas =
                $totalRegistros > 0
                    ? ceil(
                        $totalRegistros /
                        $porPagina
                    )
                    : 1;

            return array(
                'registros' => $registros,
                'totalRegistros' => $totalRegistros,
                'paginaActual' => $pagina,
                'porPagina' => $porPagina,
                'totalPaginas' => $totalPaginas
            );

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }


    public function ResumenMovimientosInventario($filtros = array())
    {
        try
        {
            $where = array();
            $params = array();

            if (
                isset($filtros['fechaDesde']) &&
                $filtros['fechaDesde'] != ''
            )
            {
                $where[] = "i.fechaRegistro >= ?";
                $params[] = $filtros['fechaDesde'];
            }

            if (
                isset($filtros['fechaHasta']) &&
                $filtros['fechaHasta'] != ''
            )
            {
                $where[] = "i.fechaRegistro <= ?";
                $params[] = $filtros['fechaHasta'];
            }

            if (
                isset($filtros['idUsuario']) &&
                $filtros['idUsuario'] != ''
            )
            {
                $where[] = "i.idUsuario = ?";
                $params[] = $filtros['idUsuario'];
            }

            if (
                isset($filtros['tipo']) &&
                $filtros['tipo'] != ''
            )
            {
                $where[] = "i.tipoRegistro = ?";
                $params[] = $filtros['tipo'];
            }

            if (
                isset($filtros['buscar']) &&
                $filtros['buscar'] != ''
            )
            {
                $buscar =
                    "%" .
                    $filtros['buscar'] .
                    "%";

                $where[] = "(
                    p.nombreProducto LIKE ?
                    OR p.codigoBarra LIKE ?
                    OR u.nombre LIKE ?
                    OR u.apellido LIKE ?
                    OR u.rut LIKE ?
                )";

                $params[] = $buscar;
                $params[] = $buscar;
                $params[] = $buscar;
                $params[] = $buscar;
                $params[] = $buscar;
            }

            $whereSql = "";

            if (count($where) > 0)
            {
                $whereSql =
                    " WHERE " .
                    implode(
                        " AND ",
                        $where
                    );
            }


            $sql = "
                SELECT

                    COUNT(i.idInventario)
                        AS totalMovimientos,

                    SUM(
                        CASE
                            WHEN i.tipoRegistro = 'I'
                            THEN 1
                            ELSE 0
                        END
                    ) AS cantidadIngresos,

                    SUM(
                        CASE
                            WHEN i.tipoRegistro = 'E'
                            THEN 1
                            ELSE 0
                        END
                    ) AS cantidadEgresos,

                    SUM(
                        CASE
                            WHEN i.tipoRegistro = 'I'
                            THEN i.cantRegistro
                            ELSE 0
                        END
                    ) AS unidadesIngresadas,

                    SUM(
                        CASE
                            WHEN i.tipoRegistro = 'E'
                            THEN i.cantRegistro
                            ELSE 0
                        END
                    ) AS unidadesEgresadas,

                    COUNT(
                        DISTINCT i.idProducto
                    ) AS productosMovidos,

                    COUNT(
                        DISTINCT i.idUsuario
                    ) AS usuariosParticipantes

                FROM inventario i

                LEFT JOIN producto p
                    ON p.idProducto = i.idProducto

                LEFT JOIN tblusuario u
                    ON u.idUsuario = i.idUsuario

                $whereSql
            ";

            $stm =
                $this->pdo->prepare(
                    $sql
                );

            $stm->execute(
                $params
            );

            return $stm->fetch(
                PDO::FETCH_OBJ
            );
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}

?>