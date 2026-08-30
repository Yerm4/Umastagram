<?php
if (empty($_SESSION["user_id"])) {

    include __DIR__."/modals/mRegistro.php";
    include __DIR__."/modals/mLogin.php"; 
}
?>

<footer>
    <p>Este es un proyecto sin fines de lucro creado por un fan. Todos los derechos de los personajes e imágenes pertenecen a Cygames. No tengo afiliación oficial con el juego.</p>
    <p>This is a non-profit fanmade project. All characters and images are property of Cygames. I have no official afilitaion with the game nor their developers.</p>
    <a class="underline" href="https://github.com/Yerm4/Umastagram"> Link a mi repositorio de Github</a>
</footer>