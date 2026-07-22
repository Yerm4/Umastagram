<?php 

session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use app\controllers\Controller;
use app\config\Conexion;

require_once __DIR__."/vendor/autoload.php";

$pdo = Conexion::conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $formulario = $_POST["form"] ?? "";
    switch ($formulario) {
        case "login":
            $controller = new Controller($pdo);
            $controller->iniciarSesion();
        break;

        case "registro":
            $controller = new Controller($pdo);
            $controller->registrarUsuario();
        break;

        case "publicar":
            $controller = new Controller($pdo);
            $controller->publicar();
        break;

        default:
        header("Location: home");
        break;
    }
}

$ruta = isset($_GET["ruta"]) ? trim ($_GET["ruta"], "/") : "home";
$partesRuta = explode("/", $ruta);
$paginaActual = $partesRuta[0];

switch($paginaActual) {
    case "home":
        include __DIR__."/app/view/home.php";
        break;

    case "perfil": 
        include __DIR__."/app/view/perfil.php";
        break;

    case "logout";
        session_unset();
        session_destroy();
        header("Location: home");
        break;

    default: 
        include __DIR__."/app/view/home.php";
        break;
}

function e($texto) {
    if ($texto === null) return "";
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function reload() {
    $url = $_SERVER["REQUEST_URI"];
    header("Location: ".$url);
    die();
}