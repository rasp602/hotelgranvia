<?php
class Hospedaje
{
	private $pdo;

    
    public $idHospedaje;
    public $idPersona;
    public $idHotel;
    public $idHabitacion;
    public $idCama;
    public $desde;
    public $hasta;
    public $estado;
    public $estadoCama;
    public $fechaDespedida;
    public $horaDespedida;
    public $tipoHabitacion;



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

	public function ListarHospedaje()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM hospedaje ORDER BY idHospedaje");
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


		public function ListarHabitacionesH1()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM habitacion where idHotel = '1' ORDER BY nHabitacion");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


		public function ListarHabitacionesH2()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM habitacion where idHotel = '2'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


		public function ListarHabitacionesH3()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM habitacion where idHotel = '3'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}



		public function ListarHabitacionesH4()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM habitacion where idHotel = '4'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


		public function ListarHabitacionesH5()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM habitacion where idHotel = '5'");
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





			public function ListarEstados()
	{
		try
		{
			$result = array();
			 date_default_timezone_set("America/Santiago");
			$date=date("Y-m-d");
			$stm = $this->pdo->prepare("SELECT * FROM hospedaje WHERE hasta < '$date'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function cantHospedaje()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM hospedaje");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}





	public function Obtener($idHospedaje)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM hospedaje
        WHERE idHospedaje = ?;");
			          
			$stm->execute(array($idHospedaje));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	    public function ObtenerEstadoError()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT 
        
        hospedaje.idHospedaje,
        hospedaje.idPersona,
        hospedaje.idHotel,
        hospedaje.idHabitacion,
        hospedaje.idCama,
        hospedaje.desde,
        hospedaje.hasta,
        hospedaje.estado,

        hotel.idHotel,
        hotel.nombreHotel,
        hotel.capacidadHotel,
        hotel.direccion,

        habitacion.idHabitacion,
        habitacion.idHotel,
        habitacion.nHabitacion,
        habitacion.capacidadHabitacion,
        habitacion.capacidadReal,
       
        
        cama.idCama,
        cama.idHabitacion,
        cama.nCama,
        cama.estadoCama,

        persona.idPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.rutPersona,
        persona.qrPersona,

        empresa.idEmpresa,
        empresa.nombreEmpresa
        
        FROM hospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
        where hospedaje.estado  = 'A' and cama.estadoCama = 'A'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	
        


		public function ConsultarDisponible($idHospedaje)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM hospedaje
        WHERE idHospedaje = ?;");
			          
			$stm->execute(array($idHospedaje));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerPersona($qrPersona,$estado)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT hospedaje.idPersona,hospedaje.estado,persona.idPersona,persona.qrPersona FROM hospedaje INNER JOIN persona ON hospedaje.idPersona=persona.idPersona
        WHERE persona.qrPersona = ? and hospedaje.estado = ?;");
			          
			$stm->execute(array($qrPersona,$estado));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerPersonaRegistro($idPersona,$estado)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT hospedaje.idPersona,hospedaje.estado,persona.idPersona,persona.qrPersona FROM hospedaje INNER JOIN persona ON hospedaje.idPersona=persona.idPersona
        WHERE persona.idPersona = ? and hospedaje.estado = ?;");
			          
			$stm->execute(array($idPersona,$estado));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerPersonaqr($qrPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT persona.idPersona,persona.qrPersona FROM persona
        WHERE persona.qrPersona = ?;");
			          
			$stm->execute(array($qrPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


		public function ObtenerEstado($data)
	{
		try 
		{

	$stm = $this->pdo->prepare("SELECT * FROM hospedaje
        WHERE hasta < ?;");
			   $result = array();       
			$stm->execute(array($data));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerEstadoActivo($data)
	{
		try 
		{

	$stm = $this->pdo->prepare("SELECT * FROM hospedaje
        WHERE estado = ?;");
			   $result = array();       
			$stm->execute(array($data));
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

			public function ObtenerHabitacion($data)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM habitacion
        WHERE idHabitacion = ?;");
			          
			$stm->execute(array($data));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

			public function ObtenerCama($idCama)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM cama
        WHERE idCama = ?;");
			          
			$stm->execute(array($idCama));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Hospedaje $data)
	{
		try 
		{


		$sql = "INSERT INTO hospedaje (idHospedaje, idPersona, idHotel, idHabitacion, idCama, desde, hasta, estado,fechaDespedida,horaDespedida,tipoHabitacion) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idHospedaje = NULL,	
				   $data->idPersona,
				   $data->idHotel,
				   $data->idHabitacion,
				   $data->idCama,
				   $data->desde,
				   $data->hasta,
				   $data->estado,
				   $data->fechaDespedida= NULL,
				   $data->horaDespedida= NULL,
				   $data->tipoHabitacion   
               
                   
                )
			);
	$dato=$this->lafuncion();
		  	
		  	$te= "INSERT INTO resumenhospedaje (idResumen,idHospedaje,FechaR,Act) VALUES (?,'".$dato[0]."', ?, ?)";


			$this->pdo->prepare($te)
		     ->execute(
				array(
				   $data->idResumen=Null,	
				   $data->FechaR,
				   $data->Act,
          
                   
                )
                );





	return $funcion; 		

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

	public function lafuncion()
	{	
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idHospedaje)  as 'valor' FROM hospedaje");

			     	$stm->execute(array($idHospedaje));
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}







public function Actualizar($data)
	{
		try 
		{
			$sql = "UPDATE hospedaje SET 

				    idPersona = ?,
				    idHotel = ?,
				    idHabitacion = ?,
				    idCama = ?,
				    desde = ?,
				    hasta = ?,
				    estado = ?

			       WHERE idHospedaje = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
                   $data->idPersona,
                   $data->idHotel,
                   $data->idHabitacion,
                   $data->idCama,
                   $data->desde,
                   $data->hasta,
                   $data->estado,                   
                   $data->idHospedaje		                                              
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

	public function ActualizarEstado($consultaEstado)
	{
		try 
		{

			$sql = "UPDATE hospedaje SET 

				    estado = ?,
				    fechaDespedida = ?,
				    horaDespedida = ?



			       WHERE idHospedaje = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $consultaEstado->estado,
                   $consultaEstado->fechaDespedida,
                   $consultaEstado->horaDespedida,
                   $consultaEstado->idHospedaje
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


		public function ActualizarCama($data)
	{
		try 
		{

			$sql = "UPDATE cama SET 

				    estadoCama = ?

			       WHERE idCama = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->estadoCama,
                   $data->idCama
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

public function ActualizarCamaError($data)
	{
		try 
		{

			$sql = "UPDATE cama SET 

				    estadoCama = ?

			       WHERE idCama = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->estadoCama,
                   $data->idCama
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ActualizarHabitacion($data)
	{
		try 
		{

			$sql = "UPDATE habitacion SET 

				    capacidadHabitacion = ?

			       WHERE idHabitacion = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->capacidadHabitacion,
                   $data->idHabitacion
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ActualizarHabitacionCero($data)
	{
		try 
		{

			$sql = "UPDATE habitacion SET 

				    capacidadHabitacion = 0

			       WHERE idHabitacion = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->capacidadHabitacion,
                   $data->idHabitacion
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ActualizarHabitacionCapacidadReal($capacidadReal)
	{
		try 
		{

			$sql = "UPDATE habitacion SET 

				    capacidadHabitacion = ?

			       WHERE idHabitacion = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $capacidadReal->capacidadHabitacion,
                   $capacidadReal->idHabitacion
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ActualizarCama1($data)
	{
		try 
		{

			$sql = "UPDATE cama SET 

				    estadoCama = ?

			       WHERE idCama = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->estadoCama,
                   $data->idCama
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idHospedaje)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM hospedaje WHERE idHospedaje = ?");			          

			$stm->execute(array($idHospedaje));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

public function EliminarResumenDiario($idHospedaje)
{
    try 
    {
        // Si viene como objeto, extraemos el idHospedaje
        if (is_object($idHospedaje)) {
            $idHospedaje = $idHospedaje->idHospedaje;
        }

        $sql = "DELETE FROM resumenhospedaje 
                WHERE idHospedaje = ? 
                AND fechaR = CURDATE()";

        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idHospedaje]);

    } catch (Exception $e) 
    {
        die($e->getMessage());
    }
}










}



?>
