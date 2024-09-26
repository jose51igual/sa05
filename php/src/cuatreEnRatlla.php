<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4 en Ratlla</title>
    <style>
    table { border-collapse: collapse; }
    td {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 10px dotted #fff; /* Cercle amb punts blancs */
        background-color: #000; /* Fons negre o pot ser un altre color */
        display: inline-block;
        margin: 10px;
        color: white;
        font-size: 2rem;
        text-align: center ;
        vertical-align: middle;
    }
    .player1 {
        background-color: red; /* Color vermell per un dels jugadors */
    }
    .player2 {
        background-color: yellow; /* Color groc per l'altre jugador */
    }
    .buid {
        background-color: white; /* Color blanc per cercles buits */
        border-color: #000; /* Puntes negres per millor visibilitat */
}
    </style>
</head>
<body>
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
        
        $graella = inicialitzarGraella();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            if (isset($_POST['tirada'])) {
            $tirada = htmlspecialchars($_POST['tirada']);
            }else{
                echo "<p>Introduce un numero antes de enviar!</p>";
            }

            if (isset($_POST['jugador'])) {
            $jugadorActual = $_POST['jugador'];
            }

            ferMoviment($graella, $tirada, $jugadorActual);
        } 

    
        pintarGraella($graella);
    ?>

    <h2>Introduce un numero (0-6)</h2>
    <form method="post">
        <input type="number" name="tirada" maxlength="1">
        <input type="submit" value="Enviar">
        <label for="jugador">
            <input type="radio" name="jugador" value="player1" checked>Jugador 1
        </label>
        <label for="jugador">
            <input type="radio" name="jugador" value="player2">Jugador 2
        </label>
    </form>
    
</body>
</html>