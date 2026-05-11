<?php
class Salida
{
	private $pdo;

    
    public $idSalidaT;
    public $idTrabajador;
    public $horaSalida;
    public $fechaSalidaT;


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

	public function ListarSalidaT()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM salidaT ORDER BY salida.idSalidaT");
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



	public function Eliminar($idSalidaT)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM salidaT WHERE idSalidaT = ?");			          

			$stm->execute(array($idEntradaT));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}






}


?>
