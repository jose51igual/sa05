<?php
session_start();

if (!isset($_SESSION['nom_usuari']) && !isset($_SESSION['password'])) {
    header('Location: ../../auth/login.php');
    exit();
}

$nomUsuari = $_SESSION['nom_usuari'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['juego'])) {
        if ($_POST['juego'] === 'ahorcado') {
            header('Location: ../jocs/ahorcado/ahorcado.php');
            exit();
        } elseif ($_POST['juego'] === 'ratlla') {
            header('Location: ../jocs/cuatreRatlla/cuatreEnRatlla.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvingut</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .welcome-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        label {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        input[type="radio"] {
            margin-bottom: 15px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
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
    <div class="welcome-container">
        <h2>Benvingut, <?php echo htmlspecialchars($nomUsuari); ?>!</h2>
        <p>Elegix el joc que vas a jugar</p>
        <form method="post" action="welcome.php">
            <label for="ahorcado">
                <input type="radio" name="juego" id="ahorcado" value="ahorcado"> Ahorcado
            </label>
            <label for="ratlla">
                <input type="radio" name="juego" id="ratlla" value="ratlla"> 4 en Ratlla
            </label>
            <button type="submit">Empezar</button>
        </form>
        <a href="logout.php">Tancar Sessió</a>
    </div>
</body>
</html>
