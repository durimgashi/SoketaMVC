<?php

namespace App\Config;

use App\Controllers\Controller;
use App\Controllers\SecondController;
use Routes\routes;

class Router extends Controller {
    public static function get($route, $Callback = null) {
        self::createRoute('GET', $route, $Callback); 
    }

    public static function post($route, $Callback = null) {
        self::createRoute('POST', $route, $Callback);
    }

    public static function delete($route, $Callback = null) {
        self::createRoute('DELETE', $route, $Callback);
    }

    public static function put($route, $Callback = null) {
        self::createRoute('PUT', $route, $Callback);
    }

    public static function patch($route, $Callback = null) {
        self::createRoute('PATCH', $route, $Callback);
    }

    public static function createRoute($Method, $route, $Callback = null ) {

        if(!preg_match(ROUTE_REGEX, $route)) {
            sendData([
                "error_message" => "Route should be of format: /BaseRoute/:var1/:var2 ... ",
                "route" => $route,
                "method" => $Method
            ]);
        }

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

        $expUrl = explode("/", trim($route));
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
        try {
            if(gettype($route['Callback']) == 'object') {
                $Data = self::parseData($route, $params);
                call_user_func($route['Callback'], $Data);
            } else if(gettype($route['Callback']) == 'array') {
//                $controller =  '\App\Controllers\\'. $route['Callback'][0];
                $controller =  $route['Callback'][0];
                $controllerMethod = $route['Callback'][1];
    
                $controller = new $controller();

                if(!method_exists($controller, $controllerMethod)) {
                    sendData(['error' => 'Method ' . $controllerMethod . ' does not exist inside class ' . $route['Callback'][0] . '!']);
                }
                $Data = self::parseData($route, $params);
                call_user_func(array($controller, $controllerMethod), $Data);
            } else {
                sendData(['error' => 'Unknown callback type declared for route '.$route['BaseRoute'].' of type '. $route['Method']], 404);
            }
        } catch(Exception $e) {
            sendData($e);
        }
    }

    private static function parseData($route, $params) {
        if(sizeof($params) == 0) {
            return [];
        } else {
            $Data = new \stdClass();
            $route_parameters = $route['Parameters'];

            for ($i = 0; $i < count($route_parameters); $i++) {
                $new_property = $route_parameters[$i];
                $Data->$new_property = $params[$i];
            }

            return $Data;
        }
    }
}
