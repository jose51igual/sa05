<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>4 en ratlla</title>
    <link rel="stylesheet" href="/css/player.css">
</head>
<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/../Views/partials/error.view.php'  ?>

    <h1>Selección de jugadores</h1>

    <form action="" method="POST">
        <fieldset>
            <legend>Jugador 1</legend>
            <label for="player1">Name:</label>
            <input type="text" name="player1" id="player1" required>
            <br>
            <label for="player1-color">Color:</label>
            <input type="color" name="player1-color" id="player1-color" value="#ff0000" required>
        </fieldset>

        <fieldset>
            <legend>Jugador 2</legend>
            <label for="player2">Name:</label>
            <input type="text" name="player2" id="player2" required>
            <br>
            <label for="player2-color">Color:</label>
            <input type="color" name="player2-color" id="player_color2" value="#ffff00" required>
            <br>
            <label for="player2-ia">Jugador IA:</label>
            <input type="checkbox" name="player2-ia" id="player2-ia" value="true">
        </fieldset>

        <button type="submit">Jugar</button>
    </form>

   
</body>
</html>