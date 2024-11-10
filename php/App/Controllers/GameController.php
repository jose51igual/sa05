<?php
namespace Joc4enRatlla\Controllers;

use Exception;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Models\Board;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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
    public function play(array $request){

        $this->startGame();

        try{
            $this->newMovement($request);
        }catch(Exception $e){
            $_SESSION['errors'][] = $e->getMessage();
        }

        $board = $this->game->getBoard();
        $players = $this->game->getPlayers();
        $winner = $this->game->getWinner();
        $scores = $this->game->getScores();

        $nextPlayer = $this->game->getNextPlayer();

        $_SESSION['game'] = $this->game->save();
        $_SESSION['scores'] = $scores;

        loadView('game',compact('board','players','winner','scores','nextPlayer'));
    }

    /**
     * Inicia el juego.
     * 
     * @return void
     */
    private function startGame(){
        if(isset($_SESSION['game']) && isset($_SESSION['players'])){
            $this->game = Game::restore();
        }else{

            if(isset($_SESSION['players'])){
                $players = unserialize($_SESSION['players']);
                $player1 = $players['player1'];
                $player2 = $players['player2'];
            }else{
            $player1 = new Player('Jugador 1', 'red');
            $player2 = new Player('Jugador 2', 'blue');
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
    public function newMovement(array $request) : void{
        if(isset($request['col']) && is_numeric($request['col'])){
            $column = $request['col'];

            if (!isset($_SESSION['errors'])) {
                $_SESSION['errors'] = [];
            }

            if ($this->game->getWinner() !== null) {
                $_SESSION['errors'][] = 'El juego ya ha terminado.';
            }elseif(!$this->game->getBoard()->isValidMove($column)){
                $_SESSION['errors'][] = 'Columna plena';
            } elseif($column < 0 || $column > Board::COLUMNS-1){
                $_SESSION['errors'][] = 'Columna no valida';
            } else {
                $coords = [];
                if($this->game->getPlayers()[2]->isAutomatic()){
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
     * Devuelve el juego (Utilizado para los tests).
     * 
     * @return Game
     */
    public function getGame(){
        return $this->game;
    }
}