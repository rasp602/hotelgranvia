<?php
class Hotel
{
	private $pdo;
    
    public $idHotel;
    public $rutHotel;
    public $nombreHotel;
    public $capacidadHotel;
    public $direccion;


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

	public function Hotel()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM idHotel");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idHotel)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM hotel
        WHERE idHotel = ?;");
			          
			$stm->execute(array($idHotel));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerRutHotel($rutHotel)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM hotel
        WHERE rutHotel = ?;");
			          
			$stm->execute(array($rutHotel));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Hotel $data)
	{
		try 
		{


		$sql = "INSERT INTO hotel (idHotel,rutHotel, nombreHotel, capacidadHotel,direccion) 
		        VALUES (?, ?, ?,?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idHotel = NULL,
				   $data->rutHotel,	
				   $data->nombreHotel,
				   $data->capacidadHotel,
				   $data->direccion  
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarHotel($data)
	{
		try 
		{
			$sql = "UPDATE hotel SET 
					rutHotel = ?,
				    nombreHotel = ?,
				    capacidadHotel = ?,
				    direccion = ?

			       WHERE idHotel = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->rutHotel,
                   $data->nombreHotel,
                   $data->capacidadHotel,
                   $data->direccion,
                   $data->idHotel

					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idHotel)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM hotel WHERE idHotel = ?");			          

			$stm->execute(array($idHotel));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
