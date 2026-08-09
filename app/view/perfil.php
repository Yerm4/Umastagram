<?php

if (!$_SESSION["user_id"]) {
    header("Location: home");
    die();
}

$titulo = "Perfil";
?>
    <main class="muro">
            <section class="hero">
                <div class="card profile__wrapper">
                <h2 class="u-capitalize profile__title-name">Hola, <?= e($_SESSION["username"]) ?>! <br> Bienvenid@.</h2>
                <form class="form login-form" action="" method="POST">
                    <p>Espero sea de tu agrado mi sitio </p> 
                    <p> Tu uma favorita es <strong><?= e($_SESSION["fav_uma"]) ?></strong>? <br> Pronto podras utilizarla de foto de perfil! </p> 
                    <p>Nuevas funciones en camino...</p>
                </form>
                </div>
            </section>
    </main>

        <video src="src/media/img/mambo-wrapper__video.webm" class="mambo-wrapper__video" autoplay loop muted playsinline title="mambo"></video>
        <video src="src/media/img/mambo-wrapper__video.webm" class="mambo-wrapper__video mambo-wrapper__video--left" autoplay loop muted playsinline title="mambo"></video>
</body>
</html>