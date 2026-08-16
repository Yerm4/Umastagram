<?php 

session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use app\config\Conexion;
use app\controller\Controller;
use app\model\Model;

require_once __DIR__."/../vendor/autoload.php";
$env = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$env->load();
$pdo = Conexion::conectar();

$method = !empty($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "";
$ruta = isset($_GET["ruta"]) ? trim ($_GET["ruta"], "/") : "home";

$rutasApi = [
    "POST" => [
        "api/auth/login"    => "login",
        "api/users" => "signup",
        "api/posts"    => "publicar",
        "api/posts/likes"    => "actualizarLikes",
    ],
    "GET" => [
        "api/posts"    => "obtenerPosts",
    ],
    "PUT" => [

    ],
    "PATCH" => [

    ],
    "DELETE" => [
        
        ]
    
];

if (isset($rutasApi[$method][$ruta])) {
    header("Content-Type: application/json; charset=UTF-8");
    
    $metodoController = $rutasApi[$method][$ruta];
    $controller = new Controller($pdo);

    if (method_exists($controller, $metodoController)) {
        $controller->$metodoController();
        exit();
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "El método del controlador no existe"]);
        exit();
    }
}

if (str_starts_with($ruta, "api/")) { 
    header("Content-Type: application/json; 
    charset=UTF-8"); http_response_code(400); 
    echo json_encode([ 
        "status" => "error", 
        "message" => "La ruta: ".$ruta." no existe" 
        ]); 
    exit(); 
}

$partesRuta = explode("/", $ruta);
$paginaActual = $partesRuta[0];

if ($paginaActual === "logout") {
    session_unset();
    session_destroy();
    header("Location: home");
    exit();
}

$paginaMostrar = __DIR__."/../app/view/$paginaActual.php";
if (file_exists($paginaMostrar)) {
    include $paginaMostrar;
}   else {
    include __DIR__."/../app/view/home.php";
}

// Helper functions

function e($texto) {
    if ($texto === null) {
        return "";
    }
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
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

function fileExists(?string $file, string $ruta = "/src/media/img/post/") : bool {
    if (empty($file)) {
        return false;
    }
    
    return file_exists(__DIR__.$ruta.$file.".webp");
}

function code($num) {
    if ($num === null) {
        return "";
    }
    return http_response_code($num);
}