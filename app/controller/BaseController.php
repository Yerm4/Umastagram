<?php 
namespace app\controller;

class BaseController {

    protected function jsonResponse($status, $message = "", $data = null, $redirect = null) {
        header("Content-Type: application/json");
        echo json_encode([
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