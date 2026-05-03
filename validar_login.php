<?php 
session_start();
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $passwordForm = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["nombre" => $usuario]);
    $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioEncontrado && password_verify($passwordForm, $usuarioEncontrado["password"])) {
        $_SESSION["user_id"] = $usuarioEncontrado["id"];
        $_SESSION["user_nombre"] = $usuarioEncontrado["nombre"];
        header("Location: index.html");
        exit();
    } else {
        echo "error";
    }
}