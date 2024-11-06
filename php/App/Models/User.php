<?php

namespace Joc4enRatlla\Models;

class User{
    private $id;
    private $nom_usuari;

    public function __construct( $nom, $id = null){
        $this->id = $id;
        $this->nom_usuari = $nom;

    }

    public function getNom(){
        return $this->nom_usuari;
    }

    public function getId(){
        return $this->id;
    }

}