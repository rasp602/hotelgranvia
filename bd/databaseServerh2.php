<?php
class DatabaseRemoteh2
{
    public static function ConectarRemoteh2()
    {
        $pdo = new PDO('mysql:host=190.100.92.10;dbname=hoteleria;charset=utf8', 'rasph2', 'Rodri2410$');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        return $pdo;
    }
}

/*
class DatabaseLocal
{
    public static function ConectarLocal()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=u410124118_hoteleria;charset=utf8', 'u410124118_rasp602', 'Rodrigo2410$');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        return $pdo;
    }
}
*/









/*
class DB{
	var $conect;
  
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	function DB(){
		$this->BaseDatos = "u410124118_hoteleria";
		$this->Servidor = "localhost";
		$this->Usuario = "u410124118_rasp";
		$this->Clave = "Rodrigo2410$";
	}

	 function conectar() {
		if(!($con=@mysql_connect($this->Servidor,$this->Usuario,$this->Clave))){
			echo"<h1> [:(] Error al conectar a la base de datos</h1>";	
			exit();
		}
		if (!@mysql_select_db($this->BaseDatos,$con)){
			echo "<h1> [:(] Error al seleccionar la base de datos</h1>";  
			exit();
		}
		$this->conect=$con;
		return true;	
	}
} 
*/
?>