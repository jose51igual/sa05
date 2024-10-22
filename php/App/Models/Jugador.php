<?php
namespace Joc4enRatlla\Models;

/**
 * Clase Player
 *
 * Esta clase representa un jugador en el juego de Conecta Cuatro.
 */
class Player {
    /**
     * Nombre del jugador.
     *
     * @var string
     */
    private $name;

    /**
     * Color de las fichas del jugador.
     *
     * @var string
     */
    private $color;

    /**
     * Indica si el jugador es automático o manual.
     *
     * @var bool
     */
    private $isAutomatic;

    /**
     * Constructor de la clase Player.
     *
     * @param string $nom Nombre del jugador.
     * @param string $colorFitxa Color de las fichas del jugador.
     * @param bool $esAutomatic Indica si el jugador es automático (por defecto es false).
     */
    public function __construct($nom, $colorFitxa, $esAutomatic = false) {
        $this->name = $nom;
        $this->color = $colorFitxa;
        $this->isAutomatic = $esAutomatic;
    }

    /**
     * Obtiene el nombre del jugador.
     *
     * @return string El nombre del jugador.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Obtiene el color de las fichas del jugador.
     *
     * @return string El color de las fichas del jugador.
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Indica si el jugador es automático.
     *
     * @return bool True si el jugador es automático, false si es manual.
     */
    public function isAutomatic() {
        return $this->isAutomatic;
    }
}