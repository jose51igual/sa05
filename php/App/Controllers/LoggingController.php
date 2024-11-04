<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use PDO;

class LoggingController {

    private $nomUsuari;
    private $password;
    private $cookieNom;
    private $logger;

    public function __construct() {
        $this->logger = new Logger('loginLogger');
        $this->logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/../logs/login.log", Level::Info));

    }

    public function login() {
        
        
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        setcookie('user', '', time() - 3600, '/'); // Clear the cookie
        $this->logger->info("User logged out.");
        loadView('login');
        exit();
    }
}