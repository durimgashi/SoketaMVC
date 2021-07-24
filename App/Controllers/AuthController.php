<?php


namespace App\Controllers;


use App\Models\AuthModel;

class AuthController {
    function __construct() {

    }

    public function getUser($Data) {
        AuthModel::findUser($Data->userID);
    }

    public function register() {
        sendData($_POST);
    }
}