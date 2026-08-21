<?php

$postId = $partesRuta[1] ?? null;

use app\model\Model;

$titulo = null;
include_once __DIR__."/header.php";

if (!empty($partesRuta[1])) {
    $model = new Model($pdo);
    $postData = $model->getPost($postId);

    if ($postData["status"] === "ok") {
        $post = $postData["data"];
        
        $commentData = $model->getComment($postId);
        $comments = ($commentData["status"] === "ok") ? $commentData["data"] : [];
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
    <main class="muro">
        <section class="hero">
            <div class="card card__profile">
            <div class="post-wrapper" id="post-wrapper">
                    <?php if ($postData["status"] === "ok" && !empty($post)): ?>
                        <?php include __DIR__."/mPost.php" ?>
                            <div class="comments-wrapper">
                            <?php foreach ($comments as $c): ?>
                                    <div class="comment">
                                        <div class="comment__pfp">
                                            <a href="perfil/<?= e($c["username"]) ?>"> 
                                                <img class="comment__pfp-img" src="src/media/img/pfp/<?= isset($post["fav_uma"]) && fileExists(umaGuion($post["fav_uma"])."_Pfp", "/src/media/img/pfp/") ? e(umaGuion($post["fav_uma"])) : "invitado" ?>_Pfp.webp" alt="">
                                            </a>
                                        </div>
                                        <div class="comment__content">
                                            <a href="perfil/<?= e($c["username"]) ?>"> 
                                                <h3 class="comment__content-name capitalize"> 
                                                    <?= e($c["username"]) ?> 
                                                    <span class="comment__content-date"><?= e(getRelativeTime($c["date"]))?></span>
                                                </h3>
                                            </a>
                                            <p class="comment__content-description">> <?= e($c["content"])?></p>
                                        </div>
                                        <div class="comment__interaction">
                                            
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <form id="commentForm" class="form form-comment" data-post-id="<?= e($post["id"]) ?>" >
                                <div class="form-comment__wrapper">
                                    <input class="form-comment__input" placeholder="Escribe tu comentario..." type="text" name="content">
                                    <button class="form-comment__submit" type="submit">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php else: ?>
                    <h2>No hay publicaciones :(</h2>
                    <?php endif ?>
                </div>
            </div>
        </section>
    </main>

    <?php include_once __DIR__."/footer.php" ?>
    <video src="src/media/img/mambo-spinning.webm" class="mambo-wrapper__video" autoplay loop muted playsinline title="mambo"></video>
</body>
</html>
