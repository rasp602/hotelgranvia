<?php
class ComidaExtra
{
	private $pdo;

    
    public $idComidaExtra;
    public $tipoComida;
    public $persona;
    public $horaComida;
    public $observacion;
    public $idEmpresa;


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

			$stm = $this->pdo->prepare("SELECT * FROM comidaExtra ORDER BY comida.idComida");
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




	public function Registrar(ComidaExtra $data)
	{
		try 
		{

		$sql = "INSERT INTO comidaextra (idComidaExtra, tipoComida, persona, horaComida, fechaComida,observacion,idEmpresa) 
		        VALUES (?, ?, ?, ?, ?,?,?)";
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idComidaExtra = NULL,	
				   $data->tipoComida,
				   $data->persona, 
				   $data->horaComida,
				   $data->fechaComida,
				   $data->observacion, 
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

				   tipoComida = ?,
				   persona = ?,
				   horaComida = ?
				   

			       WHERE idComidaExtra = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->tipoComida,
                   $data->persona,
                   $data->horaComida

				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idComidaExtra)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM comidaExtra WHERE idComidaExtra = ?");			          

			$stm->execute(array($idComidaExtra));
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
