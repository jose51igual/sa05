<?php

function comprobaciones(){
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