<?php
namespace BatoiBook\Controllers\Api;

use BatoiBook\Services\DBService;
use PDOException;

class DBController{
    public function __construct()
    {
        try{
            DBService::connect();
        }catch(PDOException $e){
            die("Error de connexió: " . $e->getMessage());
        }
    }

}