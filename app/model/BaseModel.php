<?php
namespace app\model;
use app\config\Database;

class BaseModel {
    protected $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();        
    }
}