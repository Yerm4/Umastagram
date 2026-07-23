<?php
namespace app\models;

use PDO;
use PDOException;

class Model {
    private $pdo;

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function login($username) {
        try {
            $sqlCheck = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->execute([
                "username" => $username
            ]);
            $exists = $stmtCheck->fetchColumn();
            if ($exists > 0) {
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                "username" => $username
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

    public function signUp ($username, $password, $favUma) {
        
        try {
            $sqlCheck = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->execute([
                "username" => $username
            ]);
            $exists = (int)$stmtCheck->fetchColumn();

            if ($exists === 0) {
                $sql = "INSERT INTO users (username, password, fav_uma) VALUES (:username, :password, :favUma)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                "username" => $username,
                "password" => $password,
                "favUma" => $favUma
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

    public function publicar($user_id, $title, $content) {
        try {
            $sql = "INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                "user_id" => $user_id,
                "title" => $title,
                "content" => $content
            ]);

            return [
                "status" => "ok",
                "data" => $this->pdo->lastInsertId()
            ];
        }

        catch (PDOException $e) {
            return [
                "status" => "error",
                "data" => ""
            ];
        }
    }

    public function consultarPublicaciones() {
        try {
            $sql = "SELECT p.*,
                u.username,
                u.fav_uma
                FROM posts p
                INNER JOIN users u ON p.user_id = u.id
                ORDER BY date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return [
            "status" => "ok",
            "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)  
        ];
        }

        catch (PDOException $e) {
            return [
                "status" => "error",
                "data" => $e
            ];  
        }
    }

    public function actualizarLikes ($postId, $userId) {
        $sql = "INSERT INTO post_likes (user_id, id_publicacion) VALUES (:user_id, :id_publicacion)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "user_id" => $userId,
            "id_publicacion" => $postId
        ]);

        return $sql = "SELECT COUNT(*) post_likes (user_id, id_publicacion) VALUES (:user_id, :id_publicacion)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "user_id" => $userId,
            "id_publicacion" => $postId
        ]);
    }
}