<?php
namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Exceptions\colorsIgualsException;
use Joc4enRatlla\Exceptions\faltenDadesException;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Exceptions\nomsIgualsException;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Clase JugadorController
 *
 * Esta clase controla los jugadores del Cuatro en Ralla.
 */
class JugadorController {

    /**
     * Los jugadores del Cuatro en Ralla.
     *
     * @var array $players
     */
    private array $players;

    /**
     * Logger de errores.
     *
     * @var Logger $loggerErrors
     */
    private Logger $loggerErrors;

    public function __construct($request = null) {
        $this->loggerErrors = new Logger('loggerErrores');
        $this->loggerErrors->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/../logs/errors.log", Level::Error));
        try {
            $this->setPlayers($request);
        } catch (\Throwable $th) {
            $this->loggerErrors->error($th->getMessage());
            loadView('jugador'); 
            return;
        }
    }

    /**
     * Guarda los jugadores en la sesión.
     * 
     * @param array $request Los datos de la petición.
     * 
     * @throws faltenDadesException Si no se han enviado los datos necesarios.
     * 
     * @throws colorsIgualsException Si los colores de los jugadores son iguales.
     * 
     * @throws nomsIgualsException Si los nombres de los jugadores son iguales.
     * 
     * @return void
     */
    public function setPlayers(array $request = null) : void {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' || !$request) {
            loadView('jugador');
            return;
        }
       try {
            if(empty($request['player1']) || empty($request['player2']) || !isset($request['player1']) || !isset($request['player2'])){
                throw new faltenDadesException();
            }elseif($request['player1-color'] === $request['player2-color']){
                throw new colorsIgualsException();
            }elseif($request['player1'] === $request['player2']){
                throw new nomsIgualsException();
            }
        } catch (faltenDadesException | colorsIgualsException | nomsIgualsException $e) {
            $this->loggerErrors->error($e->getMessage());
            $_SESSION['errors'][] = $e->getMessage();
            loadView('jugador');
            return;
        }
        $this->players = [
            'player1' => new Player(
                (isset($request['player1']) ? $request['player1'] : 'Player 1'),
                (isset($request['player1-color']) ? $request['player1-color'] : 'red'),
            ),
            'player2' => new Player(
                (isset($request['player2']) ? $request['player2'] : 'Player 3'),
                (isset($request['player2-color'])? $request['player2-color'] : 'yellow'),
                ((isset($request['player2-ia']) && $request['player2-ia'] === 'true') ? true : false),
                )
        ];
        $_SESSION['players'] = serialize($this->players);
        header('Location: /');
        exit;
    }
}