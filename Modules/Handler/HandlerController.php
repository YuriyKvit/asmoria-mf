<?php

/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 27.10.2015
 * Time: 9:55
 */
namespace Asmoria\Modules\Handler;

class HandlerController
{
    static $_instance;
    public $string;

    private function __construct()
    {
        $this->string = "
Text text +48 123 456 789
Text text 48-123-456-789
Some Next +380961356537
        ";
    }


    private function __Clone()
    {

    }

    public function actionIndex()
    {
        header("Cache-Control: no-cache");
        echo " <br>Index Here ";
    }

    public function Test($text)
    {
        if (!$text || !is_string($text))
            return false;
        $reg = "~(?<![0-9])\(?(\+\d{2,3})?\)?(?:\s|\-)?(\d{3})(?:\s|\-)?(\d{3})(?:\s|\-)?(\d{3})(?![0-9])~"; //
        $result = preg_replace($reg, ' <a href="tel:$1$2$3$4">($1) $2 $3 $4</a> ', $text);
        return $result;
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


}