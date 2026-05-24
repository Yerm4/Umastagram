<?php

namespace App\Controllers;

use App\Models\Usuario;

class AuthController {
    
    private $pdo;

    public function __construct($conexionBD) {
        $this->pdo = $conexionBD;
    }

    public function registrarUsuario() {
        $nombreUsuario = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
        $umaFav = isset($_POST["uma_fav"]) ? trim($_POST["uma_fav"]) : "";
        $umasDisponibles = ["Mayano Top Gun", "Narita Brian"];

        if (strlen($password) >= 8 && in_array($umaFav, $umasDisponibles)) {
            $sql = "INSERT INTO usuarios (nombre, password, uma_fav) values (:nombre, :password, :umaFav)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                "nombre" => $nombreUsuario,
                "password" => $password,
                "umaFav" => $umaFav
            ]);
        }
    }










    public function iniciarSesion() {
        $nombreUsuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

        if (!empty($nombreUsuario) && !empty($password)) {
            $usuarioModel = new Usuario($this->pdo);
            if ($usuarioModel->login($nombreUsuario, $password)) {
                echo"olaaaaaaaaaaaaaaa";
            }
        }
    }
}