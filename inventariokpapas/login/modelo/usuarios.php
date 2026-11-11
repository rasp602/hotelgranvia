<?php
class Alumno
{
	private $pdo;
    
   /* public $idUsuario;
    public $rut;
    public $Nombre;
    public $Apellido;
    public $FechaRegistro;
    public $Genero;*/
 
  

    public $Email;
    public $Password;
    public $Nivel;



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



	
		public function validarUsuario($Email,$Password)

	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT *  FROM usuario 			          
			          INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario
						WHERE email = '$Email' AND password = '".sha1($Password)."'");

				$stm->execute(array());
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
			            ->prepare("SELECT  nivel FROM usuario WHERE email = '$Email'");			          

				$stm->execute(array());
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}




		public function lafuncion()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idUsuario) as 'valor'  FROM tblusuario");

			     	$stm->execute();
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}


}