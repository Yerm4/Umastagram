<?php
namespace app\models;

use PDO;
use PDOException;

class Usuario {
    private $pdo;

    public function __construct($conexion) {
        $this->pdo = $conexion;
    }

    public function registro ($nombreUsuario, $password, $umaFav) {
        
        try {
            $sql = "INSERT INTO usuarios (nombre, password, uma_fav) VALUES (:nombre, :password, :umaFav)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
            "nombre" => $nombreUsuario,
            "password" => $password,
            "umaFav" => $umaFav
        ]);

        return $this->pdo->lastInsertId();
        }

        catch (PDOException $e) {
            return false;
        }
    }

    public function login($nombreUsuario, $password) {
        try {
            $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
            "nombre" => $nombreUsuario
        ]);
        
        return $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        catch (PDOException $e) {
            return false;
        }
    }
}