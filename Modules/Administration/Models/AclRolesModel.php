<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 30.11.2015
 * Time: 16:45
 */

namespace Asmoria\Modules\Administration\Models;

use Asmoria\Core\Model;
use Asmoria\Modules\Profiler\ProfilerController;

class AclRolesModel extends Model
{

    static $_instance;
    public $id;
    public $type;

    protected function __construct()
    {
        parent::__construct();
//        $this->profile = ProfilerController::getInstance();
        $this->prefix = "acl";
        $this->table = "roles";
        $this->idField = "usr_id";
    }


    private function __Clone()
    {

    }

    public function test()
    {
       return $this->getById(2);//$this->select(["type", "id"], ["type" => "ADMIN", "id" => 1]);
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}