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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registrate</h1>
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