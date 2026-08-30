<?php
declare(strict_types=1);
namespace app\controller;

use app\model\Model;

class ViewController {
    
    private $pdo;

    public function __construct($database) {
        $this->pdo = $database;
    }

    public function showHome($partesRuta = null) {
        $model = new Model($this->pdo);
        $userId = $_SESSION["user_id"] ?? null;
        $resultado = $model->getAllPosts($userId);
        $titulo = "Muro";
        include_once __DIR__."/../view/layout/header.php";
        include_once __DIR__."/../view/home.php";
    }

    public function showProfile($partesRuta = null) {
        $user = $partesRuta[1] ?? "Uma Musume";
        $userId = $_SESSION["user_id"] ?? null;

        if (!empty($partesRuta[1])) {
            $model = new Model($this->pdo);
            $userData = $model->getUser($user);
            $postsData = $model->getPosts($user, $userId);
            $titulo = ucfirst($user);
            
            if ($userData["status"] === "ok" && $postsData["status"] === "ok") {
                $user = $userData["data"];
                $posts = $postsData["data"];
                include_once __DIR__."/../view/layout/header.php";
                include_once __DIR__."/../view/perfil.php";
            }

            else {
                $this->show404();
            }
        }

        else {
            $this->show404();
        }
    }

    public function showPost($partesRuta = null) {
        $postId = $partesRuta[1] ?? null;
        $userId = $_SESSION["user_id"] ?? null;

        if (!empty($partesRuta[1])) {
            $model = new Model($this->pdo);
            $postData = $model->getPost($postId, $userId);

            if ($postData["status"] === "ok") {
                $post = $postData["data"];
                $commentData = $model->getComment($postId);
                $comments = ($commentData["status"] === "ok") ? $commentData["data"] : [];
                $titulo = ucfirst($post["username"])." post";
                include_once __DIR__."/../view/layout/header.php";
                include_once __DIR__."/../view/post.php";
            }
            else {
                $this->show404();
            }
        }

        else {
            $this->show404();
        }

    }

    public function showEstablo($partesRuta = null) {
        $titulo = "Establo";
        include_once __DIR__."/../view/layout/header.php";
        include_once __DIR__."/../view/establo.php";
    }

    private function show404() {
        $titulo = "404";
        include_once __DIR__."/../view/layout/header.php";
        include_once __DIR__."/404.php";
        exit();
    }
}