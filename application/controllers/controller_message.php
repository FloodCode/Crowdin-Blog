<?php

class Controller_Message extends Controller
{
    function __construct()
    {
        $this->model = new Model_Message();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->title = 'Message';
        $this->view->generate('message_view.php', 'template_view.php', $data);
    }
}
