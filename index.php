<?php 

session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use app\controllers\AuthController;
use app\config\Conexion;

require_once __DIR__."/vendor/autoload.php";

$pdo = Conexion::conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $formulario = $_POST["form"] ?? "";
    switch ($formulario) {
        case "login":
            $controller = new AuthController($pdo);
            $controller->iniciarSesion();
        break;

        case "registro":
            $controller = new AuthController($pdo);
            $controller->registrarUsuario();
        break;

        case "publicar":
            $controller = new AuthController($pdo);
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
