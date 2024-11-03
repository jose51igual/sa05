<?php

use PHPUnit\Framework\TestCase;
use Joc4enRatlla\Controllers\GameController;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;

class GameControllerTest extends TestCase
{
    private $gameController;

    protected function setUp(): void
    {
        $_SESSION = [];
        $this->gameController = new GameController([]);
    }

    public function testInitialGameSetup()
    {
        $_SESSION['players'] = [
            'player1' => new Player('Jugador 1', 'red'),
            'player2' => new Player('Jugador 2', 'blue')
        ];

        $this->gameController->play([]);

        $this->assertInstanceOf(Game::class, $this->gameController->getGame());
    }

    public function testNewMovementValidMove()
    {
        $_SESSION['players'] = [
            'player1' => new Player('Jugador 1', 'red'),
            'player2' => new Player('Jugador 2', 'blue')
        ];

        $this->gameController->play([]);
        $this->gameController->newMovement(['col' => 1]);

        $this->assertEmpty($_SESSION['errors']);
    }



    public function testDetectWinner()
    {
        $_SESSION['players'] = [
            'player1' => new Player('Jugador 1', 'red'),
            'player2' => new Player('Jugador 2', 'blue')
        ];

        $this->gameController->play([]);
        // Simular movimientos que resultan en una victoria
        $this->gameController->newMovement(['col' => 0]);
        $this->gameController->newMovement(['col' => 1]);
        $this->gameController->newMovement(['col' => 0]);
        $this->gameController->newMovement(['col' => 1]);
        $this->gameController->newMovement(['col' => 0]);
        $this->gameController->newMovement(['col' => 1]);
        $this->gameController->newMovement(['col' => 0]);

        $this->assertNotNull($this->gameController->getGame()->getWinner());
    }

    public function testSessionManagement()
    {
        $_SESSION['players'] = [
            'player1' => new Player('Jugador 1', 'red'),
            'player2' => new Player('Jugador 2', 'blue')
        ];

        $this->gameController->play([]);
        $this->gameController->newMovement(['col' => 1]);

        $this->assertArrayHasKey('game', $_SESSION);
        $this->assertArrayHasKey('scores', $_SESSION);
    }

    public function testNewMovementGameAlreadyWon()
    {
        $_SESSION['players'] = [
            'player1' => new Player('Jugador 1', 'red'),
            'player2' => new Player('Jugador 2', 'blue')
        ];

        $this->gameController->play([]);
        $this->gameController->getGame()->setWinner(new Player('Jugador 1', 'red'));
        $this->gameController->newMovement(['col' => 1]);

        $this->assertNotEmpty($_SESSION['errors']);
        $this->assertEquals('El juego ya ha terminado.', $_SESSION['errors'][0]);
    }
}

// Definir la función loadView fuera de la clase para las pruebas
function loadView($view, $data = []) {
    // Simulación de la función loadView para pruebas
    return;
}