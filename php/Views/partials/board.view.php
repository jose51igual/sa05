<?php
$slots = $board->getSlots();

if ($winner !== null) {
    echo $nextPlayer === 1 ? "<h1>Ha guanyat el jugador " . $players[2]->getName() . "</h1>" : "<h1>Ha guanyat " . $players[1]->getName() . "</h1>";
} elseif ($board->isFull()) {
    echo "<h1>Empate</h1>";
} else {
    echo $players[$nextPlayer]->isAutomatic() ? "<h1>Turno de la IA</h1>" : "<h1>Turno de " . $players[$nextPlayer]->getName() . "</h1>";
    
    echo '<form action="" method="POST">';
    
    if ($players[$nextPlayer]->isAutomatic()) {
        // Botón para la IA
        echo '<button type="submit" name="col" value="0">Turno de la IA</button>';
    } else {
        // Generar botones para cada columna
        for ($i = 0; $i < count($slots[0]); $i++) {
            $col = $i + 1;
            echo "<button type='submit' name='col' value='$i'>Columna $col</button>";
        }
    }
    
    echo '</form>';
}

// Mostrar tablero
echo '<table>';
foreach ($slots as $row) {
    echo '<tr>';
    foreach ($row as $item) {
        echo ($item === 0) ? '<td class="empty"></td>' : '<td class="player' . $item . '"></td>';
    }
    echo '</tr>';
}
echo '</table>';
?>
