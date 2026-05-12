<?php
class Producto
{
	private $pdo;

    
    public $idProducto;
    public $nombreProducto;
    public $precioProducto;
    public $codigoBarra;
    public $existenciaProducto;
	public $fechaIngreso;
	public $idTipoProducto;
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

	public function MarcarEntregado($id){
    $sql = "UPDATE ventas SET estado = 1 WHERE id = ?";
    $stm = $this->pdo->prepare($sql);
    $stm->execute([$id]);
}

	public function ListarProducto()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM producto ORDER BY producto.idProducto");
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
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM tipoproducto ORDER BY tipoproducto.idTipoProducto");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
public function Registrar(Producto $data)
{
    try 
    {
        $sql = "INSERT INTO producto (
                    nombreProducto,
                    precioProducto,
                    codigoBarra,
                    existenciaProducto,
                    fechaIngreso,
                    idTipoProducto,
                    imagenProducto,
                    estado
                ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $this->pdo->prepare($sql)->execute(
            array(
                $data->nombreProducto,
                $data->precioProducto,
                $data->codigoBarra,
                $data->existenciaProducto,
                $data->fechaIngreso,
                $data->idTipoProducto,
                $data->imagenProducto,
                $data->estado
            )
        );

    } catch (Exception $e) 
    {
        die($e->getMessage());
    }
}
public function Actualizar($data)
{
    try 
    {
        $sql = "UPDATE producto SET 
                    nombreProducto = ?,
                    precioProducto = ?,
                    codigoBarra = ?,
                    fechaIngreso = ?,
                    idTipoProducto = ?,
                    imagenProducto = ?
                WHERE idProducto = ?";

        $this->pdo->prepare($sql)
             ->execute(
                array(
                    $data->nombreProducto,
                    $data->precioProducto,
                    $data->codigoBarra,
                    $data->fechaIngreso,
                    $data->idTipoProducto,
                    $data->imagenProducto,
                    $data->idProducto
                )
            );
    } catch (Exception $e) 
    {
        die($e->getMessage());
    }
}
	public function ListarHotel()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM hotel ORDER BY idHotel");
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
			$stm = $this->pdo->prepare("UPDATE producto SET estado = 0 WHERE idProducto = ?");			          

			$stm->execute(array($idProducto));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function EliminarOrden($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM ventas WHERE id = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function EliminarPedido($idPedido)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM ventas_pedidos WHERE idPedido = ?");			          

			$stm->execute(array($idPedido));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idProducto)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM producto
        WHERE idProducto = ?;");
			          
			$stm->execute(array($idProducto));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerProductosVenta($id)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM producto
        WHERE id = ?;");
			          
			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	public function EliminarProductosOrden($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM productos_ventas WHERE idVenta = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	// Elimina los productos asociados a una venta específica


// Obtiene los productos y cantidades de la venta
public function ObtenerProductosVentaEliminar($id)
{
    try {
        $stm = $this->pdo->prepare("SELECT idProducto, cantidad FROM productos_ventas WHERE idVenta = ?");
        $stm->execute([$id]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

// Actualiza la cantidad de un producto en la tabla producto
public function ActualizarCantidadProducto($idProducto, $cantidad)
{
    try {
        $stm = $this->pdo->prepare("UPDATE producto SET existenciaProducto = existenciaProducto + ? WHERE idProducto = ?");
        $stm->execute([$cantidad, $idProducto]);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}


public function EliminarOrdenPreparada($id)
{
	try 
	{
		$stm = $this->pdo->prepare("DELETE FROM ventas_preparada WHERE id = ?");			          

		$stm->execute(array($id));
	} catch (Exception $e) 
	{
		die($e->getMessage());
	}
}

public function EliminarProductosOrdenPreparada($id)
{
	try 
	{
		$stm = $this->pdo->prepare("DELETE FROM productos_preparados WHERE idVenta_Preparado = ?");			          

		$stm->execute(array($id));
	} catch (Exception $e) 
	{
		die($e->getMessage());
	}
}

}


?>
