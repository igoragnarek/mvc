<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

/*
function exception_handler($exception) {
    echo "PDO ERROR: " , $exception->getMessage(), "\n";
}

set_exception_handler('exception_handler');
*/

$router = new Router;
$router->run();