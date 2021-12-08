<?php


namespace App\Controllers;


use App\Models\AuthModel;
use App\Utils\Response;
use App\Utils\View;
use Firebase\JWT\JWT;

class AuthController extends Controller {
    function __construct() {

    }

    public function getUser($Data) {
        echo "Given user id:: " . $Data->userID;
    }

    public function register() {
        send($_POST);
    }

    public function registerView() {
        $view = new View();
        $view->setView('auth/register')
            ->setFileExt('php')
            ->setVariable('name', 'Durim')
            ->setVariable('surname', 'Gashi')
            ->setVariable('age', 24)
            ->setVariable('frontend', ['HTML', 'CSS', 'JavaScript'])
            ->setVariable('backend', ['back' => ['PHP', 'NODEJS'], 'database' => ['MySQL', 'NoSQL']])
            ->setVariables([
                'university' => 'FIEK',
                'work' => 'NOEXIS',
                'experience' => [
                    'UCX',
                    'KIT'
                ]
            ])
            ->setDefaultLayout('default.php')
            ->render();
    }

    public function login() {
        $userData = json_decode(json_encode($_POST));
        $key = "Kosova123++";

        $payload = array(
            "iat" => time(),
            "exp" => time() + 3600,
            "data" => [
                "username" => $userData ->username,
                "password" => $userData ->password
            ]
        );
        $token = JWT::encode($payload, $key, 'HS256');
        send([
            "token" => $token,
            "data" => $userData
        ]);
    }

    public function profile() {
        $user = authenticate();

        (new Response($user->data))->send();
    }
}