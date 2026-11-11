<?php
namespace app\controller;
declare(strict_types=1);

use app\model\Model;
use app\controller\BaseController;

class AuthController extends BaseController {
        
    public function login() : void {
        $data = $this->getData();

        $username = cleanValue($data, "username");

        $rawPassword = $data["password"] ?? null;
        $password = is_string($rawPassword) && $rawPassword !== '' ? $rawPassword : null;

        if ($username === null || $password === null) {
            $this->jsonResponse(400, "error", "Parece que intentaste enviar un campo vacío");
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            $this->jsonResponse(400, "error", "La contraseña debe tener entre 8 y 20 caracteres");
        }

        if (mb_strlen($username, 'UTF-8') < 3 || mb_strlen($username, 'UTF-8') > 20) {
            $this->jsonResponse(400, "error", "Tu nombre debe tener entre 3 y 20 caracteres");
        }

        $usuarioModel = new Model();
        $userData = $usuarioModel->login($username);

        if ($userData && password_verify($password, $userData["password"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = (int)$userData["id"];
            $_SESSION["username"] = $userData["username"];
            $_SESSION["fav_uma"] = $userData["fav_uma"];
            
            $this->jsonResponse(200, "ok", "Inicio de sesión exitoso, redirigiendo..", null, "home");
        }
    
        $this->jsonResponse(401, "error", "Usuario o contraseña incorrectos");
    }

    public function signup() : void {
        $data = $this->getData();

        $username = cleanValue($data, "username");
        $password = cleanValue($data, "password");
        $favUma = cleanValue($data, "fav_uma");
        $allowedUmas = ["Mayano Top Gun", "Narita Brian", "Marvelous Sunday", "Tokai Teio", "Haru Urara"];

        if (empty($username) || empty($password) || empty($favUma)) {
            $this->jsonResponse(400, "error", "Parece que intentaste enviar un campo vacío");
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            $this->jsonResponse(400, "error", "La contraseña no puede ser menor a 8 caracteres o mayor a 20");
        }

        if (strlen($username) < 3 || strlen($username) > 20) {
            $this->jsonResponse(400, "error", "Tu nombre no puede ser menor a 3 caracteres o mayor a 20");
        }

        if (!in_array($favUma, $allowedUmas)) {
            $this->jsonResponse(400, "error", "Parece que intentaste cambiar a tu Uma favorita");
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $usuarioModel = new Model();
        $resultado = $usuarioModel->signup($username, $passwordHash, $favUma);

        if ($resultado) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $resultado["id"];
            $_SESSION["username"] = $username;
            $_SESSION["fav_uma"] = $favUma;
            $this->jsonResponse(200, "ok", "Registro exitoso, redirigiendo..", null, "home");
        } else {
            $this->jsonResponse(400, "error", "Ya existe un usuario registrado con ese nombre o error en el registro");        
        }
    }

    public function getAllPosts() {
        $model = new Model();
        $userId = $_SESSION["user_id"] ?? null;
        $posts = $model->getAllPosts($userId);
        $this->jsonResponse(200, "ok", "Publicaciones enviadas", $posts);
    }

    public function getUser(string $username) : void {
        $username = parseString($username);

        $model = new Model();
        $userData = $model->getUser($username);
        
        if ($userData) {
            $this->jsonResponse(200, "ok", "Perfil enviado", $userData);
        } else {
            $this->jsonResponse(404, "error", "El usuario no fue encontrado");
        }
    }

    public function createPost() : void {
        $data = $this->getData();

        $title = cleanValue($data, "post_title");
        $content = cleanValue($data, "post_content");
        $postImg = cleanValue($data, "post_img");
        $userId = $_SESSION["user_id"] ?? null;

        if (empty($userId)) {
            $this->jsonResponse(401, "error", "No tas logueado");
        }

        if ($content === null || $title === null || $postImg === null) {
            $this->jsonResponse(400, "error", "Parece que el contenido de la publicacion está vacio");
        }

        if (strlen($content) > 250 || strlen($title) > 100) {
            $this->jsonResponse(400, "error", "El mensaje es muy largo (Max 250 caracteres)");
        }
    
        $model = new Model();
        $estado = $model->createPost($userId, $title, $content, $postImg);

        if ($estado) {
            $this->jsonResponse(200, "ok", "Publicacion hecha", $estado);
        } else {
            $this->jsonResponse(429, "error", "Ya hiciste una publicacion en los ultimos 5 minutos o error al crearla");
        }
    }

    public function toggleLike() : void {
        $data = $this->getData();
        $userId = parsePositiveInt($_SESSION["user_id"] ?? null); 

        if ($userId === null) {
            $this->jsonResponse(401, "error", "No estas logueado");
        }

        $postIdReceived = cleanValue($data, "data");
        $postId = filter_var($postIdReceived, FILTER_VALIDATE_INT, [
            "options" => [
                "min_range" => 1
            ]
        ]);

        if ($postId === false) {
            $this->jsonResponse(404, "error", "La ID no es valida");
        }

        $model = new Model();
        $resData = $model->toggleLike($userId, $postId);

        if ($resData) {
            $this->jsonResponse(200, "ok", "Like dado", $resData);
        } else {
            $this->jsonResponse(409, "error", "No existe esa publicacion o error al procesar el like");
        }
    }

    public function createComment() : void {
        $data = $this->getData();
        
        $postId = cleanValue($data, "postId");
        $userId = $_SESSION["user_id"] ?? null;
        $content = cleanValue($data, "content");
        
        if (empty($userId)) {
            $this->jsonResponse(401, "error", "No tas logueado");
        }

        if (empty($postId)) {
            $this->jsonResponse(404, "error", "No existe la publicacion que intentas comentar");
        }

        if (empty($content)) {
            $this->jsonResponse(400, "error", "Tu comentario está vacio");
        }

        $model = new Model(); 
        $respuesta = $model->createComment($postId, $userId, $content);
        
        if ($respuesta) {
            $this->jsonResponse(200, "ok", "Todo bien", $respuesta);
        } else {
            $this->jsonResponse(500, "error", "No se pudo crear el comentario");
        }
    }

    public function sendFriendRequest() : void {
        $data = $this->getData();

        $userIdSends = $_SESSION["user_id"] ?? null;
        $userIdReceives = cleanValue($data, "data") ?? null;

        if (empty($userIdSends)) {
            $this->jsonResponse(401, "error", "No tas logueado");
        }

        if (empty($userIdReceives) || $userIdSends === $userIdReceives) {
            $this->jsonResponse(404, "error", "ID de usuario invalido");
        }

        $model = new Model();
        $resp = $model->sendFriendRequest($userIdSends, $userIdReceives);

        if ($resp) {
            $this->jsonResponse(200, "ok", "Solicitud de amistad enviada");
        } else {
            $this->jsonResponse(400, "error", "No se pudo enviar la solicitud de amistad (ya existe o usuario no válido)");
        }
    }

    public function answerFriendRequest() {
        $data = $this->getData();

        $currentUserId = $_SESSION["user_id"] ?? null;
        $senderUserId = $data["data"] ?? null;
        $action = cleanValue($data, "action"); #REVISAR

        if (empty($currentUserId)) {
            $this->jsonResponse(401, "error", "No tas logueado");
        }

        if (empty($senderUserId) || $currentUserId === $senderUserId) {
            $this->jsonResponse(404, "error", "ID de usuario invalido");
        }

        $model = new Model();
        $accept = ($action === 'accept');
        $resp = $model->answerFriendRequest($currentUserId, $senderUserId);

        if ($resp) {
            $message = $accept ? "Solicitud de amistad aceptada" : "Solicitud de amistad rechazada";
            $this->jsonResponse(200, "ok", "Solicitud de amistad respondida");
        } else {
            $this->jsonResponse(400, "error", "No se pudo responder la solicitud de amistad");
        }
    }
}