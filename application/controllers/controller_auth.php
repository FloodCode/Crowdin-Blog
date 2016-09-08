<?php

class Controller_Auth extends Controller
{

    function action_index()
    {
        Route::errorPage404();
    }

    function action_login()
    {
        if (isset($_POST['email']) && isset($_POST['password']))
        {
            $pwd = hash('sha256', $GLOBALS['SALT'] . $_POST['password']);
            $stmt = $GLOBALS['DB']->prepare('SELECT * FROM admins WHERE email = :email AND password = :password');
            $stmt->execute(array(':email' => $_POST['email'], ':password' => $pwd));
            $temp = $stmt->fetchAll();
            if (count($temp) > 0)
            {
                $_SESSION['is_admin'] = true;
            }
            else
            {
                session_destroy();
                header('Location:/message/index/?type=2&code=3');
            }
        }

        if (Route::checkAuth())
        {
            header('Location:/');
        }

        $this->view->title = 'Log in';
        $this->view->generate('auth_view.php', 'template_view.php');
    }

    function action_logout()
    {
        session_destroy();
        header('Location:/');
    }

}
