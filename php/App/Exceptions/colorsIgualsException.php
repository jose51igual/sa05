<?php

namespace Joc4enRatlla\Exceptions;
use Exception;

class colorsIgualsException extends Exception {
    public function __construct($message = 'Els colors dels jugadors han de ser diferents') {
        parent::__construct($message);
    }
}