<?php

class MainController
{
    static $_instance;
    private $Db;
    private function __Construct()
    {
        $this->Db = Configuration::getInstance();
    }

    private function __Clone()
    {
    }

    function actionIndex()
    {
        $this->Db->getHeader();
        require_once "view/index.php";
        $this->Db->getFooter();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

?>