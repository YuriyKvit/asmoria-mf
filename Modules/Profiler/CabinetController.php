<?php

namespace Asmoria\Modules\Profiler;

use Asmoria\Modules\Administration\Models\AclUsersModel;
use Asmoria\Modules\Profiler\Models\ProfileModel;

/**
 * Created by PhpStorm.
 * User: Asmoria-Y
 * Date: 20.01.2015
 * Time: 21:20
 */
class CabinetController extends ProfilerController
{
    static $_instance;

    public function __construct()
    {
        parent::__construct();
    }

    private function __Clone()
    {

    }

    public function test(){
        echo "<pre>";
        return new AclUsersModel();
    }

    public function actionIndex()
    {
        $this->view->render('index');
    }


    public function  getProfileInfo(){
        $model = new ProfileModel();
        return $model->profile;
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
