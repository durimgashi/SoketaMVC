<?php

include_once __DIR__.'\..\vendor\autoload.php';
include_once __DIR__.'\..\App\Config\regex.php';
include_once __DIR__.'\..\App\Utils\functions.php';
include_once __DIR__.'\..\App\Routes\routes.php';
include_once __DIR__.'\..\App\Routes\other_routes.php';
include_once __DIR__.'\..\App\Config\core.php';
include_once __DIR__.'\..\App\Database\db_connection.php';

//echo Server::getBaseUrl()."\n";
//echo Server::getCurrentURL()."\n";
//echo Server::getRoute()."\n";

App\Config\Router::execute(Server::getRoute());
