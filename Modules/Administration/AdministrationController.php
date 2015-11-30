<?php
/**
 * Created by PhpStorm.
 * User: Prog1
 * Date: 30.11.2015
 * Time: 15:04
 */

namespace Asmoria\Modules\Administration;

use Asmoria\Core\Configuration;
use Asmoria\Modules\Profiler\ProfilerController;
use Asmoria\Modules\Administration\Models\AclRolesModel as Roles;
use Asmoria\Modules\Administration\Models\AclUsersModel as UsersRole;

class AdministrationController
{
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

    public function actionIndex()
    {
        echo $this->db->getHeader();
        echo "<pre>";
        var_dump(Roles::getInstance()->test());exit;
        echo $this->db->getFooter();
    }

    public function actionTest()
    {
        echo $this->db->getHeader();
        for($i=0; $i<50; $i++){
            echo " <br> Index Here ";
        }
        echo $this->db->getFooter();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


}