<?php

namespace App\Controllers;

class SecondController {

    function __construct() {
        echo "Init SecondController";
    }

    public static function statik() {
        echo "Static method from SecondController";
    }

    public function secondFunction($data) {
        sendData("DADAA" .$data);
    }
}