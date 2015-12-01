<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/Modules/profiler/CabinetController.php";
use Asmoria\Modules\Profiler\CabinetController as Controller;
use Asmoria\Modules\Profiler\Models\ProfileModel as Model;

$view = Controller::getInstance();
$profile = new Model();
var_dump($profile->id);exit;
$data = $view->getProfileInfo($_SESSION['u_id']);


?>
<div class="container">
    <h2>Cabinet</h2>

    Your id: <?php echo $data['id']?> <br>
    Your email: <?php echo $data['mail']?><br>
    Your password: <?php echo $data['pass']?><br>
    Is Admin: <?php echo $view->isAdmin ? "TRUE" : "FALSE"?><br>
   </div>