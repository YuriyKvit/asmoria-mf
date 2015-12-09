<?php
use Asmoria\Modules\Profiler\CabinetController as Controller;
use Asmoria\Modules\Profiler\Models\ProfileModel as Model;

$view = Controller::getInstance();
$data = $view->getProfileInfo();

?>
<div class="container">
    <h2>Cabinet</h2>

    Your id: <?php echo $data->id?> <br>
    Your email: <?php echo $data->mail?><br>
    Your password: <?php echo $data->pass?><br>
    Is Admin: <?php echo $data->isAdmin ? "TRUE" : "FALSE"?><br>
   </div>