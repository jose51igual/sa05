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

    public function getUsuari($nomUsuari, $hashPasswd) {
        try {
            $sentencia = $this->conexion->prepare("SELECT id, nom_usuari FROM usuaris WHERE nom_usuari = :nom AND contrasenya = :pass");
            $sentencia->bindParam(':nom', $nomUsuari);
            $sentencia->bindParam(':pass', $hashPasswd);
            $sentencia->execute();
            $userData = $sentencia->fetch();

            if ($userData) {
                return new User($userData['id'], $userData['nom_usuari']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            $this->logger->error('Error recuperant l\'usuari: ' . $nomUsuari . $e->getMessage());
            return 'Error recuperant l\'usuari: ' . $e->getMessage();
        }
    }

    public function getJoc($user_id) {
        try {
            $sentencia = $this->conexion->prepare("SELECT game FROM partides WHERE usuari_id = :id");
            $sentencia->bindParam(':id', $user_id);
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

    public function registro($nomUsuari, $hashPasswd) {
        try {
            $sentencia = $this->conexion->prepare("SELECT COUNT(*) FROM usuaris WHERE nom_usuari = :nom");
            $sentencia->bindParam(':nom', $nomUsuari);
            $sentencia->execute();
            $count = $sentencia->fetchColumn();

            if ($count == 0) {
                $sentencia = $this->conexion->prepare("INSERT INTO usuaris (nom_usuari, contrasenya) VALUES (:nom, :pass)");
                $sentencia->bindParam(':nom', $nomUsuari);
                $sentencia->bindParam(':pass', $hashPasswd);
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