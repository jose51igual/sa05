<?php
namespace Joc4enRatlla\Controllers;

use Exception;
require_once $_SERVER['DOCUMENT_ROOT'] . '/../Helpers/functionsController.php';
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Models\Board;

/**
 * Clase GameController
 *
 * Esta clase controla el juego del Cuatro en Ralla.
 */
class GameController{

    /**
     * El juego del Cuatro en Ralla.
     *
     * @var Game
     */
    private Game $game;

    /**
     * Constructor de la clase GameController.
     *
     * @param array $request Los datos de la petición.
     */
    public function __construct($request=null){
        $this->play($request);
    }

    /**
     * Inicia y controla el juego.
     * 
     * @param array $request Los datos de la petición.
     * 
     * @return void
     */
    public function play(Array $request){
        $this->startGame($request);
        $this->setPlayers($request);
        $this->newMovement($request);

        $board = $this->game->getBoard();
        $players = $this->game->getPlayers();
        $winner = $this->game->getWinner();
        $scores = $this->game->getScores();

        $_SESSION['game'] = $this->game->save();
        loadView('index',compact('board','players','winner','scores'));
    }

    /**
     * Inicia el juego.
     * 
     * @param array $request Los datos de la petición.
     * 
     * @return void
     */
    private function startGame(Array $request){
        if(isset($_SESSION['game']) && isset($_SESSION['players'])){
            $this->game = Game::restore();
        }else{
            $player1 = new Player('Jugador 1', 'red');
            $player2 = new Player('Jugador 2', 'blue');

            if(isset($_SESSION['players'])){
                $players = unserialize($_SESSION['players']);
                $player1 = $players['player1'];
                $player2 = $players['player2'];
            }

            $this->game = new Game($player1, $player2);
        }
    }

    /**
     * Realiza un nuevo movimiento en el juego.
     * 
     * @param array $request Los datos de la petición.
     * 
     * @return void
     */
    public function newMovement(Array $request) : void{
        if(isset($request['column']) && is_numeric($request['column'])){
            $column = $request['column'];

            if (!isset($_SESSION['errors'])) {
                $_SESSION['errors'] = [];
            }

            if(!$this->game->getBoard()->isValidMove($column)){
                $_SESSION['errors'][] = 'Columna plena';
            } elseif($column < 0 || $column > Board::COLUMNS-1){
                $_SESSION['errors'][] = 'Columna no valida';
            } else {
                $coords = [];
                if($this->game->getPlayers()[2]->IsAutomatic()){
                    $coords = ($this->game->getNextPlayer() === 1) ? $this->game->play($column) : $this->game->playAutomatic();
                } else {
                    $coords = $this->game->play($column);
                }
                if($this->game->getBoard()->checkWin($coords)){
                    $this->game->setWinner($this->game->getPlayers()[$this->game->getNextPlayer() === 1 ? 2 : 1]);
                }
            }
        }
    }

    /**
     * Guarda los jugadores en la sesión.
     * 
     * @param array $request Los datos de la petición.
     * 
     * @throws Exception Si no se han enviado los datos necesarios.
     * 
     * @return void
     */
    public function setPlayers(Array $request) : void {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' || $request === null || isset($request['user'])) {
            try {
                loadView('player');
            } catch (\Exception $e) {
                $_SESSION['errors'][] = $e->getMessage();
            }
            //loadView('player'); 
            return;
        }
        comprobaciones();
        $players = [
            'player1' => new Player(
                (isset($request['player1']) ? $request['player1'] : 'Player 1'),
                (isset($request['player1-color']) ? $request['player1-color'] : 'red'),
            ),
            'player2' => new Player(
                (isset($request['player2']) ? $request['player2'] : 'Player 3'),
                (isset($request['player2-color'])? $request['player2-color'] : 'yellow'),
                ((isset($request['player2_isAutomatic']) && $request['player2_isAutomatic'] === 'true') ? true : false),
                )
        ];
        $_SESSION['players'] = serialize($players);
    }
}