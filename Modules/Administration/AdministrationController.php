<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 30.11.2015
 * Time: 15:04
 */

namespace Asmoria\Modules\Administration;

use Asmoria\Core\Configuration;
use Asmoria\Core\Controller;
use Asmoria\Core\Route;
use Asmoria\Modules\Handler\HandlerController;
use Asmoria\Modules\Profiler\Models\ProfileModel;
use Asmoria\Modules\Profiler\ProfilerController;
use Asmoria\Modules\Administration\Models\AclRolesModel as Roles;
use Asmoria\Modules\Administration\Models\AclUsersModel as UsersRole;

class AdministrationController extends Controller{
    static $_instance;
    public $isAdmin;

    public function __construct()
    {
        $this->isAdmin = ProfilerController::getInstance()->isAdmin;
        if(!$this->isAdmin){
            throw new HandlerController(new \Exception("Page not found"));
        }
        parent::__construct();
    }


    private function __Clone()
    {

    }

    public function actionIndex()
    {

        $this->view->render('index', ['classMap'=>$this->classMap]);

    }

    public function actionTest()
    {
        echo $this->db->getHeader();
        for($i=0; $i<50; $i++){
            echo " <br> Index Here ";
        }
        echo $this->db->getFooter();
    }

    public function getButton()
    {
        return "<a href='".ROOT_URL."/administration/'\" class=\"btn btn-success administration\"> Administration</a>";
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


}