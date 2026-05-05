<?php 
require "conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    if (strlen($password) >= 8) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $sql = "INSERT INTO usuarios (nombre, password) VALUES (:nombre, :password)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->execute([
                "nombre" => $nombreUsuario,
                "password" => $passwordHash
            ]);

            $_SESSION["id_usuario"] = $pdo->lastInsertId();
            $_SESSION["nombre_usuario"] = $nombreUsuario;
            header("Location: perfil.php");
        }
    
        catch (PDOException $e) {
            $error = "Error. Una cuenta con ese nombre ya existe";
        }
    }

    else {
        $aviso = "La contraseña debe teber 8 o mas caracteres";
    }
}
$titulo = "Registro";
include "header.php";
?>
        <main class="register">
            <section class="section-1">
                <div id="card" class="card register-card">
                <h1>Crea tu cuenta</h1>
                <form class="register-form" action="" method="POST">
                    <label> Nombre <br>
                        <input type="text" name="usuario" required>
                    </label>
                    <label> Contraseña <br>
                        <input type="password" name="password" minlength="8" required>
                    </label>
                    <button type="submit">Registrar</button>
                </form>
                <p class="aviso"><?= isset($aviso) ? e($aviso) : ""; ?> <br> <?= isset($error) ? e($error) : ""?></p>
            </section>
        </main>
        
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo " autoplay loop muted playsinline title="mambo"></video>
            <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo " autoplay loop muted playsinline title="mambo"></video>
</body>
</html>