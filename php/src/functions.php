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

?>