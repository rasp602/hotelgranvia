<?php
class Contrato
{
	private $pdo;
	private $pdoRemoteh2;
	private $pdoRemoteh3;
	private $pdoRemoteh4;

    
    public $idEmpresa;
    public $nombreContrato;



    // Constructor
    public function __construct()
    {
        try
        {
            // Conexión a la base de datos local
            $this->pdo = DatabaseLocal::ConectarLocal();
		    // Conexión a la base de datos remota
			/*$this->pdoRemoteh2 = DatabaseRemoteh2::ConectarRemoteh2();
			$this->pdoRemoteh3 = DatabaseRemoteh3::ConectarRemoteh3();
			$this->pdoRemoteh4 = DatabaseRemoteh4::ConectarRemoteh4();*/
		


        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

	public function ListarContrato()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM contrato ORDER BY idContrato");
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




	public function Contrato()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM idContrato");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idContrato)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM contrato
        WHERE idContrato = ?;");
			          
			$stm->execute(array($idContrato));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerNombreContrato($nombreContrato)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM contrato
        WHERE nombreContrato = ?;");
			          
			$stm->execute(array($nombreContrato));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Contrato $data)
	{
		try 
		{


		$sql = "INSERT INTO contrato (idContrato,nombreContrato,idEmpresa) 
		        VALUES (?, ?, ?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idContrato = NULL,
				   $data->nombreContrato,
				   $data->idEmpresa
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

	public function RegistrarRemoteh2(Contrato $data)
	{
		try 
		{


		$sql = "INSERT INTO contrato (idContrato,nombreContrato,idEmpresa) 
		VALUES (?, ?, ?)";	
	 	

					$this->pdoRemoteh2->prepare($sql)
					->execute(
					array(
						$data->idContrato = NULL,
						$data->nombreContrato,
						$data->idEmpresa
					)
				);	
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}
	public function RegistrarRemoteh3(Contrato $data)
	{
		try 
		{


		$sql = "INSERT INTO contrato (idContrato,nombreContrato,idEmpresa) 
		VALUES (?, ?, ?)";
	
	 	

				$this->pdoRemoteh3->prepare($sql)
				->execute(
				array(
					$data->idContrato = NULL,
					$data->nombreContrato,
					$data->idEmpresa
				)
			);	
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

	public function RegistrarRemoteh4(Contrato $data)
	{
		try 
		{


		$sql = "INSERT INTO contrato (idContrato,nombreContrato,idEmpresa) 
		VALUES (?, ?, ?)";
	

				$this->pdoRemoteh4->prepare($sql)
				->execute(
				array(
					$data->idContrato = NULL,
					$data->nombreContrato,
					$data->idEmpresa
				)
			);	
						

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

public function ActualizarEmpresa($data)
	{
		try 
		{
			$sql = "UPDATE empresa SET 
					rutEmpresa = ?,
				    nombreEmpresa = ?,
				    ContratoEmpresa = ?,
				    contratoEmpresa1 = ?,
				    horaSalida = ?

			       WHERE idEmpresa = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->rutEmpresa,
                   $data->nombreEmpresa,
                   $data->ContratoEmpresa,
                   $data->contratoEmpresa1,
                   $data->horaSalida,
                   $data->idEmpresa

					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idContrato)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM contrato WHERE idContrato = ?");			          

			$stm->execute(array($idContrato));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function EliminarRemoteh2($idContrato)
	{
		try 
		{
			$stm = $this->pdoRemoteh2->prepare("DELETE FROM contrato WHERE idContrato = ?");			          

			$stm->execute(array($idContrato));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function EliminarRemoteh3($idContrato)
	{
		try 
		{
			$stm = $this->pdoRemoteh3->prepare("DELETE FROM contrato WHERE idContrato = ?");			          

			$stm->execute(array($idContrato));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function EliminarRemoteh4($idContrato)
	{
		try 
		{
			$stm = $this->pdoRemoteh4->prepare("DELETE FROM contrato WHERE idContrato = ?");			          

			$stm->execute(array($idContrato));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
