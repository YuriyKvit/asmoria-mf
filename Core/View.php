<?php

namespace Asmoria\Core;

use Asmoria\Modules\Handler\HandlerController;
use Asmoria\Modules\Profiler\ProfilerController;
use Asmoria\Modules\Administration\AdministrationController;

class View
{

    public function __construct()
    {
        $this->template = Configuration::getInstance()->template;
        $this->path = ROOT_DIR . "/templates/" . $this->template;
        $this->title = "Home";
    }

    public function render($view = "", $params = [])
    {
        $view = $this->getModuleView($view);
        foreach ($params as $k => $v) {
            $this->$k = $params[$k];
        }
        echo $this->getHeader();
        require_once $view;
        echo $this->getFooter();
    }

    private function getModuleView($view = "")
    {
        $view = $view ? $view : "index";
        $view = ROOT_DIR . DIRECTORY_SEPARATOR .
            Route::$modules_dir . DIRECTORY_SEPARATOR .
            Route::$module . DIRECTORY_SEPARATOR .
            Route::$view_dir . DIRECTORY_SEPARATOR .
            $view . ".html";
        if (file_exists($view)) {
            return $view;
        }
        throw new HandlerController(new \Exception("View error"));
    }


    public function getLoginBar()
    {
        if (!file_exists($this->path . "/login.html") || !file_exists($this->path . "/logged.html")) {
            throw new HandlerController(new \Exception("Missed login or logged html file"));
        }
        $panelButton = ProfilerController::getInstance()->isAdmin ? AdministrationController::getInstance()->getButton() : "";
        ob_start();
        if (!Configuration::getInstance()->getLoggedId()) {
            require_once $this->path . "/login.html";
            $login_bar = ob_get_contents();
            ob_end_clean();
        } else {
            require_once $this->path . "/logged.html";
            $login_bar = ob_get_contents();
            ob_end_clean();
        }
        return $login_bar;
    }


    public function getHeader()
    {
        if (!file_exists($this->path . "/header.html")) {
            throw new HandlerController(new \Exception("Missed header html file"));
        }
        require_once $this->path . "/header.html";
        return FALSE;
    }

    public function getFooter()
    {
        if (!file_exists($this->path . "/footer.html")) {
            throw new HandlerController(new \Exception("Missed footer html file"));
        }
        require_once $this->path . "/footer.html";
        return FALSE;
    }
}