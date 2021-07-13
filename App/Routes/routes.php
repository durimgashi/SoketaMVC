<?php

use App\Config\Router;
use App\Controllers\SecondController;

//use App\Controllers\SecondController;

// GET routes
Router::get("/", function($data) {
    render('auth/login');
});

Router::get("/Test/:param1/:param2", function($data) {
    // sendData([
    //     "message" => "Hello from route '/Test' of type GET",
    //     "Data" => $data
    // ]);
    sendData($_GET);
});

Router::get("/Second", [SecondController::class, 'secondFunctionaaa']);

// POST routes

Router::post("/Test", function() {
    echo "Hello from test POST";
});

