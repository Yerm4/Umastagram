<?php 
namespace app\controller;

class BaseController {

    protected function jsonResponse($code, $status, $message = "", $data = null, $redirect = null) {
        http_response_code($code);
        header("Content-Type: application/json");
        echo json_encode([
            "code" => $code,
            "status" => $status,
            "message" => $message,
            "data" => $data,
            "redirect" => $redirect
        ]);
        exit();
    }

    protected function getData(): array {
        $raw = file_get_contents("php://input");
        $jsonData = json_decode($raw, true);
        if (is_array($jsonData)) {
            return $jsonData;
        }
        return [];
    }
}