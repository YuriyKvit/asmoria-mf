<?php
/**
 * Created by PhpStorm.
 * User: Prog1
 * Date: 04.01.2016
 * Time: 9:31
 */

namespace Asmoria\Core;

use Asmoria\Modules\Handler\HandlerController;
use Asmoria\Core\Configuration;

class Controller
{

    public $db;
    public $classMap;

    public function __construct()
    {
        $this->db = Configuration::getInstance();
        $this->classMap = require(ROOT_DIR.'/Core/classes.php');
    }

    public function render($view)
    {
        echo $this->db->getHeader();
        $this->getModuleView($view);
        echo $this->db->getFooter();
    }

    private function getModuleView($view = "")
    {
        $view = $view ? $view : "index";
        $view = ROOT_DIR.DIRECTORY_SEPARATOR.
            Route::$modules_dir.DIRECTORY_SEPARATOR.
            Route::$module.DIRECTORY_SEPARATOR.
            Route::$view_dir.DIRECTORY_SEPARATOR.
            $view.".php";
        if(file_exists($view)){
            return require_once  $view;
        }
       throw new HandlerController(new \Exception("View error"));
    }
}