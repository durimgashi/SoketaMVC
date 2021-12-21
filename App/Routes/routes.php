<?php

use App\Config\Router;
use App\Controllers\AuthController;
use App\Controllers\CrawlerController;
use App\Controllers\SecondController;
use App\Controllers\TestController;
use App\Utils\View;


Router::get("/register", [AuthController::class, 'registerView']);
Router::post('/login', [AuthController::class, 'login']);
Router::get('/profile', [AuthController::class, 'profile']);

# =====================================================================Middleware=======================================================================================================================

/**
 * Middleware passed inside the use() function will apply to all routes declared below
 */

//Router::use('middleware2', function () {
//    echo "Middleware to be used for all routes below---1\n";
//});
//
//Router::use(function () {
//    echo "Middleware to be used for all routes below---2\n";
//
////    return ['userID' => 'Kosova123++'];
//});

# ======================================================================================================================================================================================================

//Router::get("/Test/:firstName/:lastName", [TestController::class, 'dummyCall']);
Router::get("/Test/:firstName/:lastName", function ($Data) {
    send($Data);
});

function middleware2() {
    echo "middleware 2!!!";
}


Router::get("/ObjectFromController/:name/:surname/:company", [SecondController::class, 'dataObjectFromController']);
Router::get("/GetObjectProperty/:name/:surname/:company", [SecondController::class, 'getObjectProperty']);
Router::post('/register', [AuthController::class, 'register']);
Router::get('/user/:userID', [AuthController::class, 'getUser']);

Router::get('/telegrafi', [CrawlerController::class, 'crawl']);
Router::get('/html', [CrawlerController::class, 'simpleHTMLDOM']);
Router::get('/standings', [CrawlerController::class, 'standings']);
Router::get('/xpath-standings', [CrawlerController::class, 'xpath_standings']);
Router::get('/homepage', [CrawlerController::class, 'homepage']);
Router::get('/results', [CrawlerController::class, 'results']);
Router::get('/worldometers', [CrawlerController::class, 'worldometers']);

Router::get('/durim', function ($Data) {

    // echo json_encode([
    //     'Data' => $Data,
    //     'Middleware' => $Middleware
    // ]);

     $view = new View();

     $view->setView('auth/home')->setFileExt('html')->setDefaultLayout('')->render();
});


Router::post('/validator', [TestController::class, 'validator']);