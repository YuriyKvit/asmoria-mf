<?php

namespace Asmoria\Core;

use Asmoria;

class Route
{
    private $default_controller;
    private $default_module = 'Main';
    private $default_action = 'Index';
    private $parameters;
    private $controller_prefix = 'Controller';
    private $action_prefix = 'action';
    private $model_prefix = 'Model_';
    static $_instance;
    public $namespace = ALIAS . "\\Modules\\Main";
    public static $module;
    public static $modules_dir = "Modules";
    public static $view_dir = "view";

    public function __construct()
    {
        $this->routes = explode('/', $_SERVER['REQUEST_URI']);

        if (count($this->routes) > 5) die('Method was not found!');
        if (!empty($this->routes[1])) {
            $this->module_name = $this->routes[1];
            $this->default_controller = $this->module_name;
        } else {
            $this->module_name = $this->default_module;
        }

        if (!empty($this->routes[2])) {
            $this->controller_name = ucfirst($this->routes[2]) . $this->controller_prefix;
            $this->namespace = ALIAS . "\\Modules\\" . ucfirst($this->module_name);
        } else {
            $this->controller_name = $this->module_name . $this->controller_prefix;
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
        self::$module = $this->module_name;
        $this->run();

    }

    public function run()
    {
        try {
            if (isset(Asmoria::$classMap[$this->namespace . '\\' . $this->controller_name])) {
                $classFile = Asmoria::$classMap[$this->namespace . '\\' . $this->controller_name];
                require_once $classFile;
            }
            if ($this->module_name !== $this->default_module) {
                $controller_file = ucfirst($this->controller_name) . '.php';
                $controller_path = "Modules/" . $this->module_name . "/" . $controller_file;
                if (!is_file($controller_path)) {
                    $this->controller_name = $this->default_controller . $this->controller_prefix;
                    $controller_path = "Modules/" . $this->module_name . "/" . $this->controller_name . '.php';
                    $this->action_name = $this->routes[2];
                    $this->parameters = !empty($this->routes[3]) ? $this->routes[3] : NULL;
                }
                if(!file_exists($controller_path))
                    throw new Asmoria\Modules\Handler\HandlerController(new \Exception("Wrong way"));
                require_once $controller_path;

                $f = ALIAS . "\\Modules\\" . $this->module_name . "\\" . $this->controller_name;
            } else {
                $f = $this->namespace . '\\' . $this->controller_name;
            }
            $controller = new $f();
            $action = $this->action_prefix . $this->action_name;
            try {
                if (method_exists($controller, $action)) {
                    parse_str($this->parameters, $params);
                    $_GET = $params;
                    $_GET['q'] = $this->module_name . '/' . $this->controller_name . '/' . $this->action_name;
                    call_user_func_array(array($controller, $action), array_values($params));
                } else {
                    if(empty($this->routes[3]))
                        throw new \Exception("Wrong way!");
                    $action = $this->action_prefix . $this->default_action;
                    $this->parameters = $this->routes[3];
                    parse_str($this->parameters, $params);
                    $_GET = $params;
                    $_GET['q'] = $this->module_name . '/' . $this->controller_name . '/' . $action;
                    call_user_func_array(array($controller, $action), array_values($params));
                }
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        } catch (\Exception $e) {
            die($e->getMessage());
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

$app = new Route();
$app->run();