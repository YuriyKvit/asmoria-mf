<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 01.12.2015
 * Time: 14:41
 */

namespace Asmoria\Modules\Profiler\Models;


use Asmoria\Core\Model;
use Asmoria\Core\Configuration;
use Asmoria\Modules\Handler\HandlerController as Handler;
use Asmoria\Modules\Administration\Models\AclUsersModel as UsersRole;
use Asmoria\Modules\Handler\HandlerController;

class ProfileModel extends Model
{

    public $profile;
    public $table = "profiles";
    private $max = 255;
    private $minpass = 6;
    private $minemail = 3;

    public function __construct($id = NULL)
    {
        parent::__construct();
        if (!$id && !empty($_SESSION['u_id'])) {
            $id = $_SESSION['u_id'];
        }
        try {
            $where = "";
            if (!empty(intval($id))) {
                $where = " WHERE " . $this->idField . "=?";
            }
            $sth = Configuration::getInstance()->connection->prepare("
            SELECT *
            FROM " . $this->table . $where
            );
            $id = [$id];
            $sth->execute($id);
            $this->profile = $sth->fetchObject();
            $this->profile->isAdmin = UsersRole::getInstance()->isAdmin($this->profile->id);
        } catch (\PDOException $e) {
            throw new HandlerController($e);
        }

    }

    public function validate()
    {
        parent::validate(); // TODO: Change parent method
        $email = $_POST['mail'];
        $pass = $_POST['pass'];
        $conf_pass = $_POST['conf_pass'];

        $passlen = strlen($pass);
        $emaillen = strlen($email);

        if ($passlen < $this->minpass) {
            $errors[] = "pass must be at least $this->minpass characters";
        } elseif ($passlen > $this->max) {
            $errors[] = "pass must be less than $this->max characters";
        }

        if ($emaillen < $this->minemail) {
            $errors[] = "email must be at least $this->minemail characters";
        } elseif ($emaillen > $this->max) {
            $errors[] = "email must be less than $this->max characters";
        }

        if ($pass != $conf_pass) {
            $errors[] = "your passwords do not match";
        }

        if (empty($pass)) {
            $errors[] = "pass is required";
        }

        if (empty($email)) {
            $errors[] = "email cannot be left empty";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "invalid email";
        }
        if (!empty($errors)) {
            $result['errors'] = "<ul>";
            foreach ($errors as $error) {
                $result['errors'] .= "<li>$error</li>";
            }
            $result['errors'] .= "</ul>";
            echo json_encode($result);
            exit;

        }
    }
}