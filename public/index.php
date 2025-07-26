<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../App/config/bootstrap.php';

use App\Core\Router; // Changer le namespace ici

$routes = require_once __DIR__.'/../routes/route.web.php';
$middlewares = require_once __DIR__.'/../App/config/middlewares.php';

Router::resolve($routes, $middlewares);