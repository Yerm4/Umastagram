<?php

if (isset($_SESSION["nombre_usuario"])) {
    $nombreUsuario = $_SESSION["nombre_usuario"];
    $umaFav = $_SESSION["uma_fav"];
    $umaFavGuion = str_replace(" ", "_", $umaFav);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://umamusume.infinityfreeapp.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Uma Musume!">
    <meta property="og:description" content="Conoce un poco mas a tus umas favoritas!">
    <meta property="og:image" content="https://umamusume.infinityfreeapp.com/src/media/img/card.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="umamusume.infinityfreeapp.com">
    <meta property="twitter:url" content="https://umamusume.infinityfreeapp.com">
    <meta name="twitter:title" content="Uma Musume!">
    <meta name="twitter:description" content="Conoce un poco mas a tus umas favoritas!">
    <meta name="twitter:image" content="https://umamusume.infinityfreeapp.com/src/media/img/card.jpg">
    <meta name="author" content="Yerm4">
    <title><?= isset($titulo) ? $titulo : "Uma Musume";?></title>
    <link rel="stylesheet" href="src/css/styles.css">
    <link rel="icon" href="src/media/img/mini/favicon.ico" type="image/x-icon">
    <link rel="preload" href="src/media/img/bg.webp" as="image">
    <link rel="prefetch" href="src/media/img/modal_bg_2.webp">
    <script src="src/script/diseño.js" defer></script>
</head>

<body>
    <div class="root-container">
        <header>
            <nav>
                <div class="nav-menu-lateral">
                        <div class="nav-logo">
                        <div class="div-pfp">
                            <img class="pfp" src="src/media/img/pfp/<?= isset($umaFav) ? e($umaFavGuion) : "invitado"?>_Pfp.webp" alt="Foto de perfil">
                        </div>
                        <h1 class="item-hidden item-hidden--title"><?= isset($nombreUsuario) ? e($nombreUsuario) : "Umamusume" ?> </h1>
                    </div>
                    <div class="nav-container-items">

                        <a href="home" class="nav-item">
                            <svg class="nav-item-logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 16C15 15.2044 14.6839 14.4413 14.1213 13.8787C13.5587 13.3161 12.7957 13 12 13C11.2044 13 10.4413 13.3161 9.87868 13.8787C9.31607 14.4413 9 15.2043 9 16V20H4L4 10L8 6.5M12 3L20 10L20 20H15" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="item-hidden">Home</p>
                        </a>

                        <?php if (!isset($_SESSION["nombre_usuario"])): ?>
                        <a name="buttonModal" data-modal="registroModal" href="#" class="nav-item">
                            <svg class="nav-item-logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17,21V19a4,4,0,0,0-4-4H5a4,4,0,0,0-4,4v2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <circle cx="9" cy="7" r="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <line x1="17" y1="11" x2="23" y2="11" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <line x1="20" y1="8" x2="20" y2="14" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                            <p class="item-hidden">Registrate</p>
                        </a>

                        <a name="buttonModal" data-modal="loginModal" href="#" class="nav-item">
                            <svg class="nav-item-logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.56,18.35,9,17.05a1,1,0,0,1-.11-1.41L10.34,14H3V10h7.34L8.93,8.36A1,1,0,0,1,9,7l1.52-1.3A1,1,0,0,1,12,5.76l4.79,5.59a1,1,0,0,1,0,1.3L12,18.24A1,1,0,0,1,10.56,18.35ZM17,4h3a1,1,0,0,1,1,1V19a1,1,0,0,1-1,1H17"
                                stroke-linecap= "round" stroke-linejoin="round" stroke-width= "1.5"/>
                            </svg>
                            <p class="item-hidden">Login</p>
                        </a> 
                        <?php endif; ?>

                        <?php if (isset($_SESSION["nombre_usuario"])): ?>
                        <a href="perfil" class="nav-item">
                            <svg class="nav-item-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="800" height="800" fill="#000000">
                                <path d="M10,12 C13.785,12 16.958,14.214 17.784,18 L2.216,18 C3.042,14.214 6.215,12 10,12 M6,6 C6,3.794 7.794,2 10,2 C12.206,2 14,3.794 14,6 C14,8.206 12.206,10 10,10 C7.794,10 6,8.206 6,6 M13.758,10.673 C15.124,9.574 16,7.89 16,6 C16,2.686 13.314,0 10,0 C6.686,0 4,2.686 4,6 C4,7.89 4.876,9.574 6.242,10.673 C2.583,12.048 0,15.445 0,19 L20,19 C20,15.445 17.417,12.048 13.758,10.673"/>
                            </svg>
                            <p class="item-hidden">Perfil</p>
                        </a>
                        
                        <a href="logout" class="nav-item"> 
                            <svg class="nav-item-logo" viewBox="0 -0.5 25 25" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.04401 9.53165C7.33763 9.23949 7.33881 8.76462 7.04665 8.47099C6.75449 8.17737 6.27962 8.17619 5.98599 8.46835L7.04401 9.53165ZM2.97099 11.4683C2.67737 11.7605 2.67619 12.2354 2.96835 12.529C3.26051 12.8226 3.73538 12.8238 4.02901 12.5317L2.97099 11.4683ZM4.02901 11.4683C3.73538 11.1762 3.26051 11.1774 2.96835 11.471C2.67619 11.7646 2.67737 12.2395 2.97099 12.5317L4.02901 11.4683ZM5.98599 15.5317C6.27962 15.8238 6.75449 15.8226 7.04665 15.529C7.33881 15.2354 7.33763 14.7605 7.04401 14.4683L5.98599 15.5317ZM3.5 11.25C3.08579 11.25 2.75 11.5858 2.75 12C2.75 12.4142 3.08579 12.75 3.5 12.75V11.25ZM17.5 12.75C17.9142 12.75 18.25 12.4142 18.25 12C18.25 11.5858 17.9142 11.25 17.5 11.25V12.75ZM5.98599 8.46835L2.97099 11.4683L4.02901 12.5317L7.04401 9.53165L5.98599 8.46835ZM2.97099 12.5317L5.98599 15.5317L7.04401 14.4683L4.02901 11.4683L2.97099 12.5317ZM3.5 12.75L17.5 12.75V11.25L3.5 11.25V12.75Z"/>
                                <path d="M9.5 15C9.5 17.2091 11.2909 19 13.5 19H17.5C19.7091 19 21.5 17.2091 21.5 15V9C21.5 6.79086 19.7091 5 17.5 5H13.5C11.2909 5 9.5 6.79086 9.5 9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <p class="item-hidden">Logout</p>
                        </a>
                        <?php endif; ?>
                        <div class="container-modo-oscuro">
                            <svg class="boton-modo-oscuro logo-claro" id="modo-claro" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3V4M12 20V21M4 12H3M6.31412 6.31412L5.5 5.5M17.6859 6.31412L18.5 5.5M6.31412 17.69L5.5 18.5001M17.6859 17.69L18.5 18.5001M21 12H20M16 12C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg class="boton-modo-oscuro" id="modo-oscuro" fill="#000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                <path d="M504.929,323.637c-6.955-6.953-17.436-8.995-26.489-5.16c-26.922,11.403-55.471,17.185-84.859,17.185c-58.032,0-112.586-22.597-153.618-63.63c-62.92-62.918-81.149-156.525-46.442-238.474c3.835-9.057,1.793-19.534-5.162-26.487c-6.953-6.955-17.434-8.992-26.487-5.157c-31.495,13.343-59.788,32.433-84.093,56.74C27.616,108.815-0.006,175.506,0,246.443c0.006,70.927,27.63,137.61,77.785,187.767C127.948,484.374,194.643,512,265.58,512c70.926,0,137.61-27.622,187.767-77.779c24.308-24.308,43.397-52.6,56.74-84.093C513.923,341.071,511.883,330.593,504.929,323.637z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </nav>
        </header>