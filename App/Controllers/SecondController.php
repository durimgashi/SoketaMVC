<?php

namespace App\Controllers;

class SecondController extends Controller{

    function __construct() {
        echo "Init SecondController";
    }

    public static function statik() {
        echo "Static method from SecondController";
    }

    public function secondFunction() {
        // render('home');
        
    //    route('/Test');
    }
}