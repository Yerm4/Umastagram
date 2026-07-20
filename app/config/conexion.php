<?php
namespace app\config;

use \PDO;
use \PDOException;

class Conexion {
    
    public static function conectar () {
        
        $host = "localhost";
        $db = "uma";
        $user = "root";
        $password = "";
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        
        catch (PDOException $e) {
            die("Error en la conexion a la base de datos");
        }
    }
}