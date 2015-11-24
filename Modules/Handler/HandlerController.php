<?php

/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 27.10.2015
 * Time: 9:55
 */
namespace Asmoria\Modules\Handler\HandlerController;
echo "HandlerController";

class HandlerController
{
    static $_instance;


    private function __construct()
    {
        echo "sdfsdfsdfsdf";
    }


    private function __Clone()
    {

    }


    public static function test()
    {
       echo "Hi Jack";exit;
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


}