<?php

namespace Joc4enRatlla\Services;

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

    public function getUsuari($nomUsuari, $password) {
        try {
            $sentencia = $this->conexion->prepare("SELECT * FROM usuaris WHERE nom_usuari = :nom AND contrasenya = :pass");
            $sentencia->bindParam(':nom', $nomUsuari);
            $sentencia->bindParam(':pass', $password);
            $sentencia->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);
            $sentencia->execute();
            return $sentencia->fetch();
        } catch (PDOException $e) {
            $this->logger->error('Error recuperant l\'usuari: ' . $nomUsuari . $e->getMessage());
            return 'Error recuperant l\'usuari: ' . $e->getMessage();
        }
    }

    public function getJoc($user_id) {
        try {
            $sentencia = $this->conexion->prepare("SELECT game FROM partides WHERE usuari_id = :id");
            $sentencia->bindParam(':id', $user_id);
            $sentencia->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Game::class);
            $sentencia->execute();
            return $sentencia->fetch();
        } catch (PDOException $e) {
            $this->logger->error('Error recuperant el joc: ' . $e->getMessage());
            return 'Error recuperant el joc: ' . $e->getMessage();
        }
    }

    public function saveJoc($game, $user_id) {
        try {
            $sentencia = $this->conexion->prepare("UPDATE partides SET game = :game WHERE usuari_id = :id");
            $sentencia->bindParam(':game', $game);
            $sentencia->bindParam(':id', $user_id);
            return $sentencia->execute();
        } catch (PDOException $e) {
            $this->logger->error('Error guardant el joc: ' . $e->getMessage());
            return false;
        }
    }

    public function registro(User $user) {
        try {
            $sentencia = $this->conexion->prepare("SELECT COUNT(*) FROM usuaris WHERE nom_usuari = :nom");
            $sentencia->bindParam(':nom', $user->getNom());
            $sentencia->execute();
            $count = $sentencia->fetchColumn();

            if ($count > 0) {
                return false;
            }

            $sentencia = $this->conexion->prepare("INSERT INTO usuaris (id, nom_usuari, contrasenya) VALUES (:id, :nom, :contrasenya)");
            $sentencia->bindParam(':id', $user->getId());
            $sentencia->bindParam(':nom', $user->getNom());
            $sentencia->bindParam(':contrasenya', $user->getContrasenya());
            return $sentencia->execute();
        } catch (PDOException $e) {
            $this->logger->error('Error registrant l\'usuari: ' . $user->getNom() . $e->getMessage());
            return 'Error registrant l\'usuari: ' . $e->getMessage();
        }
    }
}