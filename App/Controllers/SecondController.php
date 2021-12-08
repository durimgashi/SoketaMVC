<?php

namespace App\Controllers;

class SecondController extends Controller {

    function __construct() {
//        echo "Init SecondController";
    }

    public function dataObjectFromController($data) {
        send(["data" => $data]);
    }

    public function getObjectProperty($data) {
        send(["name" => $data->name]);
    }
}