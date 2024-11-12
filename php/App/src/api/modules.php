<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use BatoiBook\Controllers\Api\ModuleController;

$controller = new ModuleController();

$controller->getAll();