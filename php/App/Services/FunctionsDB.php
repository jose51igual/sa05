<?php

namespace Joc4enRatlla\Services;

include_once __DIR__ . '/conf/conexion.php';

use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Models\User;
use PDO;
use PDOException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;


class FunctionsDB {

    private PDO $conexion;
    private Logger $logger;

    public function __construct() {
        $this->logger = new Logger('loginDBLogger');
        $this->logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'] . "/../logs/loginDB.log", Level::Info));
        $this->conexion = new PDO(DSN, USUARIO, PASSWORD);
    }

    /**
     * Comprueba si el usuario y la contraseña son correctos.
     * 
     * @param string $nomUsuari El nombre de usuario.
     * @param string $passwd La contraseña.
     * 
     * @return User|false|string El usuario si es correcto, false si no lo es, o un mensaje de error.
     */
    public function getUsuari($nomUsuari, $passwd) {
        try {
            $sentencia = $this->conexion->prepare("SELECT * FROM usuaris WHERE nom_usuari = :nom");
            $sentencia->bindParam(':nom', $nomUsuari);

            $sentencia->execute();
            $userData = $sentencia->fetch(PDO::FETCH_ASSOC);

            if ($userData && password_verify($passwd, $userData['contrasenya'])) {
                return new User($userData['nom_usuari'], $userData['contrasenya'], $userData['id']);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->logger->error('Error recuperant l\'usuari: ' . $nomUsuari . $e->getMessage());
            return 'Error recuperant l\'usuari: ' . $e->getMessage();
        }
    }

    /**
     * Recupera el juego de un usuario.
     * 
     * @param int $user_id El id del usuario.
     * 
     * @return Game|false El juego si existe, false si no.
     */
    public function getJoc($user_id) {
        try {
            $sentencia = $this->conexion->prepare("SELECT game FROM partides WHERE usuari_id = :id");
            $sentencia->bindParam(':id', $user_id);
            $sentencia->execute();
            $gameData = $sentencia->fetch(PDO::FETCH_ASSOC);
    
            if ($gameData) {
                return unserialize($gameData['game']);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->logger->error('Error recuperant el joc: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Guarda el juego de un usuario.
     * 
     * @param Game $game El juego.
     * @param int $user_id El id del usuario.
     * 
     * @return bool True si se ha guardado, false si no.
     */
    public function saveJoc($game, $user_id) {
        try {
            $sentencia = $this->conexion->prepare("
                INSERT INTO partides (usuari_id, game) 
                VALUES (:id, :game) 
                ON DUPLICATE KEY UPDATE game = :game
            ");
            $gameSerialized = serialize($game);
            $sentencia->bindParam(':id', $user_id);
            $sentencia->bindParam(':game', $gameSerialized);
            return $sentencia->execute();
        } catch (PDOException $e) {
            $this->logger->error('Error guardant el joc: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Registra un usuario.
     * 
     * @param string $nomUsuari El nombre de usuario.
     * @param string $passwd La contraseña.
     * 
     * @return bool True si se ha registrado, false si no.
     */
    public function registro($nomUsuari, $passwd) {
        try {
            $sentencia = $this->conexion->prepare("SELECT COUNT(*) FROM usuaris WHERE nom_usuari = :nom");
            $sentencia->bindParam(':nom', $nomUsuari);
            $sentencia->execute();
            $count = $sentencia->fetchColumn();

            if ($count == 0) {
                $sentencia = $this->conexion->prepare("INSERT INTO usuaris (nom_usuari, contrasenya) VALUES (:nom, :pass)");
                $sentencia->bindParam(':nom', $nomUsuari);
                $hash = password_hash($passwd, PASSWORD_DEFAULT);
                $sentencia->bindParam(':pass', $hash);
                return $sentencia->execute();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->logger->error('Error registrant l\'usuari: ' . $e->getMessage());
            return false;
        }
    }
}