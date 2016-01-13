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
use Asmoria\Modules\Administration\AdministrationController;
use Asmoria\Modules\Handler;
use Asmoria\Modules\Profiler\ProfilerController;

ini_set('memory_limit', '-1');
define("ADMIN_ROLE", 3);
define("USER_ROLE", 4);
session_start();

class Configuration
{
    private $dbName;
    private $dbUser;
    private $dbPass;
    public $template = "base";
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
            Handler\HandlerController::getInstance($e)->dbError();
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
}


