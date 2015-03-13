<?php

/**
 * Created by PhpStorm.
 * User: Asmoria-Y
 * Date: 20.01.2015
 * Time: 21:20
 */
class Profiler
{
    static $_instance;
    private $Db;

    private function __Construct()
    {
        $this->Db = Configuration::getInstance();
        $this->root_dir = "http://".$_SERVER['HTTP_HOST'];
    }

    private function __Clone()
    {

    }

    public function test()
    {
        return 6;
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
                echo "<ul>";
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul>";
                exit;
            }


            $pass = $this->Db->encodePass($pass);
            $db = Configuration::getInstance();

            $sql_ = $db->connection->prepare("INSERT INTO `profiles` (`mail`, `pass`)VALUES(:mail, :pass)");
            $sql_->bindValue(':mail', $email, PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, PDO::PARAM_STR);
            $result['status'] = $sql_->execute();
            $sql_ = $db->connection->prepare("SELECT * FROM `profiles` WHERE `mail` = :mail AND `pass` = :pass");
            $sql_->bindValue(':mail', $email, PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, PDO::PARAM_STR);
            $result['status'] = $sql_->execute();
            $result['data'] = $sql_->fetch(PDO::FETCH_ASSOC);
        }

        if ($result) {
                if(!isset($_SESSION))
                    session_start();
            $_SESSION['u_id'] = $result['data']['id'];
            $_SESSION['u_mail'] = $result['data']['mail'];
            $result['loginBar'] = $db->getLoginBar();
            $result['content'] = "Welcome to aboard";
            echo json_encode($result);
            exit;
        } else die('Error');

    }

    public function actionAuth()
    {
        $check = array();
        if (!empty($_SESSION['u_mail']) && !empty($_SESSION['u_id'])) {

            exit;
        }
        $result = "";
        if (!empty($_POST['a_email']) && !empty($_POST['a_pass'])) {
            $db = Configuration::getInstance();
            $mail = $_POST['a_email'];
            $pass = $this->Db->encodePass($_POST['a_pass']);
            $sql_ = $db->connection->prepare("SELECT * FROM `profiles` WHERE `mail` = :mail AND `pass` = :pass");
            $sql_->bindValue(':mail', $mail, PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, PDO::PARAM_STR);
            $result = $sql_->execute();
            $check = $sql_->fetch(PDO::FETCH_ASSOC);
            if ($check['id'] && empty($_SESSION['u_id'])) {
                $_SESSION['u_id'] = $check['id'];
                $_SESSION['u_mail'] = $check['mail'];
                $result2['status'] = 'ok';
                $result2['content'] = $db->getLoginBar();
                echo json_encode($result2);exit;
            }
            else{
                $result2['status'] = 'false';
                $result2['content'] = "";
                echo json_encode($result2);exit;
            }
        }
    }

    public function actionLogout(){
        session_destroy();
        header('Location: http://asmoria');
    }

    public function actionCabinet()
    {
        $this->Db->getHeader();

        require_once "view/index.php";

        $this->Db->getFooter();
        exit;
    }

    public function  getProfileInfo($id){
        $id = (int)$id;
        $sql_ = $this->Db->connection->prepare("SELECT * FROM `profiles` WHERE `id` = :id");
        $sql_->bindValue(':id', $id, PDO::PARAM_INT);
        $sql_->execute();
        return $sql_->fetch(PDO::FETCH_ASSOC);
    }

    public function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
