<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../Helpers/functions.php';
use Joc4enRatlla\Controllers\GameController;
use Joc4enRatlla\Controllers\JugadorController;

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'exit'){
    unset($_SESSION['user']);
    unset($_SESSION['game']);
    unset($_SESSION['scores']);
    unset($_SESSION['players']);
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'reset'){
    unset($_SESSION['game']);
}

if (isset($_SESSION['user']) && (!isset($_SESSION['players']))){
    $playerController = new JugadorController($_POST);
}

if ((isset($_SESSION['user']) || (isset($_GET['action']) && $_GET['action'] === 'reset')) && isset($_SESSION['players'])){
    $gameController = new GameController($_POST); 
}

if (!isset($_SESSION['players'])) {
    loadView('jugador');
} else {
    loadView('game');
}
