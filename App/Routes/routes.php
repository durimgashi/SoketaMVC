<?php

use App\Config\Router;
//use App\Controllers\SecondController;

// GET routes
Router::get("/", function($data) {
    echo "It's coming home!";
});

Router::get("/Test/:param1/:param2", function($data) {
    // sendData([
    //     "message" => "Hello from route '/Test' of type GET",
    //     "Data" => $data
    // ]);
    sendData($_GET);
});

Router::get("/Second/:param1/:param2", [SecondController::class, 'secondFunction']);

// POST routes

Router::post("/Test", function() {
    echo "Hello from test POST";

});

