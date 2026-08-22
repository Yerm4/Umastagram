<?php

$user = $partesRuta[1] ?? null;

use app\model\Model;

$titulo = ucfirst($user) ?? "Uma Musume";
include_once __DIR__."/header.php";

if (!empty($partesRuta[1])) {
    $model = new Model($pdo);
    $userData = $model->getUser($user);
    $postsData = $model->getPosts($user);

    if ($userData["status"] === "ok" && $postsData["status"] === "ok") {
        $user = $userData["data"];
        $posts = $postsData["data"];
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
<?php // Usuario entra a su propio perfil ?>
<?php if (($userData["status"] ?? null) === "ok" && ($user["id"] ?? null) === ($_SESSION["user_id"] ?? null)): ?>    
    <main class="muro">
        <section class="hero">
            <div class="card card__profile">
                <div id="draw-card" class="draw-card profile-card--column op-1">
                    <div class="uma-info" id="uma-info">
                        <h2>
                            <img class="post__title-img" src="src/media/img/pfp/<?= webpExists(umaGuion($user["fav_uma"])."_Pfp", "/src/media/img/pfp/") ? e(umaGuion($user["fav_uma"])) : "invitado" ?>_Pfp.webp" alt=""> 
                            Hola, <strong class="capitalize"><?= e($user["username"]) ?></strong>     
                        </h2>
                        <br>
                        <p>Espero te guste mi pagina :D </p> 
                        <p>Tu uma favorita es <strong><?= e($user["fav_uma"]) ?>!</strong></p> 
                        <p>Sabias que te uniste a Umastagram el dia <strong><?= e($user["signup_date"]) ?>?</strong></p>
                    </div>
                    <div class="draw-card__img-container">
                        <img src="src/media/img/<?= e(getUmaImage($user["fav_uma"], 0)) ?>" class="draw-card__uma-img op-1 no-filter" alt="Imagen de un caballo">
                        <img src="src/media/img/<?= e(getUmaImage($user["fav_uma"], 1)) ?>" class="draw-card__uma-img op-1 no-filter" alt="Imagen de un caballo">
                    </div>
                </div>
                <div class="post-wrapper" id="post-wrapper">
                    <?php if ($postsData["status"] === "ok" && !empty($posts)): ?>
                        <?php foreach ($posts as $post) : ?>
                            <div class="post">
                                <?php include __DIR__."/mPost.php" ?>
                            </div>
                        <?php endforeach ?>
                    <?php else: ?>
                    <h2>No hay publicaciones :(</h2>
                    <?php endif ?>
                </div>
            </div>
        </section>
    </main>
<?php else: ?>
    <main class="muro">
        <section class="hero">
            <div class="card card-profile">
                <div id="draw-card" class="draw-card profile-card--column op-1">
                    <div class="uma-info" id="uma-info">
                        <h2>
                            <img class="post__title-img" src="src/media/img/pfp/<?= webpExists(umaGuion($user["fav_uma"])."_Pfp", "/src/media/img/pfp/") ? e(umaGuion($user["fav_uma"])) : "invitado" ?>_Pfp.webp" alt=""> 
                            Bienvenid@! Soy <strong class="capitalize"><?= e($user["username"]) ?></strong>     
                        </h2>
                        <br>
                        <p>Mi uma favorita es <strong><?= e($user["fav_uma"]) ?></strong></p> 
                        <p>Me uni a Umastagram el dia <strong><?= e($user["signup_date"]) ?></strong></p>
                    </div>
                    <div class="draw-card__img-container">
                        <img src="src/media/img/<?= e(getUmaImage($user["fav_uma"], 0)) ?? "xd" ?>" class="draw-card__uma-img op-1 no-filter" alt="Imagen de un caballo">
                        <img src="src/media/img/<?= e(getUmaImage($user["fav_uma"], 1)) ?? "xd" ?>" class="draw-card__uma-img op-1 no-filter" alt="Imagen de un caballo">
                    </div>
                </div>

                <div class="post-wrapper" id="post-wrapper">
                    <?php if ($postsData["status"] === "ok" && !empty($posts)): ?>
                        <?php foreach ($posts as $post) : ?>
                            <div class="post">
                                <?php include __DIR__."/mPost.php" ?>
                            </div>
                        <?php endforeach ?>
                    <?php else: ?>
                    <h2>No hay publicaciones :(</h2>
                    <?php endif ?>
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