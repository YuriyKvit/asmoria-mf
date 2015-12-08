<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 01.12.2015
 * Time: 14:41
 */

namespace Asmoria\Modules\Profiler\Models;


use Asmoria\Core\Model;
use Asmoria\Modules\Handler\HandlerController;

class ProfileModel extends Model{

    public $email;
    public $pass;
    protected $table = "profiles";

    public function __construct($id = NULL)
    {
        if(!$id && !empty($_SESSION['u_id'])){
            $id = $_SESSION['u_id'];
        }
        else{
            HandlerController::getInstance(new \Exception("Missing parameter"))->getError();
        }
        try {
           return parent::__construct($id);
        }catch (HandlerController $e){
    }

}


}