<?php

namespace App\Config;

use Routes\routes; 

class Router { 
    public static function get($route, $Callback = null) {
        self::createRoute('GET', $route, $Callback); 
    }

    public static function post($route, $Callback = null) {
        self::createRoute('POST', $route, $Callback);
    }

    public static function createRoute($Method, $route, $Callback = null) {
        $route_arr = explode('/:', $route);

        $baseRoute = trim(array_slice($route_arr, 0 , 1)[0]);
        $params = array_slice($route_arr, 1, count($route_arr));

        $GLOBALS[$Method][$baseRoute] = [
            'BaseRoute' => $baseRoute,
            'Parameters' => $params,
            'Method' => $Method,
            'Callback' => $Callback
        ]; 
    }

    public static function execute($route) {
        $Method = $_SERVER['REQUEST_METHOD'];

        // Remove query parameters
        $expUrl = explode("?", trim($route));

        $expUrl = explode("/", trim($expUrl[0]));
        $baseRoute = array_slice($expUrl, 0 , 1);
        $baseRoute = '/'.$baseRoute[0];
        $params = array_slice($expUrl, 1, count($expUrl));

        if(empty($GLOBALS[$Method][$baseRoute])) {
            sendData(['error' => 'Route not found'], 404);
        }

        $route = $GLOBALS[$Method][$baseRoute];

        // Check if the correct number of parameters is set
        if(count($route['Parameters']) != count($params)) {
            sendData(['error' => 'Incorrect number of required parameters'], 400);
        }

        self::validateCallback($route, $params);
    }

    private static function validateCallback($route, $params) {
        if(gettype($route['Callback']) == 'object') {
            call_user_func($route['Callback'], $params);
        } else if(gettype($route['Callback']) == 'array') { 
            $controller =  '\App\Controllers\\'. $route['Callback'][0];
            $controllerMethod = $route['Callback'][1];

            $controller = new $controller();

            if(sizeof($params) == 0) {
                $controller->$controllerMethod();
            } else {
                $controller->$controllerMethod($params);
            }
        } else {
            sendData(['error' => 'Unknown callback type declared for route '.$route['BaseRoute'].' of type '. $route['Method']], 404);
        }
    }
}
