<?php
namespace App\Models;

use PDO;
class Usuario {
    private $pdo;

    public function __construct($conexionBD) {
        $this->pdo = $conexionBD;
    }

    public function login($nombreUsuario, $password) {
        $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "nombre" => $nombreUsuario
        ]);
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado["password"])) {
            $_SESSION["id_usuario"] = $usuarioEncontrado["id"];
            $_SESSION["nombre_usuario"] = $usuarioEncontrado["nombre"];
            $_SESSION["uma_fav"] = $usuarioEncontrado["uma_fav"];
            header("Location: perfil");
        }
        
    }
}