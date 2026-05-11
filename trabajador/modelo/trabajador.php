<?php
class Trabajador
{
	private $pdo;

    
    public $idTrabajador;
    public $rutTrabajador;
    public $nombreTrabajador;
    public $apellidoTrabajador1;
    public $apellidoTrabajador2;
    public $fechaCreado;
    public $fotoTrabajador;
    public $qrTrabajador;
    public $genero;
    public $horaCreado;
    public $idHotel;
    public $estado;
    public $fechaIngreso;
    public $labor;
    public $jornada;
    public $diasTrabajado;
    public $sueldo;
    public $condicion;
	public $tipo_evento;

	public $fichaPersonal;
public $curriculum;
public $carnet;
public $certificadoAfp;
public $fonasa;
public $ultimoFiniquito;


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

	public function ListarTrabajador()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM trabajador ORDER BY idTrabajador");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Trabajador()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM trabajador");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function ValidarCondicion($data)
	{
		try 
		{

			$sql = "UPDATE trabajador SET 

				    condicion = ?

			       WHERE idTrabajador = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->condicion,
                   $data->idTrabajador
				                                              
					)
				);
		} catch (Exception $e) 
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




	public function Obtener($idTrabajador)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM trabajador
        WHERE idTrabajador = ?;");
			          
			$stm->execute(array($idTrabajador));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerRut($rutTrabajador)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM trabajador
        WHERE rutTrabajador = ?;");
			          
			$stm->execute(array($rutTrabajador));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerNombre($idTrabajador)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM trabajador
        WHERE idTrabajador = ?;");
			          
			$stm->execute(array($idTrabajador));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerID($rutTrabajador)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM trabajador
        WHERE rutTrabajador = ?;");
			          
			$stm->execute(array($rutTrabajador));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function RegistrarTrabajador(Trabajador $data)
	{
		try 
		{


		$sql = "INSERT INTO trabajador (idTrabajador, rutTrabajador, nombreTrabajador, apellidoTrabajador1, apellidoTrabajador2, fechaCreado, fotoTrabajador, qrTrabajador,genero,horaCreado,idHotel,estado,fechaIngreso,labor,jornada,diasTrabajo,sueldo,condicion) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idTrabajador = NULL,	
				   $data->rutTrabajador,
				   $data->nombreTrabajador,
				   $data->apellidoTrabajador1,
				   $data->apellidoTrabajador2,
				   $data->fechaCreado,
				   $data->fotoTrabajador,
				   $data->qrTrabajador,
				   $data->genero,
				   $data->horaCreado,
				   $data->idHotel,
				   $data->estado,
				   $data->fechaIngreso,
				   $data->labor,
				   $data->jornada,
				   $data->diasTrabajo,
				   $data->sueldo,
				   $data->condicion,
                )
			);
					  	
		  	$ste= "INSERT INTO tblusuario (idUsuario,rut,nombre,apellido,fechacrea,genero) VALUES (?, ?, ?, ?, ?, ?)";


			$this->pdo->prepare($ste)
		     ->execute(
				array(
				   $data->idUsuario=Null,	
				   $data->rutTrabajador,
				   $data->nombreTrabajador,
		           $data->apellidoTrabajador1,
		           $data->fechaIngreso,
		           $data->genero,
                   
                )
                );
	$dato=$this->lafuncionTrabajador();
$dato1=$this->lafuncionTrabajador1();
		  	
		  	$te= "INSERT INTO usuario (id_user,email,password,nivel,idUsuario,idTrabajador) VALUES (?, ?,?,?,'".$dato[0]."','".$dato1[0]."')";


			$this->pdo->prepare($te)
		     ->execute(
				array(
				   $data->id_user=Null,	
				   $data->rutTrabajador,
				   $data->password="8cb2237d0679ca88db6464eac60da96345513964",
				   $data->nivel="T",
				  
          
                   
                )
                );

	return $lafuncionTrabajador; 
	return $lafuncionTrabajador1; 



		} catch (Exception $e) 
		{
			die($e->getMessage());
		}



		
	}

	public function RegistrarDescanso(Trabajador $data)
	{
		try 
		{


		$sql = "INSERT INTO eventoscalendar (idTrabajador, evento, fecha_inicio, fecha_fin, color_evento,tipo_evento) 
		        VALUES (?, ?, ?, ?, ?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				  	
				   $data->idTrabajador,	
				   $data->evento,
				   $data->fecha_inicio,
				   $data->fecha_fin,
				   $data->color_evento,
				   $data->tipo_evento,
				
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}

public function ActualizarT($data)
	{
		try 
		{
			$sql = "UPDATE trabajador SET 

				    rutTrabajador = ?,
				    nombreTrabajador = ?,
				    apellidoTrabajador1 = ?,
				    apellidoTrabajador2 = ?,
				    fechaCreado = ?,
				    fotoTrabajador = ?,
				    genero = ?,
				    horaCreado = ?,
				    qrTrabajador = ?,
				    idHotel = ?,
				    estado = ?,
				    fechaIngreso = ?,
				    labor = ?,
				    jornada = ?,
				    diasTrabajo =?,
				    sueldo =?
			       WHERE idTrabajador = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
                   $data->rutTrabajador,
                   $data->nombreTrabajador,
                   $data->apellidoTrabajador1,
                   $data->apellidoTrabajador2,
                   $data->fechaCreado,
                   $data->fotoTrabajador,
                   $data->genero,
                   $data->horaCreado,
                   $data->qrTrabajador,
                   $data->idHotel,
                   $data->estado,
				   $data->fechaIngreso,
				   $data->labor,
				   $data->jornada,
				   $data->diasTrabajo,
				   $data->sueldo,
                   $data->idTrabajador
                   

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

			$sql = "UPDATE trabajador SET 

				    qrTrabajador = ?

			       WHERE idTrabajador = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
               		
                   $data->qrTrabajador,
                   $data->idTrabajador
				                                              
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idTrabajador)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM trabajador WHERE idTrabajador = ?");			          

			$stm->execute(array($idTrabajador));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function EliminarEntradas($idTrabajador)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM entradat WHERE idTrabajador = ?");			          

			$stm->execute(array($idTrabajador));
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

	public function lafuncionTrabajador()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idUsuario)  as 'valor' FROM tblusuario");

			     	$stm->execute(array($idUsuario));
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}

	public function lafuncionTrabajador1()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idTrabajador)  as 'valor1' FROM trabajador");

			     	$stm->execute(array($idTrabajador));
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}

	public function ObtenerDocumentos($idTrabajador)
{
    try {
        $stm = $this->pdo->prepare("SELECT * FROM documentos_trabajador WHERE idTrabajador = ?");
        $stm->execute(array($idTrabajador));
        return $stm->fetch(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

public function GuardarDocumentos(Trabajador $data)
{
    try {
        $existe = $this->ObtenerDocumentos($data->idTrabajador);

        if ($existe) {
            $sql = "UPDATE documentos_trabajador SET
                        fichaPersonal = ?,
                        curriculum = ?,
                        carnet = ?,
                        certificadoAfp = ?,
                        fonasa = ?,
                        ultimoFiniquito = ?
                    WHERE idTrabajador = ?";

            $this->pdo->prepare($sql)->execute(array(
                $data->fichaPersonal,
                $data->curriculum,
                $data->carnet,
                $data->certificadoAfp,
                $data->fonasa,
                $data->ultimoFiniquito,
                $data->idTrabajador
            ));
        } else {
            $sql = "INSERT INTO documentos_trabajador
                    (idTrabajador, fichaPersonal, curriculum, carnet, certificadoAfp, fonasa, ultimoFiniquito)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $this->pdo->prepare($sql)->execute(array(
                $data->idTrabajador,
                $data->fichaPersonal,
                $data->curriculum,
                $data->carnet,
                $data->certificadoAfp,
                $data->fonasa,
                $data->ultimoFiniquito
            ));
        }

    } catch (Exception $e) {
        die($e->getMessage());
    }
}

public function ContarDocumentos($idTrabajador)
{
    try {
        $stm = $this->pdo->prepare("SELECT * FROM documentos_trabajador WHERE idTrabajador = ?");
        $stm->execute(array($idTrabajador));
        $doc = $stm->fetch(PDO::FETCH_OBJ);

        if (!$doc) return 0;

        $contador = 0;

        if (!empty($doc->fichaPersonal)) $contador++;
        if (!empty($doc->curriculum)) $contador++;
        if (!empty($doc->carnet)) $contador++;
        if (!empty($doc->certificadoAfp)) $contador++;
        if (!empty($doc->fonasa)) $contador++;
        if (!empty($doc->ultimoFiniquito)) $contador++;

        return $contador;

    } catch (Exception $e) {
        die($e->getMessage());
    }
}



}



?>
