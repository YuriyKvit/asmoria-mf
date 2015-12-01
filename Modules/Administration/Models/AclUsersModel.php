<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 30.11.2015
 * Time: 16:46
 */

namespace Asmoria\Modules\Administration\Models;

use Asmoria\Core\Model;
use Asmoria\Modules\Profiler\ProfilerController;

class AclUsersModel extends Model{

    static $_instance;

    protected function __construct()
    {
        parent::__construct();
//        $this->profile = ProfilerController::getInstance();
        $this->prefix = "acl";
        $this->table = "users_role";
        $this->idField = "usr_id";
    }


    private function __Clone()
    {

    }

    public function test()
    {
       return $this->getById(1);
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}