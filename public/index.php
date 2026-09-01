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

use app\config\Database;
use app\controller\ApiController;
use app\controller\ViewController;

$pdo = Database::conectar();

$apiController = new ApiController($pdo);
$viewController = new ViewController($pdo);

$method = !empty($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "";
$path = isset($_GET["path"]) ? trim ($_GET["path"], "/") : "home";

$apiPath = [
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

$apiExists = false;
$controllerFunc = null;
$apIUrlData = [];


if (isset($apiPath[$method])) {
    foreach ($apiPath[$method] as $rutaDefinida => $metodo) {
        
        // Convertimos marcadores como {id} o {username} en grupos de captura Regex ([^/]+)
        $patronRegex = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $rutaDefinida);
        // Escapamos las barras para que sea un Regex válido: ^api/users/([^/]+)$
        $patronRegex = '#^' . $patronRegex . '$#';

        
        if (preg_match($patronRegex, $path, $coincidencias)) {
            $apiExists = true;
            $controllerFunc = $metodo;
            array_shift($coincidencias);
            $apIUrlData = $coincidencias; 
            break;
        }
    }
}

if ($apiExists) {
    header("Content-Type: application/json; charset=UTF-8");

    if (method_exists($apiController, $controllerFunc)) {
        $apiController->$controllerFunc(...$apIUrlData);
        exit();
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "El método del controlador no existe"]);
        exit();
    }
}


if (str_starts_with($path, "api/")) { 
    header("Content-Type: application/json; charset=UTF-8"); 
    http_response_code(404); 
    echo json_encode([ 
        "status" => "error", 
        "message" => "La ruta: ".$path." no existe" 
        ]); 
    exit(); 
}


$pathExploited = explode("/", $path);
$currentPage = $pathExploited[0];

if ($currentPage === "logout") {
    session_unset();
    session_destroy();
    header("Location: home");
    exit();
}
$rutasWeb = [
    "home"   => "showHome",
    "profile" => "showProfile",
    "post"   => "showPost",
    "stable" => "showStable"
];

$currentPagePath = __DIR__."/../app/view/$currentPage.php";

if (file_exists($currentPagePath) && isset($rutasWeb[$currentPage])) {
    $controllerFunc = $rutasWeb[$currentPage];
    $viewController->$controllerFunc($pathExploited);
} else {
    include __DIR__."/../app/view/404.php";
}