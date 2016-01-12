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
        if (!empty($_SESSION['u_id']))
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
        if (isset($_POST['submit']))
            if (!empty($_POST['a_email']) && !empty($_POST['a_pass'])) {
                $mail = $_POST['a_email'];
                $pass = $this->db->encodePass($_POST['a_pass']);
                $model = new ProfileModel();
                $sql_ = $this->db->connection->prepare("SELECT * FROM " . $model->table . " WHERE `mail` = :mail AND `pass` = :pass");
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
                    echo json_encode($result2);
                    exit;
                } else {
                    $result2['status'] = 'false';
                    $result2['content'] = "Error, try again";
                    echo json_encode($result2);
                    exit;
                }
            } else {
                throw new HandlerController(new \Exception("Fill all fields first"), true);
            }
        return true;
    }


    public function actionRegister()
    {
        $result = "";
        try {
            $model = new ProfileModel();
            $model->validate();
            $model->pass = $this->db->encodePass($_POST['pass']);
            $model->mail = $_POST['mail'];
            $id = $model->save();
        } catch (\Exception $e) {
            throw new HandlerController($e);
        }
        if (intval($id) > 0) {
            $result['status'] = TRUE;
            $result['data'] = new ProfileModel($id);
        } else {
            $result['status'] = FALSE;
        }

        if ($result['status']) {
            if (!isset($_SESSION))
                session_start();
            $_SESSION['u_id'] = $result['data']->profile->id;
            $_SESSION['u_mail'] = $result['data']->profile->mail;
            $result['loginBar'] = $this->db->getLoginBar();
            $result['content'] = "Welcome to aboard";
            echo json_encode($result);
            exit;
        } else
            $result['errors'] = "<ul><li>User already exists</li></ul>";
        echo json_encode($result);
        exit;
    }


    public function actionLogout()
    {
        session_destroy();
        header('Location: ' . ROOT_URL);
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