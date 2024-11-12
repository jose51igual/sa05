<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use BatoiBook\Controllers\Api\CourseController;

$controller = new CourseController();

$controller->getAll();