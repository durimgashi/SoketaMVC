<?php

namespace App\Controllers; 

use App\Models\DurimModel;
use App\Utils\Response;

class TestController extends Controller {
    function __construct() { }

    public function index() { }

    public function dummyCall($data) {
        $response = new Response();

        $response->setContent($data)
            ->setStatusCode(201)
            ->header('Connection: Keep-Alive')
            ->header('Content-Type: application/json')
            ->setHeaders([
                'Origin: http://localhost/DurimMVC',
                'Content-Length: 100'
            ])
            ->json();
    }

    public function durim() {
        $response = new Response(DurimModel::test());

        $response->send();
    }
}