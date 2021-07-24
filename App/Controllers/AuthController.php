<?php


namespace App\Controllers;


use App\Models\AuthModel;

class AuthController {
    function __construct() {

    }

    public function register() {

        AuthModel::getUser();
//        $Data = $_POST;
//
//        sendData($Data);
    }
}