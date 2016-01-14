<?php

ini_set('display_errors', 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);
define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', "http://".$_SERVER['HTTP_HOST']);
define('ALIAS', 'Asmoria');
require_once('./Core/Core.php');

class Asmoria extends Asmoria\Core
{
    
}

spl_autoload_register(['Asmoria', 'autoload'], true, true);
Asmoria::$classMap = require('Core/classes.php');
Asmoria::Create();
Asmoria\Core\Route::getInstance();