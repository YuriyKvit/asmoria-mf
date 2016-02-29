<?php

namespace Asmoria\Modules\Main;

use \Asmoria\Core\Route;
use \Asmoria\Core\Configuration;
use Asmoria\Core\View;

class MainController
{
    static $_instance;
    private $Db;
    public function __Construct()
    {
        $this->Db = Configuration::getInstance();
        $this->view = new View();
    }

    private function __Clone()
    {

    }


    function test(){
        echo "777";exit;
    }
    function actionIndex()
    {
        $this->view->render();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
