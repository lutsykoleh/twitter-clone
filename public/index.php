<?php 
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

$router = new Router();

$routes = require __DIR__ . '/../app/config/routes.php';
$routes($router);

$router->run();