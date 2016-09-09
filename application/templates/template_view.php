<?php

require_once 'application/core/tools.php';
$module_name = Tools::getModuleName($content_view);

?>

<!DOCTYPE html>
<html lang="ru">
    <head>
<?php include 'template_head.php' ?>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Crowdin Blog</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" />
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li<?php if ($module_name == 'main') { echo ' class="active"'; } ?>>
                            <a href="/"><span class="glyphicon glyphicon-list"></span> Posts</a>
                        </li>
                        <li<?php if ($module_name == 'contact') { echo ' class="active"'; } ?>>
                            <a href="/contact/index/"><span class="glyphicon glyphicon-envelope"></span> Contacts</a>
                        </li>
                        <li<?php if ($module_name == 'about') { echo ' class="active"'; } ?>>
                            <a href="/about/index/"><span class="glyphicon glyphicon-info-sign"></span> About Us</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
<?php if (Route::checkAuth()): ?>
                        <li<?php if ($module_name == 'addpost') { echo ' class="active"'; } ?>>
                            <a href="/main/add/"><span class="glyphicon glyphicon-plus"></span> Add Post</a>
                        </li>
                        <li>
                            <a href="/auth/logout/"><span class="glyphicon glyphicon-log-out"></span> Log Out</a>
                        </li>
<?php else: ?>
                        <li<?php if ($module_name == 'auth') { echo ' class="active"'; } ?>>
                            <a href="/auth/login/"><span class="glyphicon glyphicon-log-in"></span> Log In</a>
                        </li>
<?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
<?php include 'application/views/'.$content_view; ?>
        <hr>
        <footer>
            <div class="container">
                <p>Crowdin &copy; <?php echo date("Y"); ?>. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>
