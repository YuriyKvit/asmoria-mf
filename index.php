<?php
ini_set('display_errors', 1);
error_reporting(-1);
define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', "http://".$_SERVER['HTTP_HOST']);
require_once('./Core/Route.php');
use Core\Route as Route;
//require_once('./Core/Configuration.php');
//$route = Core\Route::getInstance();
//$route->run();