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

    public function __construct()
    {
        parent::__construct();
        $this->view->title = "Cabinet";
    }

    private function __Clone()
    {

    }

    public function actionTest(){
        $conn = new \PDO('mysql:dbname=asmoria;host=127.0.0.1', 'root', '');

//        $conn->exec('CREATE TABLE testIncrement ' .
//            '(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50))');
        $sth = $conn->prepare('INSERT INTO testIncrement (name) VALUES (:name)');
        $sth->execute([':name' => 'foo']);
        var_dump($conn->lastInsertId());
//        $conn->exec('DROP TABLE testIncrement');
    }

    public function actionIndex()
    {
        $this->view->render('cabinet', ['profile' => $this->getProfileInfo()]);
    }


    public function  getProfileInfo(){
        $model = new ProfileModel();
        return $model->profile;
    }

}
