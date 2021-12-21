<?php

namespace App\Controllers; 

use App\Models\DurimModel;
use App\Utils\Response;
use App\Utils\Validator;

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

    public function validator() {
//        $data = json_decode(file_get_contents('php://input'));
        $data = $_POST;

        $val = new Validator();

        $val->name('email')->value($data['email'])->errorclass('email')->pattern('email')->required();
        $val->name('username')->value($data['username'])->errorclass('username')->required();
        $val->name('password')->value($data['password'])->errorclass('password')->min(8)->required();


        if (!$val->isSuccess()) {
            send($val->getErrors());
        }



        send($data);
    }
}