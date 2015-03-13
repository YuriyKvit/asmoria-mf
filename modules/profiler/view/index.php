<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/modules/profiler/profiler.php";
$view = Profiler::getInstance();
?>
<div class="container">
    <h2>Cabinet</h2>

    Your id: <?php echo $view->getProfileInfo(1)['id']?> <br>
    Your email: <?php echo $view->getProfileInfo(1)['mail']?><br>
    Your password: <?php echo $view->getProfileInfo(1)['pass']?><br>

</div>