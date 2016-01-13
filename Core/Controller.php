<?php
/**
 * Created by PhpStorm.
 * User: Prog1
 * Date: 04.01.2016
 * Time: 9:31
 */

namespace Asmoria\Core;

use Asmoria\Modules\Handler\HandlerController;
use Asmoria\Core\View;

class Controller
{

    protected $db;
    public $classMap;
    public $view;

    public function __construct()
    {
        $this->db = Configuration::getInstance();
        $this->classMap = require(ROOT_DIR.'/Core/classes.php');
        $this->view = new View();
    }


    public function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }
        return false;
    }
}