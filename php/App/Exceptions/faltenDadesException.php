<?php

class faltenDadesException extends Exception {
    public function __construct($message = 'Error en el envío del formulari, falten dades', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}