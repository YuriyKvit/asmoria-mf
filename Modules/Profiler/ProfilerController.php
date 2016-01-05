<?php

/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 27.10.2015
 * Time: 9:55
 */
namespace Asmoria\Modules\Profiler;

use Asmoria\Core\Configuration;
use Asmoria\Core\Controller;
use Asmoria\Modules\Handler\HandlerController;
use Asmoria\Modules\Profiler\Models\ProfileModel;
use Asmoria\Modules\Handler\HandlerController as Handler;
use Asmoria\Modules\Administration\Models\AclUsersModel as UsersRole;


class ProfilerController extends Controller
{
    static $_instance;
    public $profile;
    public $isAdmin;


    public function __construct()
    {
        parent::__construct();
        $this->authorize();
        if(!empty($_SESSION['u_id']))
        $this->isAdmin = UsersRole::getInstance()->isAdmin($_SESSION['u_id']);
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
        if(isset($_POST['submit']))
        if (!empty($_POST['a_email']) && !empty($_POST['a_pass'])) {
            $mail = $_POST['a_email'];
            $pass = $this->db->encodePass($_POST['a_pass']);
            $model = new ProfileModel();
            $sql_ = $this->db->connection->prepare("SELECT * FROM ".$model->table." WHERE `mail` = :mail AND `pass` = :pass");
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
                $result2['content'] = $this->db->getLoginBar();
                echo json_encode($result2);exit;
            }
            else{
                $result2['status'] = 'false';
                $result2['content'] = "Error, try again";
                echo json_encode($result2);exit;
            }
        }
        else {
            throw new HandlerController(new \Exception("Fill all fields first"), true);
        }
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


            $pass = $this->db->encodePass($pass);

            $sql_ = $this->db->connection->prepare("INSERT INTO `profiles` (`mail`, `pass`)VALUES(:mail, :pass)");
            $sql_->bindValue(':mail', $email, \PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, \PDO::PARAM_STR);
            $result['status'] = $sql_->execute();
            $sql_ = $this->db->connection->prepare("SELECT * FROM `profiles` WHERE `mail` = :mail AND `pass` = :pass");
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
            $result['loginBar'] = $this->db->getLoginBar();
            $result['content'] = "Welcome to aboard";
            echo json_encode($result);
            exit;
        } else die('Error');

    }



    public function actionLogout(){
        session_destroy();
        header('Location: '.ROOT_URL);
    }


    public function actionIndex()
    {
        $this->view->render('index');
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


}