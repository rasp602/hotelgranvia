<?php
class Ingreso
{
	private $pdo;

    
    public $idEntradaT;
    public $idTrabajador;
    public $horaEntradaT;
    public $fechaEntradaT;
     public $validacion;


  	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = Database::Conectar();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarEntradaT()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM entradaT ORDER BY entrada.idEntradaT");
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



	public function ObtenerQr($qrTrabajador)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM trabajador
        WHERE qrTrabajador = ?;");
			          
			$stm->execute(array($qrTrabajador));
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
	$stm = $this->pdo->prepare("SELECT 

			comida.idComida,
			comida.idPersona,
			comida.tipoComida,
			comida.fechaComida,
			comida.horaComida,
			persona.idPersona,
			persona.qrPersona

	 FROM comida 
		INNER JOIN persona ON comida.idPersona=persona.idPersona

	 WHERE persona.idPersona = '$idPersona' AND comida.fechaComida = '$fechaComida' and comida.tipoComida = '$tipoComida'");
			          
			$stm->execute(array($idPersona,$fechaComida,$tipoComida));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerID($idEntradaT)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM entradat WHERE entradat.idEntradaT = '$idEntradaT'");
			          
			$stm->execute(array($idEntradaT));
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


	public function ValidarEtra($data)
	{
		try 
		{

			$sql = "UPDATE entradat SET 

				    validacion = ?

			       WHERE idEntradaT = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->validacion,
                   $data->idEntradaT
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}




    public function ConsultaTrabajadores()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM trabajador WHERE estado='A'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	    public function ConsultaTrabajadoresInativos()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM trabajador WHERE estado='I'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function RegistrarIngresoDiario($data)
	{
		try 
		{

		$sql = "INSERT INTO entradat (idEntradaT, Fecha, idTrabajador, fechaEntradaT, horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras,validacion) 
		        VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idEntradaT = NULL,	
				   $data->Fecha,
				   $data->idTrabajador, 
				   $data->fechaEntradaT="0000-00-00",
				   $data->horaEntrada="00:00:00",
				   $data->fechaSalida="0000-00-00",
				   $data->horaSalida="00:00:00",
				   $data->horasTrabajadas="0",
				   $data->horasExtras="0",
				   $data->validacion="0"

                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

		public function RegistrarIngresoDiarioPrueba($data)
	{
		try 
		{

		$sql = "INSERT INTO entradat (idEntradaT, Fecha, idTrabajador, fechaEntradaT, horaEntrada,fechaSalida,horaSalida,horasTrabajadas,horasExtras,validacion) 
		        VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idEntradaT = NULL,	
				   $data->Fecha,
				   $data->idTrabajador, 
				   $data->fechaEntradaT="0000-00-00",
				   $data->horaEntrada="00:00:00",
				   $data->fechaSalida="0000-00-00",
				   $data->horaSalida="00:00:00",
				   $data->horasTrabajadas="0",
				   $data->horasExtras="0",
				   $data->validacion="0"

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

	public function Eliminar($idEntradaT)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM entrada WHERE idEntradaT = ?");			          

			$stm->execute(array($idEntradaT));
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


	public function validarNivel ($Email)

	{
		try 
		{
			$stm = $this->pdo
			            ->prepare("SELECT  nivel FROM usuario WHERE id_user = '$Email'");			          

				$stm->execute(array($Email));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}



}


?>
