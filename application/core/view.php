<?php

class View
{
    public $title;
    
    public function __construct($title = 'Page')
    {
        $this->title = $title;
    }
    
    function generate($content_view, $template_view, $data = null)
    {
        $view = $this;
        include 'application/templates/'.$template_view;
    }
}
