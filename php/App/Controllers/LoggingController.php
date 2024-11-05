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
                $passwd = htmlspecialchars($request['password']);
                $this->logger->info("User " . $nomUsuari . " is trying to log in.");

                $this->user = new User(1, $nomUsuari, $passwd);

                if ($this->functionsDB->getUsuari($nomUsuari, $passwd)) {
                    $this->logger->info("User " . $nomUsuari . " logged in.");

                    $_SESSION['user']['nom'] = $nomUsuari;
                    $_SESSION['user']['pass'] = $passwd;
                    if (isset($request['recordar'])) {
                        setcookie('user', $nomUsuari, time() + 3600, '/');
                    }
                    loadView('jugador');
                    exit();
                } else {
                    if ($this->functionsDB->registro($this->user)) {
                        $this->logger->info("User " . $nomUsuari . " registered.");

                        $_SESSION['user'] = $nomUsuari;
                        if (isset($request['recordar'])) {
                            setcookie('user', $nomUsuari, time() + 3600, '/');
                        }
                        loadView('jugador');
                        exit();
                    } else {
                        $this->logger->error("Error registering user " . $nomUsuari);
                        $_SESSION['errors'][] = "Error registering user.";
                        loadView('login');
                        return;
                    }
                }
            } else {
                $this->logger->error("Username or password not provided.");
                $_SESSION['errors'][] = "Debes introducir un nombre de usuario y una contraseña.";
                loadView('login');
                return;
            }
        }
    }
}