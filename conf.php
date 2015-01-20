<?php
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
$dbName = 'asmoria';
$user = 'root';
$pass = '';
try {
    $dbh = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
//    foreach ($dbh->query('SELECT * from FOO') as $row) {
//        print_r($row);
//    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
