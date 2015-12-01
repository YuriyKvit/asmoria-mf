<?php

/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 27.10.2015
 * Time: 9:55
 */
namespace Asmoria\Modules\Profiler;

use Asmoria\Core\Configuration;

class ProfilerController
{
    static $_instance;
    private $db;


    private function __construct()
    {
        $this->db = Configuration::getInstance();
    }


    private function __Clone()
    {

    }

    public function actionIndex()
    {
        echo $this->db->getHeader();
        echo "Index Here";
        echo $this->db->getFooter();
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