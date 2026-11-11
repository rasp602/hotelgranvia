<?php
class Persona
{
	private $pdo;

    
    public $idPersona;
    public $rutPersona;
    public $nombresPersona;
    public $apellidoPersona1;
    public $apellidoPersona2;
    public $fechaCreado;
    public $fotoPersona;
    public $qrPersona;
    public $genero;
    public $horaCreado;
    public $idEmpresa;
     public $card;
	 public $idContrato;


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

	public function ListarPersonas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM persona ORDER BY idPersona");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Personas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM persona");
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


	public function ListarContratos()
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


	public function Obtener($idPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona
        WHERE idPersona = ?;");
			          
			$stm->execute(array($idPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerRut($rutPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona
        WHERE rutPersona = ?;");
			          
			$stm->execute(array($rutPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


		public function ObtenerID($rutPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona
        WHERE rutPersona = ?;");
			          
			$stm->execute(array($rutPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Persona $data)
	{
		try 
		{


		$sql = "INSERT INTO persona (idPersona, rutPersona, nombresPersona, apellidoPersona1, apellidoPersona2, fechaCreado, fotoPersona, qrPersona,genero,horaCreado,card,idEmpresa,idContrato) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idPersona = NULL,	
				   $data->rutPersona,
				   $data->nombresPersona,
				   $data->apellidoPersona1,
				   $data->apellidoPersona2,
				   $data->fechaCreado,
				   $data->fotoPersona,
				   $data->qrPersona,
				   $data->genero,
				   $data->horaCreado,
				   $data->card,
				   $data->idEmpresa,
				   $data->idContrato

               
                   
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarP($data)
	{
		try 
		{
			$sql = "UPDATE persona SET 

				    rutPersona = ?,
				    nombresPersona = ?,
				    apellidoPersona1 = ?,
				    apellidoPersona2 = ?,
				    fechaCreado = ?,
				    fotoPersona = ?,
				    genero = ?,
				    horaCreado = ?,
				    qrPersona = ?,
				    idEmpresa = ?,
				    card = ?,
					idContrato = ?

			       WHERE idPersona = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
                   $data->rutPersona,
                   $data->nombresPersona,
                   $data->apellidoPersona1,
                   $data->apellidoPersona2,
                   $data->fechaCreado,
                   $data->fotoPersona,
                   $data->genero,
                   $data->horaCreado,
                   $data->qrPersona,
                   $data->idEmpresa,
                   $data->card,
				   $data->idContrato,
                   $data->idPersona
				   


					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function ActualizarQr($data)
	{
		try 
		{

			$sql = "UPDATE persona SET 

				    qrPersona = ?



			       WHERE idPersona = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->qrPersona,
                   $data->idPersona
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idPersona)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM persona WHERE idPersona = ?");			          

			$stm->execute(array($idPersona));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}



	public function lafuncion()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idPersona)  as 'valor' FROM persona");

			     	$stm->execute(array($idPersona));
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}








}



?>
