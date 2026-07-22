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
            $sqlCheck = "SELECT COUNT(*) FROM usuarios WHERE nombre = :nombre";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->execute([
                "nombre" => $nombreUsuario
            ]);
            $existe = (int)$stmtCheck->fetchColumn();

            if ($existe === 0) {
                $sql = "INSERT INTO usuarios (nombre, password, uma_fav) VALUES (:nombre, :password, :umaFav)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                "nombre" => $nombreUsuario,
                "password" => $password,
                "umaFav" => $umaFav
                ]);
                return [
                    "status" => "ok",
                    "data" => $this->pdo->lastInsertId()
                ];
            }

            else {
                return [
                    "status" => "error",
                    "data" => "Ya existe un usuario registrado con ese nombre"
                ];
            }
        }

        catch (PDOException $e) {
            return  [
                "status" => "error",
                "data" => $e
            ];
        }
    }

    public function login($nombreUsuario) {
        try {
            $sqlCheck = "SELECT COUNT(*) FROM usuarios WHERE nombre = :nombre";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->execute([
                "nombre" => $nombreUsuario
            ]);
            $existe = $stmtCheck->fetchColumn();
            if ($existe > 0) {
                $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                "nombre" => $nombreUsuario
                ]);
                return [
                    "status" => "ok",
                    "data" => $stmt->fetch(PDO::FETCH_ASSOC)
                ];
            }

            else {
                return [
                    "status" => "error",
                    "data" => "No existe un usuario con ese nombre"
                ];
            }
        }
        
        catch (PDOException $e) {
            return  [
                "status" => "error",
                "data" => $e
            ];
        }
    }

    public function publicar($id_usuario, $contenido) {
        try {
            $sql = "INSERT INTO publicaciones (id_usuario, contenido) VALUES (:id_usuario, :contenido)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                "id_usuario" => $id_usuario,
                "contenido" => $contenido
            ]);

            return [
                "status" => "ok",
                "data" => $this->pdo->lastInsertId()
            ];
        }

        catch (PDOException $e) {
            return [
                "status" => "error",
                "data" => $e
            ];
        }
    }

    public function consultarPublicaciones() {
        $sql = "SELECT p.*,
                u.nombre AS nombre_usuario,
                u.uma_fav
                FROM publicaciones p
                INNER JOIN usuarios u ON p.id_usuario = u.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return [
            "status" => "ok",
            "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)  
        ];
    }
}