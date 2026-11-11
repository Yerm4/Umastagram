<?php
declare(strict_types=1);
namespace app\controller;

use app\controller\BaseController;

class ApiController extends BaseController {

    public function __construct($path, $httpMethod) {

        $apiEndpoints = require __DIR__."/../endpoints.php";
        $controller = null;
        $urlData = [];
        
        if (isset($apiEndpoints[$httpMethod])) {
            foreach ($apiEndpoints[$httpMethod] as $ruta => $metodo) {
                $patronRegex = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $ruta);
                $patronRegex = '#^' . $patronRegex . '$#';
        
                if (preg_match($patronRegex, $path, $coincidencias)) {
                    [$controller, $method] = explode("@", $metodo);
                    array_shift($coincidencias);
                    $urlData = $coincidencias; 
                    break;
                }
            }
        }
        
        if ($controller && $method) {
            $controller = "app\\controller\\".$controller;
            if (class_exists($controller)) {
                header("Content-Type: application/json; charset=UTF-8");
                if (method_exists($controller, $method)) {
                    $object = new $controller;
                    $object->$method(...$urlData);
                    exit();
                } else {
                    http_response_code(500);
                    echo json_encode(["status" => "error", "message" => "El método del controlador no existe"]);
                    exit();
                }
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
    }
}