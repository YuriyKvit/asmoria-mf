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
use Asmoria\Core\View;
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
        if ($this->isAuthorized()) {
            $this->isAdmin = UsersRole::getInstance()->isAdmin($_SESSION['u_id']);
        }
        else $this->authorize();
        $this->view = new View();
        $this->view->title = "Profile";
    }


    private function __Clone()
    {

    }

    public function isAuthorized()
    {
        return !empty($_SESSION['u_id']) ? TRUE : FALSE;
    }

    private function authorize()
    {
        if (isset($_POST['submit']))
            if (!empty($_POST['a_email']) && !empty($_POST['a_pass'])) {
                $mail = $_POST['a_email'];
                $pass = $this->db->encodePass($_POST['a_pass']);
                $model = new ProfileModel();
                $sql_ = $this->db->connection->prepare("SELECT * FROM " . $model->table . " WHERE `mail` = :mail AND `pass` = :pass");
                $sql_->bindValue(':mail', $mail, \PDO::PARAM_STR);
                $sql_->bindValue(':pass', $pass, \PDO::PARAM_STR);
                $sql_->setFetchMode(\PDO::FETCH_CLASS, "Asmoria\\Modules\\Profiler\\Models\\ProfileModel");
                try{
                if($sql_->execute() === FALSE){
                    throw new HandlerController(new \Exception("Wrong query"), true);
                }
                $user = $sql_->fetch(\PDO::FETCH_CLASS);
                    if($user === FALSE){
                        throw new HandlerController(new \Exception("Wrong user"), true);
                    }
                    $_SESSION['u_id'] = $user->id;
                    $_SESSION['u_mail'] = $user->mail;
                    $result['status'] = 'ok';
                    $result['content'] = $this->view->getLoginBar();
                    echo json_encode($result);
                    exit;
                }catch(\PDOException $e){
                    throw new HandlerController($e);
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
            $result['loginBar'] = $this->view->getLoginBar();
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