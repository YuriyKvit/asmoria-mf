<?php

class Main
{
    static $_instance;

    private function __Construct()
    {
    }

    private function __Clone()
    {
    }

    function actionIndex()
    {

        echo $_SESSION['u_id'];
    }

    public function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

?>