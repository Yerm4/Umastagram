<?php 
declare(strict_types=1);
session_start([
    'cookie_lifetime' => 0,
    'cookie_secure'   => false,
    'cookie_httponly' => true
]);
define('APP_VERSION', '1.4');

header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once __DIR__."/../vendor/autoload.php";

$env = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$env->load();

use app\controller\ApiController;
use app\controller\ViewController;

$path = isset($_GET["path"]) ? trim ($_GET["path"], "/") : "home";
$httpMethod = !empty($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "";

$apiController = new ApiController($path, $httpMethod);

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
    $viewController = new ViewController();
    $viewController->$controllerFunc($pathExploited);
} else {
    include __DIR__."/../app/view/404.php";
}