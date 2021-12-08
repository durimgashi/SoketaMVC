<?php

include_once '../vendor/autoload.php';
include_once '../App/Config/regex.php';
include_once '../App/Utils/functions.php';
include_once '../App/Routes/routes.php';
include_once '../App/Routes/other_routes.php';
include_once '../App/Config/core.php';
include_once '../App/Database/db_connection.php';

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
//$route = explode("Public/",$url)[1];

$route = explode("/",$url);

unset($route[0]);
unset($route[1]);

$route = implode('/', $route);

App\Config\Router::execute($route);