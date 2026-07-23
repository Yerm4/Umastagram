<?php
namespace app\models;

use DateTime;
use PDO;
use PDOException;

class Model {
    private $pdo;

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    private function jsonResponse($status, $message = "", $data = null, $redirect = null) {
            return    [
            "status" => $status,
            "message" => $message,
            "data" => $data,
            "redirect" => $redirect
            ];
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

                return $this->jsonResponse("ok", "", $stmt->fetch(PDO::FETCH_ASSOC));
                
            }

            else {
                return $this->jsonResponse("error", "No existe un usuario con ese nombre");
            }
        }
        
        catch (PDOException $e) {
            return $this->jsonResponse("error", "Error en la consulta");
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

                return $this->jsonResponse("ok", "", $this->pdo->lastInsertId());
            }

            else {
                return $this->jsonResponse("error", "Ya existe un usuario registrado con ese nombre");
            }
        }

        catch (PDOException $e) {
            return $this->jsonResponse("error", "Error en la consulta");
        }
    }

    public function publicar($user_id, $title, $content) {
        try {
            $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM posts WHERE user_id = :user_id AND date >= NOW() - INTERVAL 5 MINUTE");
            $stmtCheck->execute([
                "user_id" => $user_id
            ]);
            $date = $stmtCheck->fetchColumn();

            if (!$date > 0) {
                $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)");
                $stmt->execute([
                "user_id" => $user_id,
                "title" => $title,
                "content" => $content
                ]);
                return $this->jsonResponse("ok", "", $this->pdo->lastInsertId());
            } else {
                return $this->jsonResponse("error", "Publicaste hace menos de 5 minutos");
            }
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

    public function actualizarLikes ($userId, $postId) {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("INSERT INTO posts_likes (user_id, post_id) VALUES (:user_id, :post_id)");
            $stmt->execute([
                "user_id" => $userId,
                "post_id" => $postId
            ]);
            $stmt2 = $this->pdo->prepare("UPDATE posts SET likes = likes + 1 WHERE id = :post_id");
            $stmt2->execute([
                "post_id" => $postId
            ]);
            
            $stmt3 = $this->pdo->prepare("SELECT likes FROM posts WHERE id = :post_id");
            $stmt3->execute([
                "post_id" => $postId
            ]);
            $likes = $stmt3->fetch();

            $this->pdo->commit();
            return [
                "status" => "ok",
                "message" => "Like enviado correctamente",
                "data" => $likes["likes"]
            ];

            
        }

        catch (PDOException $e) {
            $this->pdo->rollBack();
            return [ 
                "status" => "error",
                "message" => $e
            ];
        }
    }
}