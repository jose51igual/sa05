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

function ferMoviment(&$graella, $columna, &$jugadorActual){
    for($i = count($graella) -1; $i >= 0; $i--){
        if($graella[$i][$columna] == ''){
            $graella[$i][$columna] = "$jugadorActual";
            break;
        }
    }
}

function comprobarCuatreEnRatlla($graella) {
    for($i = 0; $i < 6; $i++) {
        for($j = 0; $j < 7; $j++) {
            if($graella[$i][$j] != '') {
                if (comprovarHoritzontal($graella, $i, $j) || 
                    comprovarVertical($graella, $i, $j) || 
                    comprovarDiagonal($graella, $i, $j)) {
                    return true; // Se ha encontrado un ganador
                }
            }
        }
    }
    return false; // No se ha encontrado ningún ganador
}

function comprovarHoritzontal($graella, $fila, $columna) {
    $jugador = $graella[$fila][$columna];
    $contador = 1;
    
    for($i = $columna + 1; $i < 7; $i++) {
        if($graella[$fila][$i] == $jugador) {
            $contador++;
        } else {
            break;
        }
    }
    
    for($i = $columna - 1; $i >= 0; $i--) {
        if($graella[$fila][$i] == $jugador) {
            $contador++;
        } else {
            break;
        }
    }
    
    return $contador >= 4;
}

function comprovarDiagonal($graella, $fila, $columna) {
    $jugador = $graella[$fila][$columna];
    $contador = 1;

    // Diagonal descendente (\)
    for($i = 1; $i < 4; $i++) {
        if($fila + $i < 6 && $columna + $i < 7 && $graella[$fila + $i][$columna + $i] == $jugador) {
            $contador++;
        } else {
            break;
        }
    }
    for($i = 1; $i < 4; $i++) {
        if($fila - $i >= 0 && $columna - $i >= 0 && $graella[$fila - $i][$columna - $i] == $jugador) {
            $contador++;
        } else {
            break;
        }
    }

    if($contador >= 4) {
        return true;
    }

    // Diagonal ascendente (/)
    $contador = 1;
    for($i = 1; $i < 4; $i++) {
        if($fila - $i >= 0 && $columna + $i < 7 && $graella[$fila - $i][$columna + $i] == $jugador) {
            $contador++;
        } else {
            break;
        }
    }
    for($i = 1; $i < 4; $i++) {
        if($fila + $i < 6 && $columna - $i >= 0 && $graella[$fila + $i][$columna - $i] == $jugador) {
            $contador++;
        } else {
            break;
        }
    }

    return $contador >= 4;
}

function comprovarVertical($graella, $fila, $columna) {
    $jugador = $graella[$fila][$columna];
    $contador = 1;

    for($i = $fila + 1; $i < 6; $i++) {
        if($graella[$i][$columna] == $jugador) {
            $contador++;
        } else {
            break;
        }
    }

    return $contador >= 4;
}


?>