<?php

namespace Joc4enRatlla\Models;

/**
 * Clase Board
 *
 * Esta clase representa el tablero de juego del cuatro en ralla.
 * 
 */
class Board
{
    /**
     * Número de filas en el tablero.
     */
    public const FILES = 6;

    /**
     * Número de columnas en el tablero.
     */
    public const COLUMNS = 7;

    /**
     * Direcciones para verificar las condiciones de victoria.
     */
    public const DIRECTIONS = [
        [0, 1],   // Horizontal derecha
        [1, 0],   // Vertical abajo
        [1, 1],   // Diagonal abajo-derecha
        [1, -1]   // Diagonal abajo-izquierda
    ];

    /**
     * La cuadrícula que representa el tablero.
     *
     * @var array
     */
    private array $graella;

    /**
     * Constructor de la clase Board.
     *
     * Inicializa el tablero con espacios vacíos.
     */
    public function __construct()
    {
        $this->graella = array_fill(0, self::FILES, array_fill(0, self::COLUMNS, ''));
    }


    /**
     * Establece un movimiento en el tablero.
     *
     * @param int $column La columna donde el jugador quiere colocar su ficha.
     * @param int $player El número del jugador.
     * @return array Las coordenadas del movimiento.
     */
    public function setMovementOnBoard(int $column, int $player): array
    {
        for ($i = self::FILES - 1; $i >= 0; $i--) {
            if ($this->graella[$i][$column] == '') {
                $this->graella[$i][$column] = $player;
                return [$i, $column];
            }
        }
    }

    /**
     * Comprueba si el tablero está lleno.
     *
     * @return bool True si el tablero está lleno, false en caso contrario.
     */
    public function isValidMove(int $column): bool
    {
        return $this->graella[0][$column] == '';
    }

    /**
     * Comprueba si hay un ganador en el tablero.
     *
     * @param array $coord Las coordenadas del último movimiento.
     * @return bool True si hay un ganador, false en caso contrario.
     */
    public function checkWin(array $coord): bool
    {
        [$row, $col] = $coord;
        $player = $this->graella[$row][$col];
        if ($player == '') {
            return false;
        }

        foreach (self::DIRECTIONS as $direction) {
            $count = 1;
   
            $count += $this->countDirection($row, $col, $direction[0], $direction[1], $player);

            $count += $this->countDirection($row, $col, -$direction[0], -$direction[1], $player);

            if ($count >= 4) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cuenta las fichas en una dirección específica.
     *
     * @param int $row La fila inicial.
     * @param int $col La columna inicial.
     * @param int $rowStep El incremento de fila en cada paso.
     * @param int $colStep El incremento de columna en cada paso.
     * @param int $player El número del jugador.
     * @return int El número de fichas consecutivas del jugador en la dirección especificada.
     */
    private function countDirection(int $row, int $col, int $rowStep, int $colStep, int $player): int
    {
        $count = 0;
        while (true) {
            $row += $rowStep;
            $col += $colStep;

            if ($row < 0 || $row >= self::FILES || $col < 0 || $col >= self::COLUMNS || $this->graella[$row][$col] != $player) {
                break;
            }

            $count++;
        }
        return $count;
    }

    /**
     * Comprueba si el tablero está lleno.
     *
     * @return bool True si el tablero está lleno, false en caso contrario.
     */
    public function isFull(): bool {
        for ($i = 0; $i < self::COLUMNS; $i++) {
            if ($this->graella[0][$i] == '') {
                return false;
            }
        }
        return true;
    }

    public function getSlots(): array {
        return $this->graella;
    }
}
