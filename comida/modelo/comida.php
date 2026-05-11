<?php
class Comida
{
	private $pdo;

    
    public $idComida;
    public $tipoComida;
    public $idPersona;
    public $horaComida;


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

			$stm = $this->pdo->prepare("SELECT * FROM comida ORDER BY comida.idComida");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
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






	public function ObtenerQr($qrPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona
        WHERE qrPersona = ?;");
			          
			$stm->execute(array($qrPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
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




	public function Registrar(Comida $data)
	{
		try 
		{

		$sql = "INSERT INTO comida (idComida, tipoComida, idPersona, horaComida, fechaComida) 
		        VALUES (?, ?, ?, ?, ?)";
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idComida = NULL,	
				   $data->tipoComida,
				   $data->idPersona, 
				   $data->horaComida,
				   $data->fechaComida, 
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
			$sql = "UPDATE comida SET 

				   tipoComida = ?,
				   idPersona = ?,
				   horaComida = ?
				   

			       WHERE idComida = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->tipoComida,
                   $data->idPersona,
                   $data->horaComida

				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idComida)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM comida WHERE idComida = ?");			          

			$stm->execute(array($idComida));
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
