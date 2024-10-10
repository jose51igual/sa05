<?php
session_start();

include_once './functionsAhorcado.php';

if (!isset($_SESSION['nom_usuari']) && !isset($_SESSION['password'])) {
    header('Location: auth/login.php');
    exit();
}

define("PARAULA", "Teclado");
$_SESSION['paraula'] = PARAULA;

inicialitzarJoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El ahorcado</title>
</head>
<body>
    <h1>Bienvenido al juego del ahorcado <?php echo $_SESSION['nom_usuari']; ?></h1>

    <p>Adivina la palabra</p>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['reiniciar'])) {
            unset($_SESSION['guions']);
            unset($_SESSION['intents']);
            unset($_SESSION['fallos']);
            inicialitzarJoc();
        } elseif (isset($_POST['letra']) && !empty($_POST['letra'])) {
            $lletra = $_POST['letra'];
            $_SESSION['lletra'] = $lletra;

            $bool = comprovarIntents($_SESSION['paraula'], $_SESSION['lletra'], $_SESSION['guions']);

            imprimir($_SESSION['guions']);

            if ($bool) {
                echo "<p style=\"color: green;\">La letra $lletra es correcta</p><br>";
                echo "<p>Progreso actual:</p><br>";
                imprimir($_SESSION['guions']);
            } else {
                echo "<p style=\"color: red;\">La letra $lletra es incorrecta</p>";
                $_SESSION['fallos'][] = $_SESSION['lletra'];
                echo "<p>Letras incorrectas:</p>";
                imprimir($_SESSION['fallos']);
                $_SESSION['intents']--;
            }
        }
    }
    ?>

    <form method="post">
<?php
if (!comprobarWin($_SESSION['guions']) && $_SESSION['intents'] > 0) {
?>
        <input type="text" name="letra" id="letra" maxlength="1">
        <input type="submit" value="Enviar">
<?php
} elseif ($_SESSION['intents'] == 0) {
    echo "<p>¡Has perdido! La palabra era: {$_SESSION['paraula']}</p>";
?>
        <input type="hidden" name="reiniciar" value="1">
        <input type="submit" value="Reiniciar Juego">
<?php
} else {
    echo "<p>¡Has ganado!</p>";
?>
        <input type="hidden" name="reiniciar" value="1">
        <input type="submit" value="Reiniciar Juego">
<?php
}
?>
    </form>
    <a href="../../auth/logout.php">Cerrar sesion</a>
</body>
</html>