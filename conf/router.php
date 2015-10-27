<?php

class Routing
{
    private $default_controller = 'main';
    private $default_module = 'main';
    private $default_action = 'Index';
    private $parameters;
    private $controller_prefix = 'Controller';
    private $action_prefix = 'action';
    private $model_prefix = 'Model_';
    static $_instance;

    private function __construct()
    {
        $this->routes = explode('/', $_SERVER['REQUEST_URI']);

        if (count($this->routes) > 5) die('Method was not found!');
        if (!empty($this->routes[1])) {
            $this->module_name = $this->routes[1];
        } else {
            $this->module_name = $this->default_module;
        }

        if (!empty($this->routes[2])) {
            $this->controller_name = $this->routes[2];
        } else {
            $this->controller_name = $this->controller_prefix.$this->default_controller;
        }

        if (!empty($this->routes[3])) {
            $this->action_name = $this->routes[3];
        } else {
            $this->action_name = $this->default_action;
        }

        if (!empty($this->routes[4])) {
            $this->parameters = $this->routes[4];
        } else {
            $this->parameters = "";
        }

        $this->run();

    }

    function run()
    {
        $controller_file = ucfirst($this->controller_name).$this->controller_prefix . '.php';
        $controller_path = "modules/".$this->module_name . "/" . $controller_file;

        if (file_exists($controller_path)) include_once $controller_path;
        else die('No such file!');
        $f = $this->controller_name;

        $controller = $f::getInstance();

        $action = $this->action_prefix . ucfirst($this->action_name);
        try
        {
            if (method_exists($controller, $action)) {

                $controller->$action();

            }
            else {
                $action = $this->action_prefix . $this->default_action;
                $controller->$action();
            }
        }
        catch (Exception $e)
        {
            die("Action not found");
        }
        exit;
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}