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

    $JSON = json_decode(file_get_contents("php://input"), true);
    $formulario = $_POST["form"] ?? $JSON["form"] ?? "";

    
    $acciones = [   //Nombre del formulario -> metodo a llamar en controlador
        "login"            => "login", 
        "registro"         => "signUp",
        "publicar"         => "publicar",
        "actualizar_likes" => "actualizarLikes"
    ];

    if (array_key_exists($formulario, $acciones)) {
        $metodo = $acciones[$formulario];
        $controller = new Controller($pdo);
        
        if (method_exists($controller, $metodo)) {
            $controller->$metodo();
            exit();
        }
    }

    header("Content-Type: application/json");
    echo json_encode(["status" => "error", "message" => "Acción no válida"]);
    exit();
}

$ruta = isset($_GET["ruta"]) ? trim ($_GET["ruta"], "/") : "home";
$partesRuta = explode("/", $ruta);
$paginaActual = $partesRuta[0];

if ($paginaActual === "logout") {
    session_unset();
    session_destroy();
    header("Location: home");
    exit();
}

$paginaMostrar = __DIR__."/app/view/$paginaActual.php";
if (file_exists($paginaMostrar)) {
    include $paginaMostrar;
}   else {
    include __DIR__."/app/view/home.php";
}

function e($texto) {
    if ($texto === null) {
        return "";
    }
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function reload() {
    $url = $_SERVER["REQUEST_URI"];
    header("Location: ".$url);
    die();
}

function umaGuion($texto) {
    if ($texto === null) {
        return "";
    }
    return str_replace(" ", "_", $texto);
}