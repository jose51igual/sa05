<?php


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


?>