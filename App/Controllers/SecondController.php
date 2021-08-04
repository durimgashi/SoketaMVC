<?php

namespace App\Controllers;

class SecondController extends Controller{

    function __construct() {
//        echo "Init SecondController";
    }

    public static function staticMethod() {
        echo "\nStatic method from SecondController";
    }

    public function dataObjectFromController($data) {
        send(["Data from controller" => $data]);
    }
    public function getObjectProperty($Data) {
        send(["Data property" => $Data->name]);
    }
}