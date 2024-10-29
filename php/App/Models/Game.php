<?php
namespace Joc4enRatlla\Models;

use Joc4enRatlla\Models\Board;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\JocInterface;

/**
 * Clase Game
 *
 * Esta clase representa un juego del Cuatro en Ralla.
 */
class Game implements JocInterface{
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
    public function __construct(Player $jugador1, Player $jugador2){
        $this->board = new Board();
        $this->players = [1 => $jugador1, 2 => $jugador2];
        $this->nextPlayer = 1;
        $this->winner = null;

        if (isset($_SESSION['scores'])) {
            $this->scores = $_SESSION['scores'];
        } else {
            $_SESSION['scores'] = $this->scores;
        }
    }

    /**
     * Devuelve el tablero del juego.
     * @return Board
     */
    public function getBoard(): Board {
        return $this->board;
    }

    /**
     * Devuelve los jugadores del juego.
     * @return int
     */
    public function getPlayers() : array {
        return $this->players;
    }

    /**
     * Devuelve el jugador ganador, si lo hay.
     * @return Player|null
     */
    public function getWinner() : ?Player {
        return $this->winner;
    }

    /**
     * Devuelve las puntuaciones de los jugadores.
     * @return int[]
     */
    public function getScores() : array {
        return $this->scores;
    }

    /**
     * Devuelve el jugador que tiene el siguiente turno.
     * @return int
     */
    public function getNextPlayer() : int {
        return $this->nextPlayer;
    }

    /**
     * Establece el ganador del juego.
     * @param Player $winner El jugador ganador.
     */
    public function setWinner($winner){
        $this->winner = $winner;
    }

    /**
     * Establece las puntuaciones de los jugadores.
     * @param int[] $scores Las puntuaciones de los jugadores.
     */
    public function setScores($scores){
        $this->scores = $scores;
    }

    /**
     * Reinicia el juego.
     *
     * @return void
     */
    public function reset() : void {
        $this->board = new Board();
        $this->nextPlayer = 1;
        $this->winner = null;
    }

    /**
     * Realiza un movimiento en el juego.
     *
     * @param int $columna La columna donde el jugador quiere colocar su ficha.
     * @return array Las coordenadas del movimiento.
     */
    public function play($columna) : array {
        $coordenades = $this->board->setMovementOnBoard($columna, $this->nextPlayer);
        if ($this->board->checkWin($coordenades)) {
            $this->winner = $this->players[$this->nextPlayer];
            $this->scores[$this->nextPlayer]++;
            $_SESSION['scores'] = $this->scores; // Actualizar los puntajes en la sesión
        }
        $this->nextPlayer = $this->nextPlayer === 1 ? 2 : 1;
        return $coordenades;
    }

    /**
     * Realiza un movimiento automático para el jugador actual.
     *
     * @return void
     */
    public function playAutomatic(){
        $opponent = $this->nextPlayer === 1 ? 2 : 1;

        for ($col = 0; $col <= Board::COLUMNS-1; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone($this->board);
                $coord = $tempBoard->setMovementOnBoard($col, $this->nextPlayer);

                if ($tempBoard->checkWin($coord)) {
                    
                    return $this->play($col);
                }
            }
        }

        for ($col = 0; $col <= Board::COLUMNS-1; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone($this->board);
                $coord = $tempBoard->setMovementOnBoard($col, $opponent);
                if ($tempBoard->checkWin($coord )) {
                    
                    return $this->play($col);
                }
            }
        }

        $possibles = array();
        for ($col = 0; $col <= Board::COLUMNS-1; $col++) {
            if ($this->board->isValidMove($col)) {
                $possibles[] = $col;
            }
        }
        $random = 0;
        if (count($possibles)>2) {
            $random = rand(-1,1);
        }
        $middle = (int) (count($possibles) / 2)+$random;
        $inthemiddle = $possibles[$middle];
        return $this->play($inthemiddle);
    }
    
    /**
     * Guarda el estado del juego en la sesión.
     *
     */
    public function save() : string{
        return serialize($this);
    }

    /**
     * Restaura el estado del juego desde la sesión.
     *
     * @return Game
     */
    public static function restore() : Game {
        return unserialize($_SESSION['game']);
    }

}