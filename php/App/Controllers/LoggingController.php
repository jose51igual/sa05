<?php

namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Models\User;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Joc4enRatlla\Services\FunctionsDB;

class LoggingController {

    private User $user;
    private FunctionsDB $functionsDB;
    private $logger;

    public function __construct($request = null) {
        $this->functionsDB = new FunctionsDB();
        $this->logger = new Logger('loginLogger');
        $this->logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/../logs/login.log", Level::Info));
        try{
            $this->login($request);
        }catch(\Throwable $th){
            $this->logger->error($th->getMessage());
            loadView('login');
            return;
        } 
    }

    public function login(array $request = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' || !$request) {
            loadView('login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($request['nom_usuari']) && $request['nom_usuari'] != "" && isset($request['password']) && $request['password'] != "") {
                $nomUsuari = htmlspecialchars($request['nom_usuari']);
                $password = htmlspecialchars($request['password']); 
                $this->logger->info("User " . $nomUsuari . " is trying to log in.");
                $userDB = $this->functionsDB->getUsuari($nomUsuari, $password);

                if(!$userDB){
                    $registro = $this->functionsDB->registro($nomUsuari, $password);
                    if($registro){
                        $userDB = $this->functionsDB->getUsuari($nomUsuari, $password);
                        $this->logger->info("User " . $nomUsuari . " registered.");
                        $_SESSION['user']['nom'] = $nomUsuari;
                        $_SESSION['user']['id'] = intval($userDB->getId());
                        $_SESSION['user']['passwd'] = $password;
                        if (isset($request['recordar'])) {
                            setcookie('user', $nomUsuari, time() + 3600, '/');
                        }
                        loadView('welcome');
                        exit();
                    }
                    
                }elseif ($userDB && password_verify($password, $userDB->getPasswd())) {
                    $this->logger->info("User " . $nomUsuari . " logged in.");
                    $_SESSION['user']['nom'] = $nomUsuari;
                    $_SESSION['user']['id'] = intval($userDB->getId());
                    $_SESSION['user']['passwd'] = $password;
                    if (isset($request['recordar'])) {
                        setcookie('user', $nomUsuari, time() + 3600, '/');
                    }
                    loadView('welcome');
                    exit();
                }else{
                    $this->logger->error("Contrasenya Incorrecta: " . $nomUsuari);
                    $_SESSION['errors'][] = "Contrasenya Incorrecta";
                    loadView('login');
                    return;
                }
            }
        }else{
            $this->logger->error("Username or password not provided.");
            $_SESSION['errors'][] = "Debes introducir un nombre de usuario y una contraseña.";
            loadView('login');
            return;
        }
    }
}