<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../Helpers/functions.php';
use Joc4enRatlla\Controllers\GameController;
use Joc4enRatlla\Controllers\JugadorController;
use Joc4enRatlla\Controllers\LoggingController;
use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Services\FunctionsDB;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'exit':
            unset($_SESSION['game'], $_SESSION['scores'], $_SESSION['players'], $_SESSION['user']);
            header('Location: /');
            exit;
        case 'reset':
            unset($_SESSION['game']);
            break;
        case 'save':            
            $functionsDB = new FunctionsDB();
            $game = $_SESSION['game'];
            $user_id = $_SESSION['user']['id'];
            $functionsDB->saveJoc($game, $user_id);
            setcookie('players', $_SESSION['players'], time() + 3600);
            echo '<h1>Partida guardada</h1>';
            break;
            case 'loadGame':
                $functionsDB = new FunctionsDB();
                $game = $functionsDB->getJoc($_SESSION['user']['id']);
                if ($game) {
                    $_SESSION['game'] = $game;
                    $_SESSION['players'] = $_COOKIE['players'];
                    
                } else {
                    $_SESSION['errors'][] = 'No hay ninguna partida guardada';
                }
                break;
        case 'newGame':
            unset($_SESSION['game'], $_SESSION['scores'], $_SESSION['players']);
            break;
        default:
            break;
    }
}


if (!isset($_SESSION['user'])) {
    $loggingController = new LoggingController($_POST);
    exit();
}
if (!isset($_SESSION['players']) && !isset($_SESSION['game'])) {
    $playerController = new JugadorController($_POST);
    exit();
}

if (isset($_SESSION['players']) || isset($_SESSION['game'])) {
    $gameController = new GameController($_POST);
    exit();
}