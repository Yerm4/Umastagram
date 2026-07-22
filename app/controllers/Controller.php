<?php

namespace app\controllers;

use app\models\Usuario;

class Controller {
    
    private $pdo;

    public function __construct($conexion) {
        $this->pdo = $conexion;
    }

    public function registrarUsuario() {
        $nombreUsuario = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
        $umaFav = isset($_POST["uma_fav"]) ? trim($_POST["uma_fav"]) : "";
        $umasDisponibles = ["Mayano Top Gun", "Narita Brian"];

        if (empty($nombreUsuario) || empty($password) || empty($umaFav)) {
            $_SESSION["error_registro"] = "Parece que intentaste enviar un campo vacío";
            reload();
        }

        else if (strlen($password) < 8 || strlen($password) > 20) {
            $_SESSION["error_registro"] = "La contraseña no puede ser menor a 8 caracteres o mayor a 20";    
            reload();
        }

        else if (strlen($nombreUsuario) < 3 || strlen($nombreUsuario) > 20) {
            $_SESSION["error_registro"] = "Tu nombre no puede ser menor a 8 caracteres o mayor a 20";    
            reload();
        }

        else if (!in_array($umaFav, $umasDisponibles)) {
            $_SESSION["error_registro"] = "Parece que intentaste cambiar a tu Uma favorita";    
            reload();
        }

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

    public function iniciarSesion() {
        $nombreUsuario = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "xddddd";
        
        if (empty($nombreUsuario) || empty($password)) {
            $_SESSION["error_login"] = "Parece que intentaste enviar un campo vacío";
            reload();
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            $_SESSION["error_login"] = "La contraseña    no puede ser menor a 8 caracteres o mayor a 20";    
            reload();
        }

        if (strlen($nombreUsuario) < 3 || strlen($nombreUsuario) > 20) {
            $_SESSION["error_login"] = "Tu nombre no puede ser menor a 8 caracteres o mayor a 20";    
            reload();
        }

        $usuarioModel = new Usuario($this->pdo);
        $resultado = $usuarioModel->login($nombreUsuario);

        if ($resultado["status"] === "ok") {
            if (password_verify($password, $resultado["data"]["password"])) {
                $_SESSION["id_usuario"] = $resultado["data"]["id"];
                $_SESSION["nombre_usuario"] = $resultado["data"]["nombre"];
                $_SESSION["uma_fav"] = $resultado["data"]["uma_fav"];
                header("Location: perfil");
                exit();
            }
            
            else {
                $_SESSION["error_login"] = "La contraseña no coincide";        
            }
        }

        else {
            $_SESSION["error_login"] = $resultado["data"];
        }

    }

    public function publicar() {
        $contenido = isset($_POST["contenido_publicacion"]) ? $_POST["contenido_publicacion"] : "";
        $id_usuario = $_SESSION["id_usuario"];

        if (strlen($contenido) > 0 && $id_usuario) {
            $model = new Usuario($this->pdo);
            $estado = $model->publicar($id_usuario, $contenido);

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
        $model = new Usuario($this->pdo);
        return $model->consultarPublicaciones();
    }
}