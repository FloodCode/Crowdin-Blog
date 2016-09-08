<?php

class Controller {

    public $model;
    public $view;

    function __construct()
    {
        $this->view = new View();
    }

    // Action by default
    function action_index()
    {

    }
}
