<?php
ini_set('memory_limit', '-1');
/**
 * Created by PhpStorm.
 * User: Asmoria-Y
 * Date: 20.01.2015
 * Time: 20:20
 *
 * Here will be connect to database and other configurations
 *
 *
 *
 */

require_once('router.php');
ini_set('display_errors', 1);

class Configuration{
    var $dbName;
    var $dbUser;
    var $dbPass;
    var $connection;
    static $_instance;

    private function __Clone(){}

    private function Configuration (){

        $this->dbName = "asmoria";
        $this->dbUser = "root";
        $this->dbPass = "";
        $this->connection = '';
        ini_set('memory_limit', '128M');
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=' . $this->dbName, $this->dbUser, $this->dbPass, array(PDO::ATTR_PERSISTENT => true));

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
}
    public  function getInstance(){
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function insert($sql) {
        $sql_ = $this->connection->prepare($sql);
        return $sql_->execute();
    }

}
?>
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


