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

/** @var \Core\Router $router */
$router = new Core\Router();

// Get data for all years
$router->get('years/all', ['controller' => 'Years', 'action' => 'all']);

// Get data for specific year
$router->get('years/{year:\d+}', ['controller' => 'Years', 'action' => 'byYear']);




$url = rtrim($_SERVER['QUERY_STRING'], '/');
$router->dispatch($url, $_SERVER['REQUEST_METHOD']);