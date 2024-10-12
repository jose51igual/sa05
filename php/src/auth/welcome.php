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
<html>
<head>
    <title>Benvingut</title>
</head>
<body>
    <h2>Benvingut, <?php echo htmlspecialchars($nomUsuari); ?>!</h2>
    <p>Elegix el joc que vas a jugar</p>
    <form method="post" action="welcome.php">
        <label for="ahorcado">Ahorcado</label>
        <input type="radio" name="juego" id="ahorcado" value="ahorcado">
        <br>
        <label for="ratlla">4 en ratlla</label>
        <input type="radio" name="juego" id="ratlla" value="ratlla">
        <br>
        <button type="submit">Empezar</button>
    </form>
    <a href="logout.php">Tancar Sessió</a>
</body>
</html>
