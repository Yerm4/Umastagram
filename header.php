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
    <title><?php echo isset($titulo) ? $titulo : "Uma Musume";?></title>
    <link rel="stylesheet" href="src/css/styles.css">
    <link rel="icon" href="src/media/img/mini/favicon.ico" type="image/x-icon">
    <link rel="preload" href="src/media/img/bg.webp" as="image">
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "w9ok98thq3");
    </script>
    <script src="src/script/diseño.js" defer></script>
</head>

<body>
    <div class="root-container">
        <header>
            <nav>
                <div class="nav-menu-lateral">
                    <div class="nav-logo">
                        <div class="container-modo-oscuro">
                            <svg class="boton-modo-oscuro" id="modo-claro" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3V4M12 20V21M4 12H3M6.31412 6.31412L5.5 5.5M17.6859 6.31412L18.5 5.5M6.31412 17.69L5.5 18.5001M17.6859 17.69L18.5 18.5001M21 12H20M16 12C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg class="boton-modo-oscuro" id="modo-oscuro" fill="#000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                <path d="M504.929,323.637c-6.955-6.953-17.436-8.995-26.489-5.16c-26.922,11.403-55.471,17.185-84.859,17.185c-58.032,0-112.586-22.597-153.618-63.63c-62.92-62.918-81.149-156.525-46.442-238.474c3.835-9.057,1.793-19.534-5.162-26.487c-6.953-6.955-17.434-8.992-26.487-5.157c-31.495,13.343-59.788,32.433-84.093,56.74C27.616,108.815-0.006,175.506,0,246.443c0.006,70.927,27.63,137.61,77.785,187.767C127.948,484.374,194.643,512,265.58,512c70.926,0,137.61-27.622,187.767-77.779c24.308-24.308,43.397-52.6,56.74-84.093C513.923,341.071,511.883,330.593,504.929,323.637z"/>
                            </svg>
                        </div>
                        <h2 class="item-hidden ">Uma Musume</h2>
                    </div>
                    <div class="nav-container-items">

                        <a href="index.php" class="nav-item">
                            <svg class="nav-item-logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 16C15 15.2044 14.6839 14.4413 14.1213 13.8787C13.5587 13.3161 12.7957 13 12 13C11.2044 13 10.4413 13.3161 9.87868 13.8787C9.31607 14.4413 9 15.2043 9 16V20H4L4 10L8 6.5M12 3L20 10L20 20H15" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="item-hidden">Home</p>
                        </a>

                        <a href="registro.php" class="nav-item">
                        <svg class="nav-item-logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17,21V19a4,4,0,0,0-4-4H5a4,4,0,0,0-4,4v2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            <circle cx="9" cy="7" r="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            <line x1="17" y1="11" x2="23" y2="11" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            <line x1="20" y1="8" x2="20" y2="14" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                            <p class="item-hidden">Registrate</p>
                        </a>

                        <a href="login.php" target="" class="nav-item">
                            <svg class="nav-item-logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.56,18.35,9,17.05a1,1,0,0,1-.11-1.41L10.34,14H3V10h7.34L8.93,8.36A1,1,0,0,1,9,7l1.52-1.3A1,1,0,0,1,12,5.76l4.79,5.59a1,1,0,0,1,0,1.3L12,18.24A1,1,0,0,1,10.56,18.35ZM17,4h3a1,1,0,0,1,1,1V19a1,1,0,0,1-1,1H17"
                                stroke-linecap= "round" stroke-linejoin= "round" stroke-width= "1.5"/>
                            </svg>
                            <p class="item-hidden">Inicia sesion</p>
                        </a>
                        
                    </div>
                </div>
            </nav>
        </header>