<?php
declare(strict_types=1);
namespace app\controller;

use app\model\Model;

class ViewController {

    public function showHome($pathExploited = null) {
        $model = new Model();
        $userId = $_SESSION["user_id"] ?? null;
        $resultado = $model->getAllPosts($userId);
        $titulo = "Muro";
        include_once __DIR__."/../view/layout/header.php";
        include_once __DIR__."/../view/home.php";
    }

    public function showProfile($pathExploited = null) {
        $user = $pathExploited[1] ?? "Uma Musume";
        $userId = $_SESSION["user_id"] ?? null;

        if (!empty($pathExploited[1])) {
            $model = new Model();
            $userData = $model->getUser($user);
            $postsData = $model->getPosts($user, $userId);
            $titulo = ucfirst($user);
            
            if ($userData["status"] === "ok" && $postsData["status"] === "ok") {
                $user = $userData["data"];
                $posts = $postsData["data"];
                include_once __DIR__."/../view/layout/header.php";
                include_once __DIR__."/../view/profile.php";
            }

            else {
                $this->show404();
            }
        }

        else {
            $this->show404();
        }
    }

    public function showPost($pathExploited = null) {
        $postId = $pathExploited[1] ?? null;
        $userId = $_SESSION["user_id"] ?? null;

        if (!empty($pathExploited[1])) {
            $model = new Model();
            $postData = $model->getPost($postId, $userId);

            if ($postData["status"] === "ok") {
                $post = $postData["data"];
                $commentData = $model->getComment($postId);
                $comments = ($commentData["status"] === "ok") ? $commentData["data"] : [];
                $titulo = "Publicación de ".ucfirst($post["username"]);
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

    public function showStable($pathExploited = null) {
        $titulo = "Establo";
        include_once __DIR__."/../view/layout/header.php";
        include_once __DIR__."/../view/stable.php";
    }

    private function show404() {
        $titulo = "404";
        include_once __DIR__."/../view/layout/header.php";
        include_once __DIR__."/404.php";
        exit();
    }
}