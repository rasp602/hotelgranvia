<?php
class ComidaServida
{
	private $pdo;

    
    public $idComidaservida;
	public $idHotel;
    public $tipoComida;
    public $fechaComida;
    public $cantidad;



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

	public function ListarComida()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM comidaServida ORDER BY comidaservida.idComidaservida");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}



	public function Obtener($idPersona,$fechaComida,$tipoComida)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM comida WHERE idPersona = '$idPersona' AND fechaComida = '$fechaComida' and tipoComida = '$tipoComida'");
			          
			$stm->execute(array($idPersona,$fechaComida,$tipoComida));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function ListarEmpresas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM empresa ORDER BY idEmpresa");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerEstadoHospedaje($idPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT 

	
			persona.idPersona,
			persona.qrPersona,
			hospedaje.idHospedaje,
			hospedaje.idPersona,
			hospedaje.estado

	 FROM persona 

		INNER JOIN hospedaje ON persona.idPersona=hospedaje.idPersona

	 WHERE persona.idPersona = '$idPersona' ");
			          
			$stm->execute(array($idPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

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







	public function ConsultarQR($qrPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona WHERE qrPersona = '$qrPersona'");
			          
			$stm->execute(array($qrPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}




	public function Registrar(ComidaServida $data)
	{
		try 
		{

		$sql = "INSERT INTO comidaservida (idComidaservida, idHotel, tipoComida, fechaComida, cantidad,idEmpresa) 
		        VALUES (?, ?, ?, ?, ?,?)";
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idComidaservida = NULL,	
				   $data->idHotel,
				   $data->tipoComida, 
				   $data->fechaComida,
				   $data->cantidad,
				   $data->idEmpresa,
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
			$sql = "UPDATE comidaExtra SET 

				   idHotel = ?,
				   tipoComida = ?,
				   fechaComida = ?,
				   cantidad = ?,
				   idEmpresa = ?
				   

			       WHERE idComidaServida = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->idHotel,
                   $data->tipoComida,
                   $data->fechaComida,
				   $data->cantidad,
				   $data->idEmpresa

				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idComidaservida)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM comidaservida WHERE idComidaservida = ?");			          

			$stm->execute(array($idComidaservida));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function ObtenerFechaComida(Comida $data)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM comida WHERE idPersona =  ? ;");
			          
		
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}



}


?>
