<?php

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
function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

function vd($data) {
    var_dump($data);
}

function render($file, $variables = []) {
    $filename = __DIR__.'../../Views/'.$file.'.php';

    if(!file_exists($filename)) {
        send(['error' => 'File '.$file.' does not exist!']);
    }

    $default_layout = \App\Controllers\Controller::$layout;
    if($default_layout == null) {
        include_once $filename;
    } else {
        if(!file_exists(__DIR__.'../../Views/'.$default_layout.'.php')) {
            send(['error' => 'File '.$default_layout.'.php does not exist!']);
        }
        $layout = $filename;
        include_once __DIR__.'../../Views/'.$default_layout.'.php';
    }
}

// It can be improved, too simple
function route($endpoint) { 
    return ltrim($endpoint, '/');
}