<?php
session_start();

$cookieNom = isset($_COOKIE['user']) ? htmlspecialchars($_COOKIE['user']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom_usuari']) && $_POST['nom_usuari'] != "") {
        $nomUsuari = htmlspecialchars($_POST['nom_usuari']);
        $_SESSION['nom_usuari'] = $nomUsuari;

        if (isset($_POST['password']) && $_POST['password'] != "") {
            $passwd = htmlspecialchars($_POST['password']);

            if (password_verify($passwd, $passwdPrueba) && $nomUsuari === $usuarioPrueba) {
                $_SESSION['password'] = $passwd;
                if (isset($_POST['recordar'])) {
                    setcookie('user', $nomUsuari, time() + 3600, '/');
                }
                header('Location: welcome.php');
                exit();
            } else {
                echo "<p>Nombre de usuario o contraseña incorrectos.</p>";
            }
        }
    } else {
        echo "<p>Debes introducir un nombre!!!!</p>";
    }
}
?>

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
        <h2>Iniciar Sesión <?= isset($_COOKIE['user']) ? $cookieNom : '' ?></h2>
        <form method="post" action="login.php">
            <label for="nom_usuari">Nombre de usuario:</label>
            <input type="text" id="nom_usuari" name="nom_usuari" value="<?php echo $cookieNom; ?>" required>
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
