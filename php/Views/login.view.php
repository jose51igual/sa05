<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión <?= isset($_COOKIE['user']) ? $_COOKIE['user'] : ''; ?></h2>
        <form method="post" action="login.php">
            <label for="nom_usuari">Nombre de usuario:</label>
            <input type="text" id="nom_usuari" name="nom_usuari" value="<?php if (isset($_COOKIE['user'])) {echo $_COOKIE['user'];} ?>" required>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Iniciar Sesión</button>
            <div class="checkbox-container">
                <label for="recordar">
                    <input type="checkbox" id="recordar" name="recordar" <?php echo isset($_COOKIE['user']) ? 'checked' : ''; ?>>
                    Recordar
                </label>
            </div>
        </form>
    </div>
</body>
</html>
