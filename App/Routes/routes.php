<?php

use App\Config\Router;
use App\Controllers\SecondController;

// GET routes
Router::get("/", function() {
    render('auth/login',  ['var1' => 'Durim Gashi', 'var2' => 'Luke Skywalker']);
});

Router::get("/Test/:firstName/:lastName", function($data) {
    // sendData([
    //     "message" => "Hello from route '/Test' of type GET",
    //     "Data" => $data
    // ]);
    sendData($data);
});

Router::get("/ObjectFromController/:name/:surname/:company", [SecondController::class, 'dataObjectFromController']);
Router::get("/GetObjectProperty/:name/:surname/:company", [SecondController::class, 'getObjectProperty']);
Router::get("/StaticMethod", [SecondController::class, 'staticMethod']);

// POST routes

Router::post("/Test", function() {
    echo "Hello from test POST";
});