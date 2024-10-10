<?php
function inicialitzarGraella(){
    for($i = 0; $i < 6; $i++){
        for($j = 0; $j < 7; $j++){
            $graella[$i][$j] = '';
        }
    }
    return $graella;
}

function pintarGraella($graella){
    echo "<table>";
    foreach($graella as $fila){
        echo "<tr>";
        foreach($fila as $ficha){
            echo "<td class=\"$ficha\"></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

function ferMoviment(&$graella, $columna, $jugadorActual){
    for($i = count($graella) -1; $i >= 0; $i--){
        if($graella[$i][$columna] == ''){
            $graella[$i][$columna] = "$jugadorActual";
            break;
        }
    }
}
?>