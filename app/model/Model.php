<?php
declare(strict_types=1);
namespace app\model;

use PDO;
use PDOException;
use app\model\BaseModel;

class Model extends BaseModel {

    private function postExists(?int $postId) : bool {
        if ($postId === null) return false;
        $stmt = $this->pdo->prepare("SELECT EXISTS (SELECT 1 FROM posts WHERE id = :postId)");
        $stmt->execute(["postId" => $postId]);
        return (bool)$stmt->fetchColumn();
    }

    private function userExists($userId) : bool {
        if ($userId === null) return false;
        $stmt = $this->pdo->prepare("SELECT EXISTS (SELECT 1 FROM users WHERE id = :userId AND deleted_at IS NULL)");
        $stmt->execute(["userId" => $userId]);
        return (bool)$stmt->fetchColumn();
    }

    public function login($username) {
        try {
            $sql = "SELECT id, username, password, fav_uma FROM users WHERE username = :username LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(["username" => $username]);
        
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ? $user : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function signup($username, $password, $favUma) {
        try {
            $stmtCheck = $this->pdo->prepare("SELECT EXISTS (SELECT 1 FROM users WHERE username = :username)");
            $stmtCheck->execute(["username" => $username]);
            $exists = (bool)$stmtCheck->fetchColumn();

            if (!$exists) {
                $stmt = $this->pdo->prepare("INSERT INTO users (username, password, fav_uma) VALUES (:username, :password, :favUma)");
                $stmt->execute([
                    "username" => $username,
                    "password" => $password,
                    "favUma" => $favUma
                ]);

                return ["id" => (int)$this->pdo->lastInsertId()];
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUser($username) {
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, fav_uma, signup_date FROM users WHERE username = :username");
            $stmt->execute(["username" => $username]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $data ? $data : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllPosts($userId = null) {
        try {
            $stmt = $this->pdo->prepare("SELECT p.id, p.title, p.content, p.likes, p.date, p.post_img, u.username, u.fav_uma,
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS total_comments,
            (EXISTS (SELECT 1 FROM posts_likes l WHERE :userId IS NOT NULL AND l.user_id = :userId AND p.id = l.post_id)) AS hasLiked
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            ORDER BY p.date DESC
            LIMIT 10");
            $stmt->execute(["userId" => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getPosts($username, $userId = null) {
        try {
            $stmt = $this->pdo->prepare("SELECT p.id, p.title, p.content, p.likes, p.date, p.post_img, u.username, u.fav_uma,
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS total_comments,
            (EXISTS (SELECT 1 FROM posts_likes l WHERE :userId IS NOT NULL AND l.user_id = :userId AND p.id = l.post_id)) AS hasLiked
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            WHERE u.username = :username
            ORDER BY p.date DESC
            LIMIT 10");
            $stmt->execute(["username" => $username, "userId" => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getPost($postId, $userId = null) {
        try {
            $stmt = $this->pdo->prepare("SELECT p.id, p.title, p.content, p.likes, p.date, p.post_img, u.username, u.fav_uma,
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS total_comments,
            (EXISTS (SELECT 1 FROM posts_likes l WHERE :userId IS NOT NULL AND l.user_id = :userId AND p.id = l.post_id)) AS hasLiked
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            WHERE p.id = :postId");
            
            $stmt->execute(["postId" => $postId, "userId" => $userId]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $data ? $data : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getComment($postId) {
        try {
            $stmt = $this->pdo->prepare("SELECT c.id, c.post_id, c.user_id, c.content, c.img, c.date, u.username, u.fav_uma
            FROM comments c
            INNER JOIN users u ON c.user_id = u.id
            WHERE post_id = :postId
            ORDER BY c.date DESC");
            $stmt->execute(["postId" => $postId]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data ? $data : [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function createPost($userId, $title, $content, $postImg) {
        try {
            $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM posts WHERE user_id = :userId AND date >= NOW() - INTERVAL 5 MINUTE");
            $stmtCheck->execute(["userId" => $userId]);
            $hasPostedRecently = (bool)$stmtCheck->fetchColumn();

            if (!$hasPostedRecently) {
                $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, title, content, post_img) VALUES (:userId, :title, :content, :post_img)");
                $stmt->execute([
                    "userId" => $userId,
                    "title" => $title,
                    "content" => $content,
                    "post_img" => $postImg
                ]);
                $newPostId = $this->pdo->lastInsertId();

                if ($newPostId) {
                    $stmt = $this->pdo->prepare("SELECT p.*, u.username, u.fav_uma
                    FROM posts p
                    INNER JOIN users u ON p.user_id = u.id
                    WHERE p.id = :id");
                    $stmt->execute(["id" => $newPostId]);
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function toggleLike($userId, $postId) {
        try {
            $exists = $this->postExists($postId);
            if (!$exists) return false;

            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT EXISTS 
            (SELECT 1 FROM posts_likes 
            WHERE user_id = :userId 
            AND post_id = :postId)");
            $stmt->execute(["userId" => $userId, "postId" => $postId]);
            $hasLiked = (bool)$stmt->fetchColumn();
            
            if (!$hasLiked) {
                $stmt = $this->pdo->prepare("INSERT INTO posts_likes (user_id, post_id) VALUES (:userId, :postId)");
                $stmt->execute(["userId" => $userId, "postId" => $postId]);

                $stmt = $this->pdo->prepare("UPDATE posts SET likes = likes + 1 WHERE id = :postId");
                $stmt->execute(["postId" => $postId]);
                $like = true;
            } else {
                $stmt = $this->pdo->prepare("DELETE FROM posts_likes WHERE user_id = :userId AND post_id = :postId");
                $stmt->execute(["userId" => $userId, "postId" => $postId]);

                $stmt = $this->pdo->prepare("UPDATE posts SET likes = GREATEST(0, likes - 1) WHERE id = :postId");
                $stmt->execute(["postId" => $postId]);
                $like = false;
            }
            $stmt = $this->pdo->prepare("SELECT likes FROM posts WHERE id = :postId");
            $stmt->execute(["postId" => $postId]);
            $likes = (int)$stmt->fetchColumn();

            $this->pdo->commit();
            return ["likes" => $likes, "like" => $like];
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
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
                return false;    
            }
            
            $stmt = $this->pdo->prepare("SELECT c.*, u.username, u.fav_uma
                FROM comments c
                INNER JOIN users u ON c.user_id = u.id
                WHERE c.id = :id");
            $stmt->execute(["id" => $lastId]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado ? $resultado : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function sendFriendRequest($userIdSends, $userIdReceives) {
        try {
            $exists = $this->userExists($userIdReceives);
            if (!$exists) return false;    

            $stmt = $this->pdo->prepare("SELECT EXISTS
            (SELECT 1 FROM friends 
            WHERE (user_id_sends = :idSends AND user_id_receives = :idReceives)
            OR (user_id_sends = :idReceives AND user_id_receives = :idSends))");
            $stmt->execute(["idSends" => $userIdSends, "idReceives" => $userIdReceives]);

            if ((bool)$stmt->fetchColumn()) {
                return false;
            }    
            $stmt = $this->pdo->prepare("INSERT INTO friends
            (user_id_sends, user_id_receives, status_id) VALUES (:idSends, :idReceives, 1)");
            $stmt->execute(["idSends" => $userIdSends, "idReceives" => $userIdReceives]);
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    public function answerFriendRequest($currentUserId, $senderUserId, $accept = true) {
        try {
            $stmt = $this->pdo->prepare("SELECT id FROM friends
            WHERE user_id_sends = :senderId
            AND user_id_receives = :currentId
            AND status_id = 1");
            $stmt->execute(["senderId" => $senderUserId, "currentId" => $currentUserId]);
            $request = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$request) return false;
            $id = $request["id"];
            if ($accept) {
                $stmt = $this->pdo->prepare("UPDATE friends SET status_id = 2 WHERE id = :id");
                $stmt->execute(["id" => $id]);
            } else {
                $stmt = $this->pdo->prepare("DELETE FROM friends WHERE id = :id");
                $stmt->execute(["id" => $id]);
            }

            return true;
        } catch(PDOException $e) {
            return false;
        }
    }
}