<?php

class Route
{
    static function start()
    {
        session_start();

        // Set controller and action to default values
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // Getting controller name
        if (!empty($routes[1]))
        {
            $controller_name = $routes[1];
        }

        // Getting action name
        if (!empty($routes[2]))
        {
            $action_name = $routes[2];
        }

        // Adding prefixes to
        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        // Include model class file if it exist
        $model_file = strtolower($model_name) . '.php';
        $model_path = "application/models/" . $model_file;
        if(file_exists($model_path))
        {
            include "application/models/" . $model_file;
        }

        // Include controller class file if it exist
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = "application/controllers/" . $controller_file;
        if(file_exists($controller_path))
        {
            include "application/controllers/" . $controller_file;
        }
        else
        {
            // Throw 404 page if controller is not exist
            Route::errorPage404();
        }

        // Declare controller
        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            // Call controller's method by action
            $controller->$action();
        }
        else
        {
            // Throw 404 page if controller's method is not exist
            Route::errorPage404();
        }
    }

    // Redirect user to 404 error page
    function errorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
        die;
    }

    // Retuns 'true' if user is authorized and 'false' otherwise
    function checkAuth()
    {
        if (!isset($_SESSION['is_admin']))
        {
            return false;
        }
        else if ($_SESSION['is_admin'] !== true)
        {
            return false;
        }
        return true;
    }

    // Redirect unauthorized users to 404 error page
    function authRequired()
    {
        if (!Route::checkAuth())
        {
            Route::errorPage404();
        }
    }
}
