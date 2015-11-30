<?php
/**
 * Created by PhpStorm.
 * User: Prog1
 * Date: 30.11.2015
 * Time: 16:45
 */

namespace Asmoria\Modules\Administration\Models;

use Asmoria\Core\Configuration;
use Asmoria\Modules\Profiler\ProfilerController;

class AclRolesModel {
    static $_instance;
    public $db;

    private function __construct()
    {
        $this->db = Configuration::getInstance();
        $this->profile = ProfilerController::getInstance();
    }


    private function __Clone()
    {

    }

    public function test(){
        return "Hello World";
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}