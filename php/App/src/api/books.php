<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use BatoiBook\Controllers\Api\BookController;

$controller = new BookController();

$controller->getAll();