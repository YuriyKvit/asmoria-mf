<?php

/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 27.10.2015
 * Time: 9:55
 */
namespace Asmoria\Modules\Handler;

class HandlerController extends \Exception
{
    static $_instance;
    public $code;
    public $message;
    public $line;
    public $file;
    public $json;

    public function __construct($e, $json = false)
    {
        var_dump(get_called_class());
        $this->code = $e->getCode();
        $this->message = $e->getMessage();
        $this->line = $e->getLine();
        $this->file = $e->getFile();
        $this->json = $json;
    }


    public function dbError()
    {
        if(strstr($this->message, 'SQLSTATE[')) {
            preg_match('/SQLSTATE\[(\w+)\] \[(\w+)\] (.*)/', $this->message, $matches);
            $this->code = ($matches[1] == 'HT000' ? $matches[2] : $matches[1]);
            $this->message = $matches[3];
        }
            die(require_once "view/index.php");
    }


    public function getError()
    {
        if($this->json){
            die(json_encode(['status'=>false, 'content'=>$this->message]));
        }
        header("Location:".ROOT_URL."/handler");
        die(require_once"view/index.php");
    }

    public function actionIndex()
    {
        echo " <br>Index Here ";
    }


    public static function getInstance($e = "", $json = false)
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($e, $json);
        }
        return self::$_instance;
    }


}