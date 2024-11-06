<?php

namespace Joc4enRatlla\Models;

class User{
    private $id;
    private $nom_usuari;
    private $passwd;

    public function __construct($nom, $passwd, $id = null){
        $this->id = $id;
        $this->nom_usuari = $nom;
        $this->passwd = $passwd;
    }

    public function getNom(){
        return $this->nom_usuari;
    }

    public function getId(){
        return $this->id;
    }

    public function getPasswd(){
        return $this->passwd;
    }

}