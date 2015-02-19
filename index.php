<?php

require_once('./conf/conf.php');
define('ROOT', dirname(__FILE__));
?>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><b>Asmoria</b></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse auth">
            <div class="navbar-right logout-wrap"></div>
            <?php if(!USER_ID){?>
            <form class="navbar-form navbar-right auth_form" target="_self" name="auth_main" method="post"
                  action="modules/profiler/auth" enctype="multipart/form-data" onsubmit="ajaxSubmit_c('auth')">
                <div class="form-group">
                    <input type="text" name="a_email" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="a_pass" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#asmo-register">
                    Registration
                </button>
            </form>
            <?php }
            else{
            ?>
                <div class="navbar-right"><a class="btn btn-primary logout" href="modules/profiler/logout">Logout</a>
                <a href="modules/profiler/cabinet" class="btn btn-success logout"> Cabinet</a>



                </div>





            <?php }?>
        </div>
        <!--/.navbar-collapse -->
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>Hello, world!</h1>

        <p>This is a template for a simple marketing or informational website. It includes a large callout called a
            jumbotron and three supporting pieces of content. Use it as a starting point to create something more
            unique.</p>

        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Heading</h2>

            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris
                condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis
                euismod. Donec sed odio dui. </p>

            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>Heading</h2>

            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris
                condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis
                euismod. Donec sed odio dui. </p>

            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>Heading</h2>

            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula
                porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
                fermentum massa justo sit amet risus.</p>

            <p>
                <button type="button" class="btn btn-default">View details &raquo;</button>
            </p>
        </div>
    </div>

    <hr>

    <footer>
        <p>&copy; Asmoria corp 2014</p>
    </footer>
</div>
<!-- /container -->
<!-- Modal registration step 1 -->
<div class="modal fade" id="asmo-register" tabindex="-1" role="dialog" aria-labelledby="asmo-register"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registration form</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="register_main" enctype="multipart/form-data" id="register_main"
                      action="" method="post" onsubmit="ajaxSubmit_c('register')">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-9">
                            <input type="email" name="mail" class="form-control" id="inputEmail3" placeholder="Email"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" name="pass" class="form-control" id="inputPassword3"
                                   placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputConfPassword3" class="col-sm-3 control-label">Confirm password</label>

                        <div class="col-sm-9">
                            <input type="password" name="conf_pass" class="form-control" id="inputConfPassword3"
                                   placeholder="Confirm password" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" id="success" class="btn btn-primary" form="register_main" value="Register">
            </div>
        </div>
    </div>
</div>

</body>
</html>