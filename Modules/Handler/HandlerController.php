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
    public static $message_;
    public $line;
    public $file;
    public $json;

    public function __construct(\Exception $e, $json = false)
    {
        $this->code = $e->getCode();
        self::$message_ = $e->getMessage();
        $this->line = $e->getLine();
        $this->file = $e->getFile();
        $this->json = $json;
        if(strstr(self::$message_, 'SQLSTATE[')) {
            preg_match('/SQLSTATE\[(\w+)\] \[(\w+)\] (.*)/', self::$message_, $matches);
            $this->code = ($matches[1] == 'HT000' ? $matches[2] : $matches[1]);
            self::$message_ = $matches[3];
        }
        if($this->json){
            die(json_encode(['status'=>false, 'content'=>self::$message_]));
        }
        require_once "view/index.html";
    }


    public function dbError()
    {
        if(strstr(self::$message_, 'SQLSTATE[')) {

        }
            die(require_once "view/index.html");
    }


    public function getError()
    {
        if($this->json){
            die(json_encode(['status'=>false, 'content'=>self::$message_]));
        }
       die(require_once "view/index.html");
    }

    public function actionIndex()
    {
        echo "dssdfsdfsdf";
    }


    public static function getInstance(\Exception $e = NULL, $json = false)
    {
        if (!(self::$_instance instanceof self)) {
            $e!==NULL ? FALSE : $e = new \Exception(self::$message_);
            self::$_instance = new self($e, $json);
        }
        return self::$_instance;
    }
}