<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../Helpers/functions.php';
use Joc4enRatlla\Controllers\GameController;
use Joc4enRatlla\Controllers\JugadorController;
use Joc4enRatlla\Controllers\LoggingController;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'exit') {
    unset($_SESSION['game']);
    unset($_SESSION['scores']);
    unset($_SESSION['players']);
    unset($_SESSION['user']);
    header('Location: /');
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'reset'){
    unset($_SESSION['game']);
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'save'){
    if (isset($_SESSION['game']) && isset($_SESSION['user'])) {
        $gameController = new GameController($_POST);
        $result = $gameController->saveGame($_SESSION['game'], $_SESSION['user']->getId());
        if ($result) {
            echo "Partida guardada exitosamente.";
        } else {
            echo "Error al guardar la partida.";
        }
    }
}

if(!isset($_SESSION['user'])){
    $loggingController = new LoggingController($_POST);
}
if(!isset($_SESSION['players']) && isset($_SESSION['user'])) {
    $playerController = new JugadorController($_POST);
}elseif(isset($_SESSION['players'])){
    $gameController = new GameController($_POST);
}

