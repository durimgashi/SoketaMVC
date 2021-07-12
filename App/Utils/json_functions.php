<?php

function setJSONHeaders() {
    header('Content-Type: application/json');
}

function sendData($data, $code = 200) {
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
    die();
}