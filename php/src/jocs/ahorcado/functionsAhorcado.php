<?php

function imprimir($arrayGuions){
    foreach($arrayGuions as $lletra){
        echo "$lletra ";
    }
}

function comprovarIntents($paraula , $lletra , &$arrayGuions){
    $bool = false;
    for($i = 0; $i < strlen($paraula); $i++){
        if(strtolower($paraula[$i]) == strtolower($lletra)){
            $arrayGuions[$i] = $lletra;
            $bool = true;
        }
    }
    return $bool;
}

function comprobarWin($arrayGuions,$paraula){
    $bool = true;
    for($i = 0; $i < strlen($paraula); $i++){
        if(strtolower($arrayGuions[$i]) != strtolower($paraula[$i])){
            $bool = false;
        }
    }
    return $bool;
}

function reiniciarJoc(){
    $_SESSION['fallos'] = [];
    $_SESSION['guions'] = array_fill(0,strlen($_SESSION['paraula']),'_');
    $_SESSION['lletra'] = [];
}
?>