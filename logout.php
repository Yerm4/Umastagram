<?php
session_start();
if (isset($_SESSION["nombre_usuario"])) {
    session_destroy();
}

else {
    header("Location: index.php");
}

include "header.php"; 
?>
    <main class="muro">
            <section class="section-1">
                <div id="card" class="card login-card">
                <h1>Hola, haz cerrado sesión.</h1>
                <form class="login-form" action="" method="POST">
                    <p class="aviso">Serás redirigido a la pagina principal</p>
                </form>
                </div>
            </section>
        </main>
        <footer>
            <script src="src/script/logout.js" defer></script>
        </footer>
        <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning" id="mambo " autoplay loop muted playsinline title="mambo"></video>
            <video src="src/media/img/mambo-spinning.webm" class="mambo-spinning mambo-spinning2" id="mambo " autoplay loop muted playsinline title="mambo"></video>
</body>
</html>