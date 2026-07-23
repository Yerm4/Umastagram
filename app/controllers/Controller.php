<?php

namespace app\controllers;

use app\models\Model;

class Controller {
    
    private $pdo;

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    private function jsonResponse($status, $message = "", $data = null, $redirect = null) {
        header("Content-Type: application/json");
        echo json_encode([
            "status" => $status,
            "message" => $message,
            "data" => $data,
            "redirect" => $redirect
        ]);
        exit();
    }

    public function login() {

        $data = json_decode(file_get_contents('php://input'), true);

        $username = isset($data["username"]) ? trim($data["username"]) : "";
        $password = isset($data["password"]) ? trim($data["password"]) : "";
        
        if (empty($username) || empty($password)) {
            $this->jsonResponse("error", "Parece que intentaste enviar un campo vacío");
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            $this->jsonResponse("error", "La contraseña no puede ser menor a 8 caracteres o mayor a 20");
        }

        if (strlen($username) < 3 || strlen($username) > 20) {
            $this->jsonResponse("error", "Tu nombre no puede ser menor a 3 caracteres o mayor a 20");
        }

        $usuarioModel = new Model($this->pdo);
        $resultado = $usuarioModel->login($username);

        if ($resultado["status"] === "ok") {
            if (password_verify($password, $resultado["data"]["password"])) {
                $_SESSION["user_id"] = $resultado["data"]["id"];
                $_SESSION["username"] = $resultado["data"]["username"];
                $_SESSION["fav_uma"] = $resultado["data"]["fav_uma"];
                $this->jsonResponse("ok", "¡Inicio de sesión correcto!", null, "perfil");
            }
            
            else {
                $this->jsonResponse("error", "La contraseña no coincide");
            }
        }

        else {
            $this->jsonResponse("error", $resultado["data"]);
        }
    }

    public function signUp() {

        $data = json_decode(file_get_contents("php://input"), true);

        $username = isset($data["username"]) ? trim($data["username"]) : "";
        $password = isset($data["password"]) ? trim($data["password"]) : "";
        $favUma = isset($data["fav_uma"]) ? trim($data["fav_uma"]) : "";
        $allowedUmas = ["Mayano Top Gun", "Narita Brian"];

        if (empty($username) || empty($password) || empty($favUma)) {
            $this->jsonResponse("error", "Parece que intentaste enviar un campo vacío");
        }

        else if (strlen($password) < 8 || strlen($password) > 20) {
            $this->jsonResponse("error", "La contraseña no puede ser menor a 8 caracteres o mayor a 20");
        }

        else if (strlen($username) < 3 || strlen($username) > 20) {
            $this->jsonResponse("error", "Tu nombre no puede ser menor a 3 caracteres o mayor a 20");
        }

        else if (!in_array($favUma, $allowedUmas)) {
            $this->jsonResponse("error", "Parece que intentaste cambiar a tu Uma favorita");
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $usuarioModel = new Model($this->pdo);
        $resultado = $usuarioModel->signUp($username, $passwordHash, $favUma);

        if ($resultado["status"] === "ok") {
            $_SESSION["user_id"] = $resultado["data"];
            $_SESSION["username"] = $username;
            $_SESSION["fav_uma"] = $favUma;
            $this->jsonResponse("ok", "¡Registro exitoso!", null, "perfil");        }
        else {
            $this->jsonResponse("error", $resultado["data"]);        }
    }

    public function publicar() {
        
        if (!$_SESSION["user_id"]) {
            reload();
        }

        $title = isset($_POST["post_title"]) ? $_POST["post_title"] : "";
        $content = isset($_POST["post_content"]) ? $_POST["post_content"] : "";
        $userId = $_SESSION["user_id"];

        if (strlen($content) > 0 && $userId) {
            $model = new Model($this->pdo);
            $estado = $model->publicar($userId, $title, $content);

            if ($estado["status"] === "ok") {
                reload();
            }

            else {
                die ("La publicacion no se hizo");
            }
        }

        else {
            die("Error en validaciones");
        }
    }

    public function consultarPublicaciones () {
        $model = new Model($this->pdo);
        return $model->consultarPublicaciones();
    }

    public function actualizarLikes () {

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        $postId = $data["data"];
        $userId = $_SESSION["user_id"];
        $model = new Model($this->pdo);
        return $model->consultarPublicaciones($postId, $userId);
    }
}