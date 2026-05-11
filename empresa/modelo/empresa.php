<?php
class Empresa
{
	private $pdo;
	private $pdoRemoteh2;
	private $pdoRemoteh3;
	private $pdoRemoteh4;

    
    public $idEmpresa;
    public $rutEmpresa;
    public $nombreEmpresa;
    public $ContratoEmpresa;
    public $contratoEmpresa1;
    public $horaSalida;


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
			$this->pdoRemoteh4 = DatabaseRemoteh4::ConectarRemoteh4();
		*/


        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

	public function ListarEmpresa()
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




	public function Empresa()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM idEmpresa");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idEmpresa)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM empresa
        WHERE idEmpresa = ?;");
			          
			$stm->execute(array($idEmpresa));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerRutEmpresa($rutEmpresa)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM empresa
        WHERE rutEmpresa = ?;");
			          
			$stm->execute(array($rutEmpresa));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Empresa $data)
	{
		try 
		{


		$sql = "INSERT INTO empresa (idEmpresa,rutEmpresa, nombreEmpresa, ContratoEmpresa, contratoEmpresa1,horaSalida) 
		        VALUES (?, ?, ?,?, ?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idEmpresa = NULL,
				   $data->rutEmpresa,	
				   $data->nombreEmpresa,
				   $data->ContratoEmpresa,
				   $data->contratoEmpresa1,
				   $data->horaSalida  
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

	public function RegistrarRemoteh2(Empresa $data)
	{
		try 
		{


		$sql = "INSERT INTO empresa (idEmpresa,rutEmpresa, nombreEmpresa, ContratoEmpresa, contratoEmpresa1,horaSalida) 
		        VALUES (?, ?, ?,?, ?,?)";
	
	 	

		$this->pdoRemoteh2->prepare($sql)
		     ->execute(
				array(
				   $data->idEmpresa = NULL,
				   $data->rutEmpresa,	
				   $data->nombreEmpresa,
				   $data->ContratoEmpresa,
				   $data->contratoEmpresa1,
				   $data->horaSalida  
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}
	public function RegistrarRemoteh3(Empresa $data)
	{
		try 
		{


		$sql = "INSERT INTO empresa (idEmpresa,rutEmpresa, nombreEmpresa, ContratoEmpresa, contratoEmpresa1,horaSalida) 
		        VALUES (?, ?, ?,?, ?,?)";
	
	 	

		$this->pdoRemoteh3->prepare($sql)
		     ->execute(
				array(
				   $data->idEmpresa = NULL,
				   $data->rutEmpresa,	
				   $data->nombreEmpresa,
				   $data->ContratoEmpresa,
				   $data->contratoEmpresa1,
				   $data->horaSalida  
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

	public function RegistrarRemoteh4(Empresa $data)
	{
		try 
		{


		$sql = "INSERT INTO empresa (idEmpresa,rutEmpresa, nombreEmpresa, ContratoEmpresa, contratoEmpresa1,horaSalida) 
		        VALUES (?, ?, ?,?, ?,?)";
	
	 	

		$this->pdoRemoteh4->prepare($sql)
		     ->execute(
				array(
				   $data->idEmpresa = NULL,
				   $data->rutEmpresa,	
				   $data->nombreEmpresa,
				   $data->ContratoEmpresa,
				   $data->contratoEmpresa1,
				   $data->horaSalida  
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


	public function Eliminar($idEmpresa)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM empresa WHERE idEmpresa = ?");			          

			$stm->execute(array($idEmpresa));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function EliminarRemoteh2($idEmpresa)
	{
		try 
		{
			$stm = $this->pdoRemoteh2->prepare("DELETE FROM empresa WHERE idEmpresa = ?");			          

			$stm->execute(array($idEmpresa));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function EliminarRemoteh3($idEmpresa)
	{
		try 
		{
			$stm = $this->pdoRemoteh3->prepare("DELETE FROM empresa WHERE idEmpresa = ?");			          

			$stm->execute(array($idEmpresa));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function EliminarRemoteh4($idEmpresa)
	{
		try 
		{
			$stm = $this->pdoRemoteh4->prepare("DELETE FROM empresa WHERE idEmpresa = ?");			          

			$stm->execute(array($idEmpresa));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
