<?php

use App\Config\Router;
use App\Controllers\AuthController;
use App\Controllers\SecondController;

// GET routes
Router::get("/", function() {
    render('auth/login',  ['var1' => 'Durim Gashi', 'var2' => 'Luke Skywalker']);
});

Router::get("/Test/:firstName/:lastName", function($data) {
    sendData($data);
});

Router::get("/ObjectFromController/:name/:surname/:company", [SecondController::class, 'dataObjectFromController']);
Router::get("/GetObjectProperty/:name/:surname/:company", [SecondController::class, 'getObjectProperty']);
Router::get("/StaticMethod", [SecondController::class, 'staticMethod']);

// POST routes

Router::post("/Test", function() {
    echo "Hello from test POST";
});

Router::get('/register', function() {
    render('auth/register');
});

Router::post('/register', [AuthController::class, 'register']);
Router::get('/user/:userID', [AuthController::class, 'getUser']);