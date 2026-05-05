<?php 
session_start();
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $_POST["usuario"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["nombre" => $nombreUsuario]);
    $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado["password"])) {
        $_SESSION["id_usuario"] = $usuarioEncontrado["id"];
        $_SESSION["nombre_usuario"] = $usuarioEncontrado["nombre"];
        header("Location: muro.php");
        exit();
    } else {
        $error = "Error. El usuario o contraseña son incorrectos";
    }
}
$titulo = "Login";
include "header.php";
?>
    <main class="login">
        <section class="section-1">
            <div class="login-card">
            <h1>Inicia Sesión</h1>
            <form class="login-form" action="" method="POST">
                <label> Nombre <br>
                    <input type="text" name="usuario" required>
                </label>
                <label> Contraseña <br>
                    <input type="password" name="password" required>
                </label>
                <button type="submit">Registrar</button>
            </form>
            <p class="aviso"><?= isset($aviso) ? e($aviso) : ""; ?> <br> <?= isset($error) ? e($error) : ""?></p>
            </div>
        </section>
    </main>
    
    <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo " autoplay loop muted playsinline title="mambo"></video>
            <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo " autoplay loop muted playsinline title="mambo"></video>
</body>
</html>