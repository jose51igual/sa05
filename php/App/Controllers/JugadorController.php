<?php
namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Models\Player;

class JugadorController {
    private array $players;

    public function __construct($request = null) {
        try {
            $this->setPlayers($request);
        } catch (\Throwable $th) {
            loadView('jugador'); 
            return;
        }
    }

    public function setPlayers(array $request) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' || $request === null || isset($request['user'])) {
            loadView('jugador'); 
            return;
        }

        $this->comprobaciones($request);

        $this->players = [
            'player1' => new Player(
                $request['player1'] ?? 'Player 1',
                $request['player1-color'] ?? 'red'
            ),
            'player2' => new Player(
                $request['player2'] ?? 'Player 2',
                $request['player2-color'] ?? 'yellow',
                isset($request['player2-ia']) && $request['player2-ia'] === 'true'
            )
        ];

        $_SESSION['players'] = serialize($this->players);
    }

    private function comprobaciones(array $request) {
        if(!isset($request['player1']) || !isset($request['player2']) || !isset($request['player1-color']) || !isset($request['player2-color'])){
            throw new \Exception('Error en el envío del formulari, falten dades');
        }
        if(empty($request['player1']) || empty($request['player2']) || empty($request['player1-color']) || empty($request['player2-color'])){
            throw new \Exception('Error en el envío del formulari, falten dades o estan buides');
        }
        if($request['player1-color'] === $request['player2-color']){
            throw new \Exception('Els colors dels jugadors han de ser diferents');
        }
        if($request['player1'] === $request['player2']){
            throw new \Exception('Els noms dels jugadors han de ser diferents');
        }
    }
}