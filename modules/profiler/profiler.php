<?php

/**
 * Created by PhpStorm.
 * User: Asmoria-Y
 * Date: 20.01.2015
 * Time: 21:20
 */

class Profiler {
static $_instance;

    private function __Construct(){

    }

    private function __Clone(){

    }

    public function test(){return 6;}

    public function actionRegister()
    {
        $result = "";
        if(!empty($_POST['mail']) && !empty($_POST['pass'])){
            $db = Configuration::getInstance();
            $mail = $_POST['mail'];
            $pass = $_POST['pass'];
            $sql_ = $db->connection->prepare("INSERT INTO `profile` (`mail`, `pass`)VALUES(:mail, :pass)");
            $sql_->bindValue(':mail', $mail, PDO::PARAM_STR);
            $sql_->bindValue(':pass', $pass, PDO::PARAM_STR);

            $result = $sql_->execute();
            }

        if($result){echo "Success!!!";exit;}
        else die('Error');

    }

    public function getInstance(){
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}



//Profiler::actionRegister();
