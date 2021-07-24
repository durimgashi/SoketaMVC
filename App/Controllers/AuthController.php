<?php


namespace App\Controllers;


class AuthController {
    function __construct() {

    }

    public function register() {

        $Data = $_POST;

        sendData($Data);
    }
}