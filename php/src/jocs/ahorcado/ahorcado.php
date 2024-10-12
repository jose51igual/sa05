<?php
session_start();

include_once './functionsAhorcado.php';

if (!isset($_SESSION['nom_usuari']) && !isset($_SESSION['password'])) {
    header('Location: ../../auth/login.php');
    exit();
}
// Paraula a endevinar
define("PARAULA", "Batoi");
$_SESSION['paraula'] = PARAULA;

inicialitzarJoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El ahorcado</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .hangman-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .feedback {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        .feedback.correct {
            color: green;
        }
        .feedback.incorrect {
            color: red;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 1rem;
            width: 50%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .attempts {
            font-size: 1rem;
            color: #333;
            margin-top: 15px;
        }
        a {
            display: block;
            margin-top: 20px;
            font-size: 1rem;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="hangman-container">
        <h1>Bienvenido al juego del ahorcado, <?php echo $_SESSION['nom_usuari']; ?>!</h1>

        <p>Adivina la palabra:</p>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['reiniciar'])) {
                reiniciarJoc();
            } elseif (isset($_POST['letra']) && !empty($_POST['letra'])) {
                $lletra = $_POST['letra'];
                $_SESSION['lletra'] = $lletra;

                $bool = comprovarIntents($_SESSION['paraula'], $_SESSION['lletra'], $_SESSION['guions']);

                imprimir($_SESSION['guions']);

                if ($bool) {
                    echo "<p class=\"feedback correct\">La letra $lletra es correcta</p>";
                    imprimir($_SESSION['guions']);
                } else {
                    echo "<p class=\"feedback incorrect\">La letra $lletra es incorrecta</p>";
                    $_SESSION['fallos'][] = $_SESSION['lletra'];
                    echo "<p>Letras incorrectas:</p>";
                    imprimir($_SESSION['fallos']);
                    $_SESSION['intents']--;
                }
            }
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'restart') {
            reiniciarJoc();
        }
        ?>

        <?php
        if (!comprobarWin($_SESSION['guions']) && $_SESSION['intents'] > 0) {
        ?>
            <form method="post">
                <input type="text" name="letra" id="letra" maxlength="1" placeholder="Introduce una letra">
                <input type="submit" value="Enviar">
                <p class="attempts">Intentos restantes: <?php echo $_SESSION['intents']; ?></p>
            </form>
        <?php
        } elseif ($_SESSION['intents'] == 0) {
            echo "<p class='feedback incorrect'>¡Has perdido! La palaula era: {$_SESSION['paraula']}</p>";
        } else {
            echo "<p class='feedback correct'>¡Has ganado!</p>";
        }
        ?>

        <a href="../../auth/logout.php">Cerrar sesión</a>
        <a href="?action=restart">Reiniciar Juego</a>
    </div>
</body>
</html>
