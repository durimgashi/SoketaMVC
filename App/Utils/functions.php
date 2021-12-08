<?php

use App\Utils\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function setJSONHeaders() {
    header('Content-Type: application/json');
}

function send($data, $code = 200) {
    http_response_code($code);
    setJSONHeaders();
    echo json_encode($data);
    die();
}

// Not tested
function isJson($string): bool {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

function vd($data) {
    var_dump($data);
}

function render($file, $default = true, $variables = []) {
    $filename = __DIR__.'../../Views/'.$file.'.php';

    if(!file_exists($filename)) {
        send(['error' => 'File '.$file.' does not exist!']);
    }

    $default_layout = \App\Controllers\Controller::$layout;
    if($default_layout == null AND !$default) {
        include_once $filename;
    } else {
        if(!file_exists(__DIR__.'../../Views/'.$default_layout.'.php')) {
            send(['error' => 'File '.$default_layout.'.php does not exist!']);
        }
        $layout = $filename;
        include_once __DIR__.'../../Views/'.$default_layout.'.php';
    }
}

function abort($code) {
    $filename = __DIR__.'../../Views/errors/'.$code.'.php';

    if(!file_exists($filename)) {
        send(['error' => 'File '.$code.'.php does not exist!']);
    }

    http_response_code($code);
    include_once $filename;
    die(); 
}

// It can be improved, too simple
function route($endpoint): string {
    return ltrim($endpoint, '/');
}

function getAuthorizationHeader(): ?string {
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
         if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

function getBearerToken() {
    $headers = getAuthorizationHeader();
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function authenticate() {
    try {
        return JWT::decode(
            getBearerToken(),
            new Key('Kosova123++', 'HS256')
        );
    } catch (Exception $e) {
        $response = new Response();

        $response->setStatusCode(401)->setContent([
            'error' => true,
            'message' => $e->getMessage()
        ])->send();
    }
}