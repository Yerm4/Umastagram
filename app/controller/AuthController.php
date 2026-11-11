<?php
namespace app\controller;

use app\model\Model;
use app\controller\BaseController;

class AuthController extends BaseController {
    public function login() {

        $data = json_decode(file_get_contents("php://input"), true);

        $username = cleanValue($data, "username");
        $password = cleanValue($data, "password");
        
        if (empty($username) || empty($password)) {
            code(400);
            $this->jsonResponse("error", "Parece que intentaste enviar un campo vacío");
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            code(400);
            $this->jsonResponse("error", "La contraseña no puede ser menor a 8 caracteres");
        }

        if (strlen($username) < 3 || strlen($username) > 20) {
            code(400);
            $this->jsonResponse("error", "Tu nombre no puede ser menor a 3 caracteres");
        }

        $usuarioModel = new Model();
        $resultado = $usuarioModel->login($username);
        $data = $resultado["data"];
        if ($resultado["status"] === "ok") {
            if (password_verify($password, $data["password"])) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $data["id"];
                $_SESSION["username"] = $data["username"];
                $_SESSION["fav_uma"] = $data["fav_uma"];
                $this->jsonResponse("ok", "Inicio de sesión exitoso, redirigiendo..", null, "home");
            }
            
            else {
                code(401);
                $this->jsonResponse("error", "La contraseña no coincide");
            }
        }

        else {
            code(400);
            $this->jsonResponse("error", $resultado["message"]);
        }
    }

    public function signup() {

        $data = json_decode(file_get_contents("php://input"), true);

        $username = cleanValue($data, "username");
        $password = cleanValue($data, "password");
        $favUma = cleanValue($data, "fav_uma");
        $allowedUmas = ["Mayano Top Gun", "Narita Brian", "Marvelous Sunday", "Tokai Teio", "Haru Urara"];

        if (empty($username) || empty($password) || empty($favUma)) {
            code(400);
            $this->jsonResponse("error", "Parece que intentaste enviar un campo vacío");
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            code(400);
            $this->jsonResponse("error", "La contraseña no puede ser menor a 8 caracteres o mayor a 20");
        }

        if (strlen($username) < 3 || strlen($username) > 20) {
            code(400);
            $this->jsonResponse("error", "Tu nombre no puede ser menor a 3 caracteres o mayor a 20");
        }

        if (!in_array($favUma, $allowedUmas)) {
            code(400);
            $this->jsonResponse("error", "Parece que intentaste cambiar a tu Uma favorita");
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $usuarioModel = new Model();
        $resultado = $usuarioModel->signup($username, $passwordHash, $favUma);

        if ($resultado["status"] === "ok") {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $resultado["data"]["id"];
            $_SESSION["username"] = $username;
            $_SESSION["fav_uma"] = $favUma;
            $this->jsonResponse("ok", "Registro exitoso, redirigiendo..", null, "home");
        } else {
            code(400);
            $this->jsonResponse("error", $resultado["message"]);        
        }
    }

    public function getAllPosts () {
        $model = new Model();
        $this->jsonResponse("ok", "Publicaciones enviadas", $model->getAllPosts());
    }

    public function getUser($username) {

        $username = cleanString($username);

        $model = new Model();
        $data = $model->getUser($username);
        
        if ($data["status"] === "ok") {
            $this->jsonResponse("ok", "Perfil enviado", $data);
        }

        else {
            code(404);
            $this->jsonResponse("error", "El usuario no fue encontrado", $data);
        }
    }

    public function createPost() {

        $data = json_decode(file_get_contents("php://input"), true);

        $title = cleanValue($data, "post_title");
        $content = cleanValue($data, "post_content");
        $postImg = cleanValue($data, "post_img");
        $userId = $_SESSION["user_id"] ?? null;

        if (empty($userId)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
        }

        if ($content === null || $title === null || $postImg === null) {
            code(400);
            $this->jsonResponse("error", "Parece que el contenido de la publicacion está vacio");
        }

        if (strlen($content) > 250 || strlen($title) > 100) {
            code(400);
            $this->jsonResponse("error", "El mensaje es muy largo (Max 250 caracteres)");
        }
    
        $model = new Model();
        $estado = $model->createPost($userId, $title, $content, $postImg);

        if ($estado["status"] === "ok") {
            $this->jsonResponse("ok", "Publicacion hecha", $estado["data"]);
        }

        else {
            code(429);
            $this->jsonResponse("error", "Ya hiciste una publicacion en los ultimos 5 minutos");
        }
    }

    public function toggleLike () {

        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $_SESSION["user_id"] ?? null; 

        if (empty($userId)) {
            code(401);
            $this->jsonResponse("error", "No estas logueado");
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
        }

        $model = new Model();

        $data = $model->toggleLike($userId, $postId);

        if ($data["status"] === "ok") {
            $this->jsonResponse("ok", "Like dado", $data["data"]);
        } else {
            code(409);
            $this->jsonResponse("error", $data["message"]);
        }
    }

    public function createComment() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $postId = cleanValue($data, "postId");
        $userId = $_SESSION["user_id"] ?? null;
        $content = cleanValue($data, "content");
        
        if (empty($userId)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
        }

        if (empty($postId)) {
            code(404);
            $this->jsonResponse("error", "No existe la publicacion que intentas comentar");
        }

        if (empty($content)) {
            code(400);
            $this->jsonResponse("error", "Tu comentario está vacio");
        }

        $model = new Model(); 
        $respuesta = $model->createComment($postId, $userId, $content);
        
        if ($respuesta["status"] === "ok") {
            $this->jsonResponse("ok", "Todo bien", $respuesta["data"]);
        } else {
            code(500);
            $this->jsonResponse("error", "No se pudo crear el comentario");
        }
    }

    public function sendFriendRequest() {
        $data = json_decode(file_get_contents("php://input"), true);

        $userIdSends = $_SESSION["user_id"] ?? null;
        $userIdReceives = $data["data"];

        if (empty($userIdSends)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
        }

        if (empty($userIdReceives) || $userIdSends === $userIdReceives) {
            code(404);
            $this->jsonResponse("error", "ID de usuario invalido");
        }

        $model = new Model();
        $res = $model->sendFriendRequest($userIdSends, $userIdReceives);

        if ($res["status"] === "ok") {
            $this->jsonResponse("ok", "Solicitud de amistad enviada");
        } else {
            $this->jsonResponse("error", "Solicitud de amistad no enviada");
        }
    }

    public function answerFriendRequest() {
        $data = json_decode(file_get_contents("php://input"), true);

        $userIdSends = $_SESSION["user_id"] ?? null;
        $userIdReceives = $data["data"];

        if (empty($userIdSends)) {
            code(401);
            $this->jsonResponse("error", "No tas logueado");
        }

        if (empty($userIdReceives) || $userIdSends === $userIdReceives) {
            code(404);
            $this->jsonResponse("error", "ID de usuario invalido");
        }

        $model = new Model();

        
    }
}