<?php

namespace Asmoria\Core;

use Asmoria\Core\Configuration;
use Asmoria\Modules\Handler\HandlerController;
class View{

    public function __construct()
    {

    }

    public function render($view, $params = [])
    {
        $view = $this->getModuleView($view);
        foreach ($params as $k=>$v) {
            $this->$k = $params[$k];
        }
        echo Configuration::getInstance()->getHeader();
        require_once $view;
        echo Configuration::getInstance()->getFooter();
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
            return  $view;
        }
        throw new HandlerController(new \Exception("View error"));
    }
}