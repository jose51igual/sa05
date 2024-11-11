<?php

namespace BatoiBook\Services;

require_once  $_SERVER['DOCUMENT_ROOT'] . '/../config/connection.php';

class DBService
{
    public static function connect(): \PDO
    {

        try {
            $db = new \PDO(DSN, USER, PASS);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error de connexió: " . $e->getMessage());
        }

        return $db;

    }
}