<?php

namespace Joc4enRatlla\Models;

class User{
    private $id;
    private $nom_usuari;
    private $contrasenya;

    public function __construct($id, $nom, $password){
        $this->id = $id;
        $this->nom_usuari = $nom;
        $this->contrasenya = $password;
    }

    public function getNom(){
        return $this->nom_usuari;
    }

    public function getId(){
        return $this->id;
    }

    public function getContrasenya(){
        return $this->contrasenya;
    }

}