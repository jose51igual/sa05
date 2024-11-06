<?php
namespace Joc4enRatlla\Exceptions;
use Exception;

class nomsIgualsException extends Exception {
    public function __construct($message = 'Els noms dels jugadors han de ser diferents') {
        parent::__construct($message);
    }
}