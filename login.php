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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="" method="POST">
        <label>
            <input type="text" name="usuario" required>
        </label>
        <br>
        <label>
            <input type="password" name="password" required>
        </label>
        <br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>