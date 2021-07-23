<?php
 include_once '../App/autoload.php'; 
 
include_once '../App/Config/regex.php';
include_once '../App/Utils/functions.php';
include_once '../App/Routes/routes.php';
include_once '../App/Config/core.php';

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$route = explode("Public/",$url)[1];

App\Config\Router::execute($route);

