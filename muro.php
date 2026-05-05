<?php
session_start();
require "conexion.php";

if (isset($_SESSION["nombre"])) {
    $nombreUsuario = $_SESSION["nombre_usuario"];
}
else {
    header("Location: login.php");
}

include "header.php"; 
?>
    <main class="muro">
            <section class="section-1">
                <div class="login-card">
                <h1>Hola, <?= e($nombreUsuario) ?>! <br> Bienvenido.</h1>
                <form class="login-form" action="" method="POST">
                    <p class="aviso">Espero sea de tu agrado mi sitio <br> Pronto mas funciones!</p>
                    <button type="submit" name="" value="">Reclamar uma</button>
                </form>
                </div>
            </section>
        </main>
        
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo " autoplay loop muted playsinline title="mambo"></video>
            <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo " autoplay loop muted playsinline title="mambo"></video>
</body>
</html>