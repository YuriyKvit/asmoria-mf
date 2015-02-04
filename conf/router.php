<?php

class Routing {
    private $default_controller = 'Main';
    private $default_module = 'modules';
    private $default_action = 'index';
    private $controller_prefix = 'Controller_';
    private $action_prefix = 'action';
    private $model_prefix = 'Model_';
    static $_instance;

    private function __construct (){
        echo "Im Here<br>";
        $this->routes = explode('/', $_SERVER['REQUEST_URI']);
        if (count($this->routes)>4) die('Method was not found!');
        if ( !empty($this->routes[1]) ) {
            $this->module_name = $this->routes[1];
        } else {
            $this->module_name = $this->default_module;
        }

        if (!empty($this->routes[2])) {
            $this->controller_name = $this->routes[2];
        } else {
            $this->controller_name = $this->default_controller;
        }

        if (!empty($this->routes[3])) {
            $this->action_name = $this->routes[3];
        } else {
            $this->action_name = $this->default_action;
        }

        $this->run();

    }
    function run()
    {
        $model_file = strtolower($this->controller_name) . '.php';
        $model_path = $this->module_name ."/" . $this->controller_name ."/" . $model_file;
//var_dump($model_path);exit;
        if(file_exists($model_path)) include_once $model_path;//"modules/" . $this->module_name ."/" .$model_file;
        else die('No such file!');
        $f = $this->controller_name;
        $controller = $f::getInstance();

        $action = $this->action_prefix.$this->action_name;
//        echo "<pre>";
//        var_dump($controller->test());exit;
        if(1==1){

            $controller->$action();

        }
        else die('No such action!');
    }

    public  function getInstance(){
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}