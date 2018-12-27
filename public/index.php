<?php
/**
 * Composer
 */
require '../vendor/autoload.php';

/**
 * Error and Exception handling
 * */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);



//var_dump($router->getRoutes());
$url = rtrim($_SERVER['QUERY_STRING'], '/');
$router->dispatch($url);