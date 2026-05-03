<?php 
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO usuarios (nombre, password) VALUES (:nombre, :pass)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            "nombre" => $usuario,
            "pass" => $passwordHash
        ]);

        echo "ya";
    }

    catch (PDOException $e) {
        echo "error".$e;
    }
}