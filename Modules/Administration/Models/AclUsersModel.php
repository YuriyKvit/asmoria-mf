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
use Asmoria\Modules\Handler\HandlerController;
use Asmoria\Modules\Administration\Models\AclRolesModel as Roles;


class AclUsersModel extends Model
{

    static $_instance;
    public $idField = "usr_id";
    public $table = "users_role";
    public $prefix = "acl";

    public function __construct()
    {
        parent::__construct();
    }


    private function __Clone()
    {

    }

    public function isAdmin($id)
    {
        $role = $this->getById($id);
        if ($role === FALSE)
            return FALSE;
        $role = Roles::getInstance()->getById($role->role_id);
        return intval($role->id) === ADMIN_ROLE ? TRUE : FALSE;
    }

    public function setRole($user_id, $role)
    {
        $this->usr_id = intval($user_id);
        $this->role_id = intval($role);
        return $this->save();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}