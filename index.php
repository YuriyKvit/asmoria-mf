<?php

ini_set('display_errors', 1);
error_reporting(-1);
define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', "http://".$_SERVER['HTTP_HOST']);
require_once('./Core/Core.php');

class Asmoria extends Asmoria\Core
{
    
}
//Asmoria::Create();

spl_autoload_register(['Asmoria', 'autoload'], true, true);
Asmoria::$classMap = require('Core/classes.php');
Asmoria\Core\Route::getInstance();