<?php 

session_start();

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/app/config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $formulario = $_POST["form"] ?? "";
    switch ($formulario) {
        case "login":
            $auth = new \app\controllers\AuthController($pdo);
            $auth->iniciarSesion();
        break;

        case "registro":
            $auth = new \app\controllers\AuthController($pdo);
            $auth->registrarUsuario();
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
        include __DIR__."/app/view/logout.php";
        break;

    default: 
        include __DIR__."/app/view/home.php";
        break;
    }
