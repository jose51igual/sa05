<?php

class colorsIgualsException extends Exception {
    public function __construct($message = 'Els colors dels jugadors han de ser diferents', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}