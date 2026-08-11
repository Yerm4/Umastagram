<?php
namespace app\config;

use \PDO;
use \PDOException;

class Conexion {
    
    public static function conectar () {

        $host = $_ENV['DB_HOST'];
        $db   = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        
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