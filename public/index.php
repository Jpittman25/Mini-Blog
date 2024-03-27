<?php
require '../vendor/autoload.php';
require '../config/dev.php';

$router = new \App\config\Router();
$router->run();
