<?php
namespace Joc4enRatlla\Models;

use Joc4enRatlla\Models\Board;
use Joc4enRatlla\Models\Player;

/**
 * Clase Game
 *
 * Esta clase representa un juego del Cuatro en Ralla.
 */
class Game
{
    /**
     * El tablero del juego.
     *
     * @var Board
     */
    private Board $board;

    /**
     * El jugador que tiene el siguiente turno.
     *
     * @var int
     */
    private int $nextPlayer;

    /**
     * Los jugadores del juego.
     *
     * @var Player[]
     */
    private array $players;

    /**
     * El jugador ganador, si lo hay.
     *
     * @var Player|null
     */
    private ?Player $winner;

    /**
     * Las puntuaciones de los jugadores.
     *
     * @var int[]
     */
    private array $scores = [1 => 0, 2 => 0];

    /**
     * Constructor de la clase Game.
     *
     * @param Player $jugador1 El primer jugador.
     * @param Player $jugador2 El segundo jugador.
     */
    public function __construct( Player $jugador1, Player $jugador2){
        $this->board = new Board();
        $this->players = [$jugador1, $jugador2];
        $this->nextPlayer = 1;
        $this->winner = null;
    }

    /**
     * Devuelve el tablero del juego.
     */
    public function getBoard(){
        return $this->board;
    }

    /**
     * Devuelve el jugador que tiene el siguiente turno.
     */
    public function getPlayers(){
        return $this->players;
    }

    /**
     * Devuelve el jugador ganador, si lo hay.
     */
    public function getWinner(){
        return $this->winner;
    }

    /**
     * Devuelve las puntuaciones de los jugadores.
     */
    public function getScores(){
        return $this->scores;
    }

    /**
     * Reinicia el juego.
     *
     * @return void
     */
    public function reset(){
        $this->board = new Board();
        $this->nextPlayer = 1;
        $this->winner = null;
    }

    /**
     * Realiza un movimiento en el juego.
     *
     * @param int $columna La columna donde el jugador quiere colocar su ficha.
     * @return void
     */
    public function play($columna){
        $coordenades = $this->board->setMovementOnBoard($columna, $this->nextPlayer);
        if ($this->board->checkWin($coordenades)) {
            $this->winner = $this->players[$this->nextPlayer - 1];
            $this->scores[$this->nextPlayer]++;
        }
        $this->nextPlayer = $this->nextPlayer === 1 ? 2 : 1;
    }

    /**
     * Realiza un movimiento automático para el jugador actual.
     *
     * @return void
     */
    public function playAutomatic(){
        $opponent = $this->nextPlayer === 1 ? 2 : 1;

        for ($columna = 1; $columna <= Board::COLUMNS; $columna++) {
            if ($this->board->isValidMove($columna)) {
                $tempBoard = clone($this->board);
                $coordenades = $tempBoard->setMovementOnBoard($columna, $this->nextPlayer);

                if ($tempBoard->checkWin($coordenades)) {
                    $this->play($columna);
                    return;
                }
            }
        }

        for ($columna = 1; $columna <= Board::COLUMNS; $columna++) {
            if ($this->board->isValidMove($columna)) {
                $tempBoard = clone($this->board);
                $coordenades = $tempBoard->setMovementOnBoard($columna, $opponent);
                if ($tempBoard->checkWin($coordenades )) {
                    $this->play($columna);
                    return;
                }
            }
        }

        $possibles = array();
        for ($columna = 1; $columna <= Board::COLUMNS; $columna++) {
            if ($this->board->isValidMove($columna)) {
                $possibles[] = $columna;
            }
        }
        if (count($possibles)>2) {
            $random = rand(-1,1);
        }
        $middle = (int) (count($possibles) / 2)+$random;
        $inthemiddle = $possibles[$middle];
        $this->play($inthemiddle);
    }
    
    /**
     * Guarda el estado del juego en la sesión.
     *
     * @return void
     */
    public function save(){
        $_SESSION['game'] = serialize($this);
    }

    /**
     * Restaura el estado del juego desde la sesión.
     *
     * @return Game
     */
    public static function restore(){
        return unserialize($_SESSION['game']);
    }

}