<?php
namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;

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

    private function isValidNewMovement($request){
        return isset($request['column']) && is_numeric($request['column']) && $request['column'] >= 0 && $request['column'] < 7;
    }

    /**
     * Método play
     *
     * Este método se encarga de jugar una partida del Cuatro en Ralla.
     *
     * @param array $request Los datos de la petición.
     */
    public function play(Array $request){
        $board = $this->game->getBoard();
        $players = $this->game->getPlayers();
        $winner = $this->game->getWinner();
        $scores = $this->game->getScores();

        loadView('index',compact('board','players','winner','scores'));
    }

    
    private function startGame(){
        if(isset($_SESSION['game'])){
            $this->game = Game::restore();
        }else{
            $player1 = new Player('Jugador 1', 'red');
            $player2 = new Player('Jugador 2', 'yellow');
            if(isset($_SESSION['players'])){
                $players = unserialize($_SESSION['players']);
                $player1 = $players['player1'];
                $player2 = $players['player2'];
            }
            $this->game = new Game($player1, $player2);
        }
    }

    private function startScores(){
        if(isset($_SESSION['scores'])){
            $this->game->setScores(unserialize($_SESSION['scores']));
        }
    }


}