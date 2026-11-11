<?php
class Actividad
{
	private $pdo;

    
    public $idActividad;
    public $descripcion;
    public $tipoA;
    public $idMaquinas;
    public $fechaA;
    public $horaA;
    public $id_user;
    public $statusA;
    public $imagen;
    public $imagen2;

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

	public function ListarLineas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM linea ORDER BY nLinea");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function ListarActividad()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM activiadad ORDER BY idActividad");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	

	public function Obtener($idActividad)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT 
            actividad.idActividad,
            actividad.descripcion,
            actividad.tipoA,
            actividad.idMaquina,
            actividad.fechaA,
            actividad.horaA,
            actividad.id_user,
            actividad.statusA,
            actividad.imagen,
            actividad.imagen2,

            maquina.idMaquina,
            maquina.nMaquina,
            maquina.idLinea,

            linea.idLinea,
            linea.nLinea
           
            FROM actividad
            INNER JOIN maquina ON maquina.idMaquina=actividad.idMaquina  
            INNER JOIN linea ON linea.idLinea=maquina.idLinea
            INNER JOIN usuario ON actividad.id_user=usuario.id_user
            INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario
		
        WHERE idActividad = ?;");
			          
			$stm->execute(array($idActividad));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}




	public function Registrar(Actividad $data)
	{
		try 
		{


		$sql = "INSERT INTO actividad (idActividad, descripcion, tipoA, idMaquina, fechaA, horaA, id_user, statusA,imagen,imagen2) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idActividad = NULL,	
				   $data->descripcion,
				   $data->tipoA,
				   $data->idMaquina,
				   $data->fechaA,
				   $data->horaA,
				   $data->id_user,
				   $data->statusA,
				   $data->imagen,
				   $data->imagen2,
               
                   
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function buscaEmail ($id_user)

	{
		try 
		{
			$stm = $this->pdo
			            ->prepare("SELECT * FROM usuario WHERE id_user = '$id_user'");			          

				$stm->execute(array($id_user));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ajax()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT 
            actividad.idActividad,
            actividad.descripcion,
            actividad.tipoA,
            actividad.idMaquina,
            actividad.fechaA,
            actividad.horaA,
            actividad.id_user,
            actividad.statusA,
            actividad.imagen,
            activiadad.imagen2,

            maquina.idMaquina,
            maquina.nMaquina,
            maquina.idLinea,

            linea.idLinea,
            linea.nLinea
           
            FROM actividad
            INNER JOIN maquina ON maquina.idMaquina=actividad.idMaquina  
            INNER JOIN linea ON linea.idLinea=maquina.idLinea
            INNER JOIN usuario ON actividad.id_user=usuario.id_user
            INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

public function Actualizar($data)
	{
		try 
		{
			$sql = "UPDATE actividad SET 

				    descripcion = ?,
				    tipoA = ?,
				    fechaA = ?,
				    horaA = ?,
				    id_user = ?,
				    statusA = ?,
				    imagen = ?,
				    imagen2 = ?



			       WHERE idActividad = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
                   $data->descripcion,
                   $data->tipoA,
                   $data->fechaA,
                   $data->horaA,
                   $data->id_user,
                   $data->statusA,
                   $data->imagen,
                   $data->imagen2,
                   $data->idActividad
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idActividad)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM actividad WHERE idActividad = ?");			          

			$stm->execute(array($idActividad));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}



}



?>
