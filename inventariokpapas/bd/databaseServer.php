<?php
class DatabaseLocal
{
    public static function ConectarLocal()
    {
        $pdo = new PDO('mysql:host=10.0.3.1:3306;dbname=kpapas;charset=utf8', 'kpapas', 'chile2023$');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        return $pdo;
    }
}



?>