<?php

use app\controllers\Controller;

if (!$_SESSION["user_id"]) {
    header("Location: home");
    die();
}

$titulo = "Perfil";
include "header.php"; 
$controller = new Controller($pdo);
$resultado = $controller->consultarPublicaciones();
?>
    <main class="muro">
            <section class="section-1">
                <div class="card">
                <h2 class="capitalize">Hola, <?= e($_SESSION["username"]) ?>! <br> Bienvenid@.</h2>
                <form class="form login-form" action="" method="POST">
                    <p class="aviso">Espero sea de tu agrado mi sitio </p> 
                    <p class="aviso"> Tu uma favorita es <strong><?= e($_SESSION["fav_uma"]) ?></strong>? <br> Pronto podras utilizarla de foto de perfil! </p> 
                    <p class="aviso">Nuevas funciones en camino...</p>
                    
                </form>
                </div>
            </section>
    </main>

        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo" autoplay loop muted playsinline title="mambo"></video>
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo" autoplay loop muted playsinline title="mambo"></video>
</body>
</html>