<?php

/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 27.10.2015
 * Time: 9:55
 */
namespace Asmoria\Modules\Profiler;

use Asmoria\Core\Configuration;
use Asmoria\Core\Model;
use Asmoria\Modules\Profiler\Models\ProfileModel;
use Asmoria\Modules\Handler\HandlerController as Handler;
use Asmoria\Modules\Administration\Models\AclUsersModel as UsersRole;


class ProfilerController
{
    static $_instance;
    private $db;
    public $profile;


    public function __construct()
    {
        $this->db = Configuration::getInstance();
        $this->authorize();
    }


    private function __Clone()
    {

    }

    private function authorize()
    {
        $check = array();
        if (!empty($_SESSION['u_mail']) && !empty($_SESSION['u_id'])) {
            return true;
        }
        $result = "";
        if (!empty($_POST['a_email']) && !empty($_POST['a_pass'])) {
            $db = Configuration::getInstance();
            $mail = $_POST['a_email'];
            $pass = $this->db->encodePass($_POST['a_pass']);
            $model = new ProfileModel();
            $sql_ = $db->connection->prepare("SELECT * FROM ".$model->table." WHERE `mail` = :mail AND `pass` = :pass");
            $sql_->bindValue(':mail', $mail, \PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, \PDO::PARAM_STR);
            $sql_->setFetchMode(\PDO::FETCH_CLASS, "Asmoria\\Modules\\Profiler\\Models\\ProfileModel");
            $sql_->execute();
            $result = $sql_->execute();
            $check = $sql_->fetch(\PDO::FETCH_CLASS);
            if ($check->id && empty($_SESSION['u_id'])) {
                $_SESSION['u_id'] = $check->id;
                $_SESSION['u_mail'] = $check->mail;
                $result2['status'] = 'ok';
                $result2['content'] = $db->getLoginBar();
                $this->isAdmin = UsersRole::getInstance()->isAdmin($_SESSION['u_id']);
                echo json_encode($result2);exit;
            }
            else{
                $result2['status'] = 'false';
                $result2['content'] = "Error, try again";
                echo json_encode($result2);exit;
            }
        }
        else {
            //Handler::getInstance(new \Exception("Register or authorize first"), true)->getError();
        }
    }

    public function actionIndex()
    {
        echo $this->db->getHeader();
        echo "Index Here";
        echo $this->db->getFooter();
    }

    public static function test()
    {
        echo "Hi Jack";exit;
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


}