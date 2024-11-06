<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvingut <?= $_SESSION['user']['nom'] ?> !</title>
    <link rel="stylesheet" href="css/welcome.css">
</head>
<body>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] .'/../Views/partials/error.view.php'  ?>

    <div class="welcome">
        <h2>Benvingut al Cuatre En Ratlla, <?= $_SESSION['user']['nom'] ?></h2>
        <form method="GET" action="">
            <button type="submit" name="action" value="newGame">Iniciar Nova Partida</button>
            <button type="submit" name="action" value="loadGame">Cargar Partida Existent</button>
        </form>
    </div>
</body>
</html>
