<?php

namespace Joc4enRatlla\Exceptions;
use Exception;

class contrasenyaIncorrectaException extends Exception {
    public function __construct($message = 'Contrasenya incorrecta') {
        parent::__construct($message);
    }
}