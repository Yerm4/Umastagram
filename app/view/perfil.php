<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

isset($_SESSION["id_usuario"]) ? $ok = "ok" : header("Location: home");

$titulo = "Perfil";
include "header.php"; 
?>
    <main class="muro">
            <section class="section-1">
                <div id="card" class="card perfil-card">
                <h1>Hola, <?= e($nombreUsuario) ?>! <br> Bienvenid@.</h1>
                <form class="login-form" action="" method="POST">
                    <p class="aviso">Espero sea de tu agrado mi sitio </p> 
                    <p class="aviso"> Tu uma favorita es <strong><?= e($umaFav) ?></strong>? <br> Pronto podras utilizarla de foto de perfil! </p> 
                    <p class="aviso">Nuevas funciones en camino...</p>
                    
                </form>
                </div>
            </section>
        </main>
        
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo " autoplay loop muted playsinline title="mambo"></video>
            <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo " autoplay loop muted playsinline title="mambo"></video>
</body>
</html>