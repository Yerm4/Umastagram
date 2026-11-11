<?php
namespace app\config;

use PDO;
use PDOException;

class Database {
    private static $pdo = null;

    public static function conectar () {

        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $host = $_ENV["DB_HOST"];
        $db   = $_ENV["DB_NAME"];
        $user = $_ENV["DB_USER"];
        $password = $_ENV["DB_PASSWORD"];
        
        try {
            self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$pdo;
        } catch (PDOException $e) {
            die("Error en la conexion a la base de datos");
        }
    }
}