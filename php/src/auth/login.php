<?php
session_start();

$usuarioPrueba = 'Jose';
$passwdPrueba = password_hash('1234', PASSWORD_DEFAULT);

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
<html>
<head>
    <title>Iniciar Sessió</title>
</head>
<body>
    <h2>Inicia Sessió <?= isset($_COOKIE['user']) ? $cookieNom : '' ?></h2>
    <form method="post" action="login.php">
        <label for="nom_usuari">Nom d'usuari:</label>
        <input type="text" id="nom_usuari" name="nom_usuari" value="<?php echo $cookieNom; ?>" required>
        <br />
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br />
        <button type="submit">Iniciar Sessió</button><br>
        <label for="recordar">Recordar</label>
        <input type="checkbox" id="recordar" name="recordar" <?php echo isset($_COOKIE['user']) ? 'checked' : ''; ?>>
    </form>
</body>
</html>
