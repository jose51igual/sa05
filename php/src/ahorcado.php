<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido al juego del ahorcado</h1>

    <p>Adivina la palabra</p>
    <?php
    include_once './functions.php';

    define("PARAULA", "Teclado");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lletra = htmlspecialchars($_POST['letra']);

        $longitud = strlen(PARAULA);

        $arrayFallos = [];

        $arrayGuions = [];

        for($i = 0; $i < $longitud; $i++){
        $arrayGuions[] = '_';
        }

        $bool = comprovarIntents(PARAULA , $lletra, $arrayGuions);

        imprimir($arrayGuions);

    
        if($lletra != null){
            if($bool){
                echo "<p style=\"color: green;\">La letra $lletra es correcta</p><br>";

                echo "<p>Progreso actual:</p><br>";
                imprimir($arrayGuions);
            }else{
                echo "<p style=\"color: red;\">La letra $lletra es incorrecta</p>";
                $arrayFallos[] = $lletra;
                imprimir($arrayFallos);
            }
        }
        
    }
    ?>

    <form method="post">
        <input type="text" name="letra" id="letra" maxlength="1">
        <input type="submit" value="Enviar">
    </form>

</body>
</html>