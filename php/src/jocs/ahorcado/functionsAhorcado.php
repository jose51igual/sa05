<?php

function imprimir($arrayGuions) {
    foreach ($arrayGuions as $lletra) {
        echo "$lletra ";
    }
}

function inicialitzarJoc() {

    if (!isset($_SESSION['fallos'])) {
        $_SESSION['fallos'] = [];
    }
    if (!isset($_SESSION['guions'])) {
        $_SESSION['guions'] = array_fill(0, strlen($_SESSION['paraula']), '_');
    }
    if (!isset($_SESSION['intents'])) {
        $_SESSION['intents'] = 6;
    }
}

function comprovarIntents($paraula, $lletra, &$arrayGuions) {
    $bool = false;
    for ($i = 0; $i < strlen($paraula); $i++) {
        if (strtolower($paraula[$i]) == strtolower($lletra)) {
            $arrayGuions[$i] = $lletra;
            $bool = true;
        }
    }
    return $bool;
}

function comprobarWin($arrayGuions) {
    foreach ($arrayGuions as $lletra) {
        if ($lletra == '_') {
            return false;
        }
    }
    return true;
}

function reiniciarJoc(){
    unset($_SESSION['guions']);
    unset($_SESSION['intents']);
    unset($_SESSION['fallos']);
    inicialitzarJoc();
}

?>