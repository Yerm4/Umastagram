<?php
namespace app\controller;

use app\model\Model;
use app\controller\BaseController;

class AuthController extends BaseController {

    public function login() {
        $data = $this->getData();

        $username = cleanValue($data, "username");
        $password = cleanValue($data, "password");
        
        if (empty($username) || empty($password)) {
            code(400);
            $this->jsonResponse("error", "Parece que intentaste enviar un campo vacío");
            return;
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            code(400);
            $this->jsonResponse("error", "La contraseña no puede ser menor a 8 caracteres");
            return;
        }

        if (strlen($username) < 3 || strlen($username) > 20) {
            code(400);
            $this->jsonResponse("error", "Tu nombre no puede ser menor a 3 caracteres");
            return;
        }

        $usuarioModel = new Model();
        $userData = $usuarioModel->login($username);

        if ($userData) {
            if (password_verify($password, $userData["password"])) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $userData["id"];
                $_SESSION["username"] = $userData["username"];
                $_SESSION["fav_uma"] = $userData["fav_uma"];
                $this->jsonResponse("ok", "Inicio de sesión exitoso, redirigiendo..", null, "home");
            } else {
                code(401);
                $this->jsonResponse("error", "La contraseña no coincide");
            }
        } else {
            code(400);
            $this->jsonResponse("error", "No existe un usuario con ese nombre");
        }
    }

    public function signup() {
        $data = $this->getData();

        $username = cleanValue($data, "username");
        $password = cleanValue($data, "password");
        $favUma = cleanValue($data, "fav_uma");
        $allowedUmas = ["Mayano Top Gun", "Narita Brian", "Marvelous Sunday", "Tokai Teio", "Haru Urara"];

        if (empty($username) || empty($password) || empty($favUma)) {
            code(400);
            $this->jsonResponse("error", "Parece que intentaste enviar un campo vacío");
            return;
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            code(400);
            $this->jsonResponse("error", "La contraseña no puede ser menor a 8 caracteres o mayor a 20");
            return;
        }

        if (strlen($username) < 3 || strlen($username) > 20) {
            code(400);
            $this->jsonResponse("error", "Tu nombre no puede ser menor a 3 caracteres o mayor a 20");
            return;
        }

        if (!in_array($favUma, $allowedUmas)) {
            code(400);
            $this->jsonResponse("error", "Parece que intentaste cambiar a tu Uma favorita");
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $usuarioModel = new Model();
        $resultado = $usuarioModel->signup($username, $passwordHash, $favUma);

        if ($resultado) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $resultado["id"];
            $_SESSION["username"] = $username;
            $_SESSION["fav_uma"] = $favUma;
            $this->jsonResponse("ok", "Registro exitoso, redirigiendo..", null, "home");
        } else {
            code(400);
            $this->jsonResponse("error", "Ya existe un usuario registrado con ese nombre o error en el registro");        
        }
    }

    public function getAllPosts() {
        $model = new Model();
        $userId = $_SESSION["user_id"] ?? null;
        $posts = $model->getAllPosts($userId);
        $this->jsonResponse("ok", "Publicaciones enviadas", $posts);
    }

    public function getUser($username) {
        $username = cleanString($username);

        $model = new Model();
        $userData = $model->getUser($username);
        
        if ($userData) {
            $this->jsonResponse("ok", "Perfil enviado", $userData);
        } else {
            code(404);
            $this->jsonResponse("error", "El usuario no fue encontrado");
        }
    }

    public function createPost() {
        $data = $this->getData();

        $title = cleanValue($data, "post_title");
        $content = cleanValue($data, "post_content");
        $postImg = cleanValue($data, "post_img");
        $userId = $_SESSION["user_id"] ?? null;

        if (empty($userId)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
            return;
        }

        if ($content === null || $title === null || $postImg === null) {
            code(400);
            $this->jsonResponse("error", "Parece que el contenido de la publicacion está vacio");
            return;
        }

        if (strlen($content) > 250 || strlen($title) > 100) {
            code(400);
            $this->jsonResponse("error", "El mensaje es muy largo (Max 250 caracteres)");
            return;
        }
    
        $model = new Model();
        $estado = $model->createPost($userId, $title, $content, $postImg);

        if ($estado) {
            $this->jsonResponse("ok", "Publicacion hecha", $estado);
        } else {
            code(429);
            $this->jsonResponse("error", "Ya hiciste una publicacion en los ultimos 5 minutos o error al crearla");
        }
    }

    public function toggleLike() {
        $data = $this->getData();
        $userId = $_SESSION["user_id"] ?? null; 

        if (empty($userId)) {
            code(401);
            $this->jsonResponse("error", "No estas logueado");
            return;
        }

        $postIdReceived = cleanValue($data, "data");
        $postId = filter_var($postIdReceived, FILTER_VALIDATE_INT, [
            "options" => [
                "min_range" => 1
            ]
        ]);

        if ($postId === false) {
            code(404);
            $this->jsonResponse("error", "La ID no es valida");
            return;
        }

        $model = new Model();
        $resData = $model->toggleLike($userId, $postId);

        if ($resData) {
            $this->jsonResponse("ok", "Like dado", $resData);
        } else {
            code(409);
            $this->jsonResponse("error", "No existe esa publicacion o error al procesar el like");
        }
    }

    public function createComment() {
        $data = $this->getData();
        
        $postId = cleanValue($data, "postId");
        $userId = $_SESSION["user_id"] ?? null;
        $content = cleanValue($data, "content");
        
        if (empty($userId)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
            return;
        }

        if (empty($postId)) {
            code(404);
            $this->jsonResponse("error", "No existe la publicacion que intentas comentar");
            return;
        }

        if (empty($content)) {
            code(400);
            $this->jsonResponse("error", "Tu comentario está vacio");
            return;
        }

        $model = new Model(); 
        $respuesta = $model->createComment($postId, $userId, $content);
        
        if ($respuesta) {
            $this->jsonResponse("ok", "Todo bien", $respuesta);
        } else {
            code(500);
            $this->jsonResponse("error", "No se pudo crear el comentario");
        }
    }

    public function sendFriendRequest() {
        $data = $this->getData();

        $userIdSends = $_SESSION["user_id"] ?? null;
        $userIdReceives = $data["data"] ?? null;

        if (empty($userIdSends)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
            return;
        }

        if (empty($userIdReceives) || $userIdSends === $userIdReceives) {
            code(404);
            $this->jsonResponse("error", "ID de usuario invalido");
            return;
        }

        $model = new Model();
        $res = $model->sendFriendRequest($userIdSends, $userIdReceives);

        if ($res) {
            $this->jsonResponse("ok", "Solicitud de amistad enviada");
        } else {
            code(400);
            $this->jsonResponse("error", "No se pudo enviar la solicitud de amistad (ya existe o usuario no válido)");
        }
    }

    public function answerFriendRequest() {
        $data = $this->getData();

        $userIdSends = $_SESSION["user_id"] ?? null;
        $userIdReceives = $data["data"] ?? null;

        if (empty($userIdSends)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
            return;
        }

        if (empty($userIdReceives) || $userIdSends === $userIdReceives) {
            code(404);
            $this->jsonResponse("error", "ID de usuario invalido");
            return;
        }

        $model = new Model();
        $res = $model->answerFriendRequest($userIdSends, $userIdReceives);

        if ($res) {
            $this->jsonResponse("ok", "Solicitud de amistad respondida");
        } else {
            code(400);
            $this->jsonResponse("error", "No se pudo responder la solicitud de amistad");
        }
    }
}