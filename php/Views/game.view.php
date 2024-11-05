<html>
<head>
    <link rel="stylesheet" href="css/4ratlla.css">
    <title>4 en ratlla</title>
    <style>
        .player1 {
            background-color: <?= $players[1]->getColor() ?> ; /* Color   per un dels jugadors */
        }

        .player2 {
            background-color:  <?= $players[2]->getColor() ?>; /* Color   per l'altre jugador */
        }

    </style>
</head>
<body>
    
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/../Views/partials/error.view.php'  ?>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/../Views/partials/board.view.php'  ?>
    
</form>
<form action="" method="GET">
    <button type="submit" name="action" value="save">Guardar partida</button>
    <button type="submit" name="action" value="reset">Reiniciar joc</button>
    <button type="submit" name="action" value="exit">Tancar Sessió</button>
</form>
 <?php include_once $_SERVER['DOCUMENT_ROOT'].'/../Views/partials/panel.view.php'  ?>

</body>
</html>