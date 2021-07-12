<?php
namespace App\Config;

class View {

    public $view;

    function __construct($view)
    {
        $this->view = $view;
    }

    public function getView() {
        return $this->view.'.php';
    }
}