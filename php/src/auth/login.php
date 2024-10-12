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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
            text-align: left;
        }
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }
        button {
            padding: 10px;
            font-size: 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
        p {
            color: red;
            font-weight: bold;
        }
    </style>
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
