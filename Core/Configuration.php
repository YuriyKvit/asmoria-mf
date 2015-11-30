<?php

/**
 * Created by PhpStorm.
 * User: Asmoria-Y
 * Date: 20.01.2015
 * Time: 20:20
 *
 * Here will be connect to database and other configurations
 *
 */

namespace Asmoria\Core;

use \Asmoria\Core\Route;

ini_set('memory_limit', '-1');

session_start();

class Configuration
{
     private $dbName;
     private $dbUser;
     private $dbPass;
     public $connection;
    static $_instance;

    private function __Clone()
    {
    }

    private function __construct()
    {

        $this->dbName = "asmoria";
        $this->dbUser = "root";
        $this->dbPass = "";
        $this->connection = '';
        ini_set('memory_limit', '128M');
        try {
            $this->connection = new \PDO('mysql:host=localhost;dbname=' . $this->dbName, $this->dbUser, $this->dbPass, array(\PDO::ATTR_PERSISTENT => true));

        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function insert($sql)
    {
        $sql_ = $this->connection->prepare($sql);
        return $sql_->execute();
    }

    public function getLoggedId()
    {
        if (!empty($_SESSION['u_id'])) {
            $u_id = $_SESSION['u_id'];
        } else {
            $u_id = 0;
        }
        return $u_id;
    }

    public function encodePass($pass)
    {
        $options = [
            'cost' => 11,
            'salt' => "546546F.#@&!(&%bcch'>?<54/*-+784$^(YI",
        ];
        return password_hash($pass, PASSWORD_BCRYPT, $options);
    }

    public function getLoginBar()
    {
        if (!$this->getLoggedId()) {
            $login_bar = <<<LBR
<form class="navbar-form navbar-right auth_form" target="_self" name="auth_main" method="post"
                      action="" enctype="multipart/form-data" onsubmit="ajaxSubmit_c('auth')">
                    <div class="form-group">
                        <input type="email" name="a_email" placeholder="Email" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="a_pass" placeholder="Password" class="form-control" required/>
                    </div>
                    <button type="submit" id="sbmt" class="btn btn-success">Sign in</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#asmo-register">
                        Registration
                    </button>
                </form>;
LBR;

        } else {
            $login_bar = <<<LBR
<div class="navbar-right"><a class="btn btn-primary logout" href="http://{$_SERVER['HTTP_HOST']}/profiler/cabinet/logout">Logout</a>
                    <a href="http://{$_SERVER['HTTP_HOST']}/profiler/cabinet" class="btn btn-success logout"> Cabinet</a>
                </div>
LBR;

        }
        return $login_bar;
    }

    public function getHeader()
    {

        $header = <<<EOL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <link href="../../style/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../style/css/custom.css" rel="stylesheet">
    <title>Profiler</title>
</head>
<script src="../../style/js/jquery-1.11.2.min.js"></script>
<script src="../../style/js/bootstrap.min.js"></script>
<script src="../../style/js/custom.js"></script>
<body>
<nav class="navbar header navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="http://{$_SERVER['HTTP_HOST']}"><b>Asmoria</b></a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        <div id="navbar" class="navbar-collapse collapse auth">
            <div class="navbar-right logout-wrap">
            {$this->getLoginBar()}
            </div>
        </div>
        <!--/.navbar-collapse -->
    </div>
</nav>
</body>
EOL;
        echo $header;

    }

    public function getFooter()
    {
        $footer = <<<FOT
    <footer>
        <h5><p>&copy; Asmoria corp 2015</p></h5>
    </footer>
FOT;
        echo $footer;
        exit;
    }
}


