<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 01.12.2015
 * Time: 14:41
 */

namespace Asmoria\Modules\Profiler\Models;


use Asmoria\Core\Model;
use Asmoria\Modules\Handler\HandlerController as Handler;
use Asmoria\Modules\Administration\Models\AclUsersModel as UsersRole;

class ProfileModel extends Model{

    public $profile;
    public $table = "profiles";

    public function __construct($id = NULL)
    {
        if(!$id && !empty($_SESSION['u_id'])){
            $id = $_SESSION['u_id'];
        }
        try {
            $this->prefix ? $this->prefix = $this->prefix."_" : $this->prefix = "";
            $where = "";
            if(!empty(intval($id))){
                $where = " WHERE ".$this->idField."=?";
            }
            $sth = \Asmoria\Core\Configuration::getInstance()->connection->prepare("
            SELECT *
            FROM " . $this->prefix . $this->table.$where
            );
            $id = [$id];
            $sth->execute($id);
            $this->profile = $sth->fetchObject();
            $this->profile->isAdmin = UsersRole::getInstance()->isAdmin($this->profile->id);
            parent::__construct();
        }catch (Handler $e){
    }

}


}