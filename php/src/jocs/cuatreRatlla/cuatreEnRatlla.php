<?php
session_start();
include_once("./functionsEnRatlla.php");

if (!isset($_SESSION['nom_usuari']) && !isset($_SESSION['password'])) {
    header('Location: auth/login.php');
    exit();
}

$nomUsuari = $_SESSION['nom_usuari'];

if(!isset($_SESSION['graella'])){
    $_SESSION['graella'] = inicialitzarGraella();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvingut al 4 en Ratlla <?= $_SESSION['nom_usuari'] ?></title>
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

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST['tirada']) && $_POST['tirada'] !== '') {
                $tirada = htmlspecialchars($_POST['tirada']);
                $_SESSION['tirada'] = $tirada;
                
                if ($tirada >= 0 && $tirada <= 6) {
                    if (isset($_POST['jugador'])) {
                        $jugadorActual = $_POST['jugador'];
                        $_SESSION['jugador'] = $jugadorActual;
                        ferMoviment($_SESSION['graella'], $_SESSION['tirada'], $_SESSION['jugador']);
                    }
                } else {
                    echo "<p>Introduce un número válido entre 0 y 6.</p>";
                }
            } else {
                echo "<p>Introduce un número antes de enviar!</p>";
            }
        }
        pintarGraella($_SESSION['graella']);
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
    <a href="../../auth/logout.php">Cerrar sesion</a>
</body>
</html>