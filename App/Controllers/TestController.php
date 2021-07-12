<?php

namespace App\Controllers; 

class TestController {
    function __construct() {
        echo "Hello from test controller"; 
    }

    public function index() {
        // echo "<br>We are inside index fucntion!!!!";
    }

    public static function statik() {
        echo "This is a static function!!";
    }
}