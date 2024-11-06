<?php
namespace Joc4enRatlla\Exceptions;
use Exception;

class faltenDadesException extends Exception {
    public function __construct($message = 'Error en el envío del formulari, falten dades') {
        parent::__construct($message);
    }
}