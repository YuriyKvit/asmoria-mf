<?php

namespace Asmoria\Modules\Profiler;

use Asmoria\Core\Configuration;
use Asmoria\Modules\Handler\HandlerController as Handler;
use Asmoria\Modules\Administration\Models\AclUsersModel as UsersRole;
use Asmoria\Modules\Handler\HandlerController;
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
    private $Db;
    public $isAdmin;

    public function __Construct()
    {
        try{
        $this->Db = Configuration::getInstance();
        $this->root_dir = "http://".$_SERVER['HTTP_HOST'];
        parent::__Construct();
        } catch(HandlerController $e){
            $e->getError();
        }
    }

    private function __Clone()
    {

    }


    public function actionIndex()
    {
        $this->Db->getHeader();

        require_once "view/index.php";

        $this->Db->getFooter();
        exit;
    }


    public function actionTest()
    {
//        Handler::getInstance()->test("qwertyuio");
//        echo $hjh;exit;
    }

    public function actionRegister()
    {
        $result = "";
        if (!empty($_POST['mail']) && !empty($_POST['pass'])) {
            $email = $_POST['mail'];
            $pass = $_POST['pass'];
            $conf_pass = $_POST['conf_pass'];

            $passlen = strlen($pass);
            $emaillen = strlen($email);
            $max = 255;
            $minpass = 6;
            $minemail = 3;

            if($passlen < $minpass){
                $errors[] = "pass must be at least $minpass characters";
            } elseif($passlen > $max){
                $errors[] = "pass must be less than $max characters";
            }

            if($emaillen < $minemail){
                $errors[] = "email must be at least $minemail characters";
            } elseif($emaillen > $max){
                $errors[] = "email must be less than $max characters";
            }

            if($pass != $conf_pass){
                $errors[] = "your passwords do not match";
            }

            if(empty($pass)){
                $errors[] = "pass is required";
            }

            if(empty($email)){
                $errors[] = "email cannot be left empty";
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[] = "invalid email";
            }
            if (!empty($errors)) {
//                echo json_encode($errors);
                $result['errors'] = "<ul>";
                foreach ($errors as $error) {
                    $result['errors'] .= "<li>$error</li>";
                }
                $result['errors'] .= "</ul>";
                echo json_encode($result);
                exit;
            }


            $pass = $this->Db->encodePass($pass);
            $db = Configuration::getInstance();

            $sql_ = $db->connection->prepare("INSERT INTO `profiles` (`mail`, `pass`)VALUES(:mail, :pass)");
            $sql_->bindValue(':mail', $email, \PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, \PDO::PARAM_STR);
            $result['status'] = $sql_->execute();
            $sql_ = $db->connection->prepare("SELECT * FROM `profiles` WHERE `mail` = :mail AND `pass` = :pass");
            $sql_->bindValue(':mail', $email, \PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, \PDO::PARAM_STR);
            $result['status'] = $sql_->execute();
            $result['data'] = $sql_->fetch(\PDO::FETCH_ASSOC);
        }

        if ($result) {
                if(!isset($_SESSION))
                    session_start();
            $_SESSION['u_id'] = $result['data']['id'];
            $_SESSION['u_mail'] = $result['data']['mail'];
            $result['loginBar'] = $this->Db->getLoginBar();
            $result['content'] = "Welcome to aboard";
            echo json_encode($result);
            exit;
        } else die('Error');

    }

    public function actionAuth()
    {
    }

    public function actionLogout(){
        session_destroy();
        header('Location: '.ROOT_URL);
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
