<?php

namespace App\Controllers;

use App\Models\Usuario;

class AuthController {
    
    private $pdo;

    public function __construct($conexionBD) {
        $this->pdo = $conexionBD;
    }

    public function registrarUsuario() {
        $nombreUsuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
        $umaFav = isset($_POST["uma_fav"]) ? trim($_POST["uma_fav"]) : "";
        $umasDisponibles = ["Mayano Top Gun", "Narita Brian"];

        if (!empty($nombreUsuario) && !empty($password) && strlen($password) >= 8 && in_array($umaFav, $umasDisponibles)) {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $usuarioModel = new Usuario($this->pdo);
                $resultado = $usuarioModel->registro($nombreUsuario, $passwordHash, $umaFav);
                if ($resultado) {
                    $_SESSION["id_usuario"] = $resultado;
                    $_SESSION["nombre_usuario"] = $nombreUsuario;
                    $_SESSION["uma_fav"] = $umaFav;
                    header("Location: perfil");
                }
                else {
                    echo "error pana mio";
                }
        }
        else {
            $_SESSION["error_registro"] = "Error. Quizá un usuario con ese nombre ya existe";
        }
    }

    public function iniciarSesion() {
        $nombreUsuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

        if (!empty($nombreUsuario) && !empty($password)) {
            $usuarioModel = new Usuario($this->pdo);
            $usuarioEncontrado = $usuarioModel->login($nombreUsuario, $password);
            if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado["password"])) {
                $_SESSION["id_usuario"] = $usuarioEncontrado["id"];
                $_SESSION["nombre_usuario"] = $usuarioEncontrado["nombre"];
                $_SESSION["uma_fav"] = $usuarioEncontrado["uma_fav"];
                header("Location: perfil");
            }

            else {
                $_SESSION["error_login"] = "Usuario o contraseña incorrecta";
            }
        }
    }
}