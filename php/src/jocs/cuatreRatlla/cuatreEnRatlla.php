<?php
session_start();
include_once("./functionsEnRatlla.php");

if (!isset($_SESSION['nom_usuari']) && !isset($_SESSION['password'])) {
    header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/auth/login.php');
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
    <link rel="stylesheet" href="css/styles4Ralla.css">
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
