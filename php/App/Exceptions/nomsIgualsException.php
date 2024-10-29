<?php

class nomsIgualsException extends Exception {
    public function __construct($message = 'Els noms dels jugadors han de ser diferents', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}