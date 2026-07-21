<?php

namespace app\controllers;

use app\models\Usuario;

class AuthController {
    
    private $pdo;

    public function __construct($conexion) {
        $this->pdo = $conexion;
    }

    public function registrarUsuario() {
        $nombreUsuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
        $umaFav = isset($_POST["uma_fav"]) ? trim($_POST["uma_fav"]) : "";
        $umasDisponibles = ["Mayano Top Gun", "Narita Brian"];

        if (!empty($nombreUsuario) && !empty($password) && strlen($password) >= 8 
        && in_array($umaFav, $umasDisponibles)) {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $usuarioModel = new Usuario($this->pdo);
                $resultado = $usuarioModel->registro($nombreUsuario, $passwordHash, $umaFav);
                if ($resultado["status"] === "ok") {
                    $_SESSION["id_usuario"] = $resultado["data"];
                    $_SESSION["nombre_usuario"] = $nombreUsuario;
                    $_SESSION["uma_fav"] = $umaFav;
                    header("Location: perfil");
                }
                else {
                    $_SESSION["error_registro"] = $resultado["data"];
                }
        }
        else {
            $_SESSION["error_registro"] = "Error en las validaciones";
        }
    }

    public function iniciarSesion() {
        $nombreUsuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

        if (!empty($nombreUsuario) && !empty($password)) {
            $usuarioModel = new Usuario($this->pdo);
            $resultado = $usuarioModel->login($nombreUsuario, $password);
            if ($resultado && password_verify($password, $resultado["password"])) {
                $_SESSION["id_usuario"] = $resultado["id"];
                $_SESSION["nombre_usuario"] = $resultado["nombre"];
                $_SESSION["uma_fav"] = $resultado["uma_fav"];
                header("Location: perfil");
            }

            else {
                $_SESSION["error_login"] = $resultado["data"];
            }
        }
    }

    public function publicar() {
        $contenido = isset($_POST["contenido_publicacion"]) ? $_POST["contenido_publicacion"] : "";
        $id_usuario = $_SESSION["id_usuario"];

        if (strlen($contenido) > 0 && $id_usuario) {
            $model = new Usuario($this->pdo);
            $estado = $model->publicar($id_usuario, $contenido);

            if ($estado["status"] === "ok") {
                die("Publicacion hecha");
            }

            else {
                die ("La publicacion no se hizo");
            }
        }

        else {
            die("Error en validaciones");
        }
    }
}