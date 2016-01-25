<?php
/**
 * Created by PhpStorm.
 * User: Prog1
 * Date: 21.01.2016
 * Time: 16:13
 */

namespace Asmoria\Modules\Socket;
@set_time_limit(0);
use Asmoria\Core\Controller;
use Asmoria\Core\View;
use Asmoria\Modules\Socket\Server;

class SocketController extends Controller
{

    public $config;

    public function __construct()
    {
        parent::__construct();
        $this->config = array(
            'host' => 'asmoria.dev',
            'port' => 10001,
            'workers' => 1,
        );
        $this->view = new View();
        $this->view->title = "Socket";
    }

    public function actionServer()
    {
        $Server = new Server($this->config);
        $Server->start();
    }

    public function actionTest()
    {
        if(extension_loaded('sockets')) echo "WebSockets OK";
        else echo "WebSockets UNAVAILABLE";
    }
    public function actionClient()
    {
        $this->view->render('client');
    }
}