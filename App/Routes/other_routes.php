<?php

use App\Config\Router;
use App\Controllers\AuthController;
use App\Controllers\SecondController;

// GET routes
Router::get("/DG", function() {
    send("Durim Gashi");
});