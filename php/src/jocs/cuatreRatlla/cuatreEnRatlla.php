<?php
session_start();
include_once("./functionsEnRatlla.php");

if (!isset($_SESSION['nom_usuari']) && !isset($_SESSION['password'])) {
    header('Location: ../../auth/login.php');
    exit();
}

$nomUsuari = $_SESSION['nom_usuari'];

if(!isset($_SESSION['graella'])){
    $_SESSION['graella'] = inicialitzarGraella();
}

if(!isset($_SESSION['jugador'])){
    $_SESSION['jugador'] = 'player1';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvingut al 4 en Ratlla <?= $_SESSION['nom_usuari'] ?></title>
    <style>
     body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h2 {
            font-size: 1.5rem;
            color: #333;
            margin: 10px 0;
        }
        table {
            border-collapse: separate;
            border-spacing: 5px;
            margin: 20px auto;
            background-color: #00509e;
            padding: 15px;
            border-radius: 15px;
        }
        td {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #fff;
            text-align: center;
            vertical-align: middle;
            box-shadow: inset 0px 0px 5px rgba(0, 0, 0, 0.5);
        }
        .player1 {
            background-color: #e63946; /* Rojo para Jugador 1 */
            box-shadow: 0px 0px 10px rgba(230, 57, 70, 0.7);
        }
        .player2 {
            background-color: #f1c40f; /* Amarillo para Jugador 2 */
            box-shadow: 0px 0px 10px rgba(241, 196, 15, 0.7);
        }
        .buid {
            background-color: #dfe6e9;
        }
        .controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        input[type="number"] {
            padding: 10px;
            font-size: 1rem;
            border: 2px solid #00509e;
            border-radius: 5px;
            width: 80px;
            margin: 10px 0;
            text-align: center;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            background-color: #00509e;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #003f7d;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            font-size: 1rem;
            color: #00509e;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        p {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'restart'){
        $_SESSION['graella'] = inicialitzarGraella();
        $_SESSION['jugador'] = 'player1';
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['tirada']) && $_POST['tirada'] !== '') {
            $tirada = htmlspecialchars($_POST['tirada']);
            $_SESSION['tirada'] = $tirada;

            if ($tirada >= 0 && $tirada <= 6) {
                ferMoviment($_SESSION['graella'], $_SESSION['tirada'], $_SESSION['jugador']);

                
                if (comprobarCuatreEnRatlla($_SESSION['graella'])) {
                    echo $_SESSION['jugador'] == 'player1' ? 'Jugador 1 (Rojo)' : 'Jugador 2 (Amarillo)' . ' ha ganado!';
                } else {
                    if ($_SESSION['jugador'] == 'player1') {
                        $_SESSION['jugador'] = 'player2';
                    } else {
                        $_SESSION['jugador'] = 'player1';
                    }
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
<?php
if (!comprobarCuatreEnRatlla($_SESSION['graella'])){
?>
    <h2>Turno de <?= $_SESSION['jugador'] == 'player1' ? 'Jugador 1 (Rojo)' : 'Jugador 2 (Amarillo)' ?></h2>
    <h2>Introduce un número (0-6)</h2>
    <form method="post">
        <input type="number" name="tirada" maxlength="1">
        <input type="submit" value="Enviar">
    </form>
<?php
}else{
    echo "<p>Has ganado " . $_SESSION['jugador'] . " !!!!!</p>";
}
?>
    <a href="../../auth/logout.php">Cerrar sesión</a>
    <a href="?action=restart">Reiniciar Juego</a>
</body>
</html>
