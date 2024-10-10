<?php
session_start();

if (!isset($_SESSION['nom_usuari']) && !isset($_SESSION['password'])) {
    header('Location: login.php');
    exit();
}

$nomUsuari = $_SESSION['nom_usuari'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['ahorcado'])) {
        header('Location: ./src/jocs/ahorcado.php');
        exit();
    } elseif (isset($_POST['ratlla'])) {
        header('Location: ./src/jocs/cuatreRatlla/cuatreEnRatlla.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Benvingut</title>
</head>
<body>
    <h2>Benvingut, <?php echo htmlspecialchars($nomUsuari); ?>!</h2>
    <p>Elegix el joc que vas a jugar</p>
    <form method="post" action="welcome.php">
        <label for="juego">Ahorcado</label>
        <input type="radio" name="ahorcado" id="ahorcado" value="ahorcado">
        <label for="juego">4 en ratlla</label>
        <input type="radio" name="ratlla" id="ratlla" value="ratlla">
        <button type="submit">Empezar</button>
    </form>
    <a href="logout.php">Tancar Sessió</a>
</body>
</html>