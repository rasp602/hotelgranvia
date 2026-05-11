<?php
class Database
{
    public static function Conectar()
    {
        //$pdo = new PDO('mysql:host=152.172.39.88;dbname=hoteleria;charset=utf8', 'hotel', 'chile2023$');
		$pdo = new PDO('mysql:host=srv1056.hstgr.io;dbname=u854084565_hoteleria;charset=utf8', 'u854084565_rasp602', 'Rodri2410$');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        return $pdo;
    }
}
/*
class Database
{
    public static function Conectar()
    {
        $pdo = new PDO('mysql:host=200.74.49.175;dbname=hoteleria;charset=utf8', 'hotel', 'chile2023$');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        return $pdo;
    }
}*/

  

/*
class DB{
	var $conect;
  
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	function DB(){
		$this->BaseDatos = "hoteleria";
		$this->Servidor = "localhost";
		$this->Usuario = "root";
		$this->Clave = "";
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
} */?>