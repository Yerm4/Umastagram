<?php
namespace app\model;

use PDO;
use PDOException;

class Model {
    private $pdo;

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    private function response($status, $message = "", $data = null, $redirect = null) {
            return    [
            "status" => $status,
            "message" => $message,
            "data" => $data,
            "redirect" => $redirect
            ];
    }

    public function login($username) {
        try {
            $sql = "SELECT id, username, password, fav_uma FROM users WHERE username = :username LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                "username" => $username
            ]);
        
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($user) {
                return $this->response("ok", "", $user);
            } else {
                return $this->response("error", "No existe un usuario con ese nombre");
            }
        
        } catch (PDOException $e) {
            return $this->response("error", "Error en la consulta");
        }
    }

    public function signup ($username, $password, $favUma) {
        try {
            $stmtCheck = $this->pdo->prepare("SELECT EXISTS
            (SELECT 1 FROM users 
            WHERE username = :username)");
            $stmtCheck->execute([
                "username" => $username
            ]);
            $exists = (bool)$stmtCheck->fetchColumn();

            if (!$exists) {
                $stmt = $this->pdo->prepare("INSERT INTO users (username, password, fav_uma) 
                VALUES (:username, :password, :favUma)");
                $stmt->execute([
                "username" => $username,
                "password" => $password,
                "favUma" => $favUma
                ]);

                return $this->response("ok", "", ["id" => $this->pdo->lastInsertId()]);
            }

            else {
                return $this->response("error", "Ya existe un usuario registrado con ese nombre");
            }
        } catch (PDOException $e) {
            return $this->response("error", "Error en la consulta");
        }
    }

    public function getAllPosts() {
        try {
            $stmt = $this->pdo->prepare("SELECT p.id, p.title, p.content, p.likes, p.date, p.post_img, u.username, u.fav_uma,
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS total_comments
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            ORDER BY date DESC
            LIMIT 10");
            $stmt->execute();
            return $this->response("ok", "", $stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return $this->response("error", $e);
        }
    }

    public function getUser($username) {
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, fav_uma, signup_date FROM users WHERE username = :username");
            $stmt->execute([
                "username" => $username
            ]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data) {
                return $this->response("error", "No se encontro ese usuario");
            }

            return $this->response("ok", "Perfil enviado", $data);
        } catch (PDOException $e) {
            $this->response("error", $e);
        }
    }

    public function getPosts($username) {
        try {
            $stmt = $this->pdo->prepare("SELECT p.id, p.title, p.content, p.likes, p.date, p.post_img, u.username, u.fav_uma,
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS total_comments
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            WHERE u.username = :username
            ORDER BY p.date DESC
            LIMIT 10");
            $stmt->execute([
                "username" => $username
            ]);
            return $this->response("ok", "", $stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return $this->response("error", "Error en la consulta");
        }
    }

    public function getPost($postId) {
        try {
            $stmt = $this->pdo->prepare("SELECT p.id, p.title, p.content, p.likes, p.date, p.post_img, u.username, u.fav_uma,
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS total_comments
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            WHERE p.id = :postId");
            
            $stmt->execute([
                "postId" => $postId
            ]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$data) {
                return $this->response("error", "No existe ese post");
            }
            return $this->response("ok", "", $data);
        } catch (PDOException $e) {
            return $this->response("error", $e->getMessage()); // Es mejor pasar $e->getMessage() para no romper el json
        }
    }

    public function getComment($postId) {
        try {
            $stmt = $this->pdo->prepare("SELECT c.id, c.id, c.post_id, c.user_id, c.content, c.img, c.date, u.username, u.fav_uma
            FROM comments c
            INNER JOIN users u ON c.user_id = u.id
            WHERE post_id = :postId
            ORDER BY c.date DESC");
            $stmt->execute([
                "postId" => $postId]
            );
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$data) {
                return $this->response("error", "No hay comentarios");
            }
            return $this->response("ok", "", $data);
        } catch (PDOException $e) {
            return $this->response("error", $e);
        }
    }

    public function createPost($userId, $title, $content, $postImg) {
        try {
            $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM posts WHERE user_id = :userId AND date >= NOW() - INTERVAL 5 MINUTE");
            $stmtCheck->execute([
                "userId" => $userId
            ]);
            $date = $stmtCheck->fetchColumn();

            if (!$date > 0) {
                $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, title, content, post_img) VALUES (:userId, :title, :content, :post_img)");
                $stmt->execute([
                "userId" => $userId,
                "title" => $title,
                "content" => $content,
                "post_img" => $postImg
                ]);
                $newPostId = $this->pdo->lastInsertId();

                if ($newPostId) {
                    $stmt = $this->pdo->prepare("
                    SELECT p.*, u.username, u.fav_uma
                    FROM posts p
                    INNER JOIN users u ON p.user_id = u.id
                    WHERE p.id = :id");
                    $stmt->execute([
                        "id" => $newPostId
                    ]);
                    return $this->response("ok", "", $stmt->fetch(PDO::FETCH_ASSOC));
                }
            } else {
                return $this->response("error", "Publicaste hace menos de 5 minutos");
            }
        } catch (PDOException $e) {
            return $this->response("error", "");
        }
    }

    public function createLike ($userId, $postId) {
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
            $likes = $stmt3->fetchColumn();

            $this->pdo->commit();
            return $this->response("ok", "Like enviado correctamente", $likes);
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return $this->response("error", "Error en la consulta");
        }
    }

    public function createComment($postId, $userId, $content, $img = null) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO comments
            (post_id, user_id, content) VALUES (:postId, :userId, :content)");
            $stmt->execute([
                "postId" => $postId,
                "userId" => $userId,
                "content" => $content
            ]);
            $lastId = $this->pdo->lastInsertId();

            if (!$lastId) {
                return $this->response("error", "Error al enviar el comentario");    
            }
            
            $stmt = $this->pdo->prepare("SELECT c.*, u.username, u.fav_uma
                FROM comments c
                INNER JOIN users u ON c.user_id = u.id
                WHERE c.id = :id");
                $stmt->execute(["id" => $lastId]);
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->response("ok", "Comentario enviado", $resultado);
        } catch (PDOException $e) {
            return $this->response("error", $e);
        }
    }

    public function postExists($postId) {
        $stmt = $this->pdo->prepare("SELECT EXISTS (SELECT 1 FROM posts WHERE id = :postId)");
        $stmt->execute(["postId" => $postId]);
        $exists = (bool)$stmt->fetchColumn();

        if (!$exists) return $this->response("error", "No existe esa publicacion");

        return $this->response("ok", "Sí existe esa publicacion");
    }
}