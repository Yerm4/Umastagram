<?php

$user = $partesRuta[1] ?? null;

use app\model\Model;

$titulo = $user["username"] ?? "Uma Musume";
include_once __DIR__."/header.php";

if (!empty($partesRuta[1])) {
    $model = new Model($pdo);
    $userData = $model->getUser($user);
    
    if ($userData["status"] === "ok") {
        $user = $userData["data"];
    }

    else {
        include_once __DIR__."/404.php";
        exit();
    }
}

else {
    include_once __DIR__."/404.php";
    exit();
}
?>

<?php if (($userData["status"] ?? null) === "ok" && ($user["id"] ?? null) === $_SESSION["user_id"]): ?>    
    <main class="muro">
        <section class="hero">
            <div class="card card__profile">
                <h2 class="capitalize profile__title-name">Hola, <?= e($user["username"]) ?>! <br> Bienvenid@.</h2>
                <form class="form login-form">
                    <p>Espero sea de tu agrado mi sitio </p> 
                    <p>Tu uma favorita es <strong><?= e($user["fav_uma"]) ?></strong>? <br> Pronto podras utilizarla de foto de perfil! </p> 
                    <p>Me uni a Umastagram el dia <strong><?= e($user["signup_date"]) ?></strong></p>
                    <p>Nuevas funciones en camino...</p>
                </form>
            </div>
        </section>
    </main>
<?php else: ?>
    <main class="muro">
        <section class="hero">
            <div class="card card__profile">
                <h2 class="capitalize profile__title-name">Bienvenid@ a mi perfil, soy <?= e($user["username"]) ?>.</h2>
                <div>
                    <p>Mi uma favorita es <strong><?= e($user["fav_uma"]) ?></strong></p> 
                    <p>Me uni a Umastagram el dia <strong><?= e($user["signup_date"]) ?></strong></p>
                </div>
            </div>
        </section>
    </main>
<?php endif ?>

<?php include_once __DIR__."/footer.php" ?>
    <video src="src/media/img/mambo-spinning.webm" class="mambo-wrapper__video" autoplay loop muted playsinline title="mambo"></video>
    <video src="src/media/img/mambo-spinning.webm" class="mambo-wrapper__video mambo-wrapper__video--left" autoplay loop muted playsinline title="mambo"></video>
</body>
</html>