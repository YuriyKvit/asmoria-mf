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
    public $table = "roles";
    public $prefix = "acl";

    public function __construct()
    {
        parent::__construct();
    }


    private function __Clone()
    {

    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}