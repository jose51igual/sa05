<?php
    if(isset($_SESSION['errors'])){
       echo '<div class="errors-array">'; 

        foreach ($_SESSION['errors'] as $error) {
            echo "<p class='error'>$error</p>";
        }
        echo "</div>";
    }
    unset($_SESSION['errors']);



    