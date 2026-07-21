<?php
isset($_SESSION["id_usuario"]) ? $ok = "ok" : header("Location: home");

$titulo = "Perfil";
include "header.php"; 
?>
    <main class="muro">
            <section class="section-1">
                <div id="card" class="card perfil-card">
                <h2>Hola, <?= e($nombreUsuario) ?>! <br> Bienvenid@.</h2>
                <form class="login-form" action="" method="POST">
                    <p class="aviso">Espero sea de tu agrado mi sitio </p> 
                    <p class="aviso"> Tu uma favorita es <strong><?= e($umaFav) ?></strong>? <br> Pronto podras utilizarla de foto de perfil! </p> 
                    <p class="aviso">Nuevas funciones en camino...</p>
                    
                </form>
                </div>
            </section>
            <section class="section-1">
                <div id="card" class="card perfil-card">
                
                <form class="login-form" action="" method="POST">
                    <fieldset>
                    <legend>Publicaciones</legend>
                    <input type="hidden" name="form" value="publicar">
                    <input type="text" placeholder="Contenido" name="contenido_publicacion">
                    <button type="submit">Enviar</button>
                    </fieldset>

                </form>
                </div>
            </section>
        </main>
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo" autoplay loop muted playsinline title="mambo"></video>
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo" autoplay loop muted playsinline title="mambo"></video>
</body>
</html>