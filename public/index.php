<?php 
declare(strict_types=1);
session_start([
    'cookie_lifetime' => 0,
    'cookie_secure'   => false,
    'cookie_httponly' => true
]);
define('APP_VERSION', '1.3');

header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once __DIR__."/../vendor/autoload.php";

$env = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$env->load();

use app\config\Conexion;
use app\controller\ApiController;
use app\controller\ViewController;

$pdo = Conexion::conectar();

$apiController = new ApiController($pdo);
$viewController = new ViewController($pdo);

$method = !empty($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "";
$ruta = isset($_GET["ruta"]) ? trim ($_GET["ruta"], "/") : "home";

$rutasApi = [
    "POST" => [
        "api/auth/login"    => "login",
        "api/users"         => "signup",
        "api/posts"         => "createPost",
        "api/posts/likes"   => "toggleLike",
        "api/comment"       => "createComment"
    ],
    "GET" => [
        "api/posts"         => "getAllPosts",
        "api/users/{username}"    => "getUser"
    ],
    "PUT" => [
        
    ],
    "PATCH" => [
        
    ],
    "DELETE" => [
        
    ]
];

$rutaEncontrada = false;
$metodoController = null;
$parametrosUrl = [];


if (isset($rutasApi[$method])) {
    foreach ($rutasApi[$method] as $rutaDefinida => $metodo) {
        
        // Convertimos marcadores como {id} o {username} en grupos de captura Regex ([^/]+)
        $patronRegex = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $rutaDefinida);
        // Escapamos las barras para que sea un Regex válido: ^api/users/([^/]+)$
        $patronRegex = '#^' . $patronRegex . '$#';

        
        if (preg_match($patronRegex, $ruta, $coincidencias)) {
            $rutaEncontrada = true;
            $metodoController = $metodo;
            array_shift($coincidencias);
            $parametrosUrl = $coincidencias; 
            break;
        }
    }
}

if ($rutaEncontrada) {
    header("Content-Type: application/json; charset=UTF-8");

    if (method_exists($apiController, $metodoController)) {
        $apiController->$metodoController(...$parametrosUrl);
        exit();
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "El método del controlador no existe"]);
        exit();
    }
}


if (str_starts_with($ruta, "api/")) { 
    header("Content-Type: application/json; charset=UTF-8"); 
    http_response_code(404); 
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
$rutasWeb = [
    "home"   => "showHome",
    "perfil" => "showProfile",
    "post"   => "showPost",
    "stable" => "showStable"
];

$paginaMostrar = __DIR__."/../app/view/$paginaActual.php";

if (file_exists($paginaMostrar) && isset($rutasWeb[$paginaActual])) {
    $metodoController = $rutasWeb[$paginaActual];
    $viewController->$metodoController($partesRuta);
} else {
    include __DIR__."/../app/view/404.php";
}