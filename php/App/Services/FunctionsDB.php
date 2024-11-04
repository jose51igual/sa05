<?php

class FunctionsDB{

    private $conexion;

    public function __construct(){
        $this->conexion = new PDO(DSN, USUARIO, PASSWORD);
    }

    public function getConn(){
        return $this->conexion;
    }

    public function getUsuari($nomUsuari,$password){
        $sentencia = $this->conexion->prepare("SELECT * FROM usuaris WHERE nom_usuari = :nom  AND password = :pass");
        $sentencia->bindParam(':nom', $nomUsuari);
        $sentencia->bindParam(':pass', $password);
        $sentencia->execute();
        return $sentencia->fetch();
    }

    public function getJoc($user_id){
        $sentencia = $this->conexion->prepare("SELECT game FROM partides WHERE usuari_id = :id");
        $sentencia->bindParam(':id', $user_id);
        $sentencia->execute();
        return $sentencia->fetch();
    }

}