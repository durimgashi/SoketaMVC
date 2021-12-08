<?php

namespace App\Config;

use App\Controllers\Controller;
use Exception;

class Router extends Controller {

    private static array $all_middleware = [];

    public static function use(...$middleware) {
        foreach ($middleware AS $mid) {
            static::$all_middleware[] = $mid;
        }
    }

    public static function get($route, $Callback = null, ...$middleware) {
        $m = array();
        foreach ($middleware AS $mid) {
            $m[] = $mid;
        }

        self::createRoute('GET', $route, $Callback, $m);
    }

    public static function post($route, $Callback = null, ...$middleware) {
        $m = array();
        foreach ($middleware AS $mid) {
            $m[] = $mid;
        }
        self::createRoute('POST', $route, $Callback, $m);
    }

    public static function delete($route, $Callback = null, ...$middleware) {
        $m = array();
        foreach ($middleware AS $mid) {
            $m[] = $mid;
        }
        self::createRoute('DELETE', $route, $Callback, $m);
    }

    public static function put($route, $Callback = null, ...$middleware) {
        $m = array();
        foreach ($middleware AS $mid) {
            $m[] = $mid;
        }
        self::createRoute('PUT', $route, $Callback, $m);
    }

    public static function patch($route, $Callback = null, ...$middleware) {
        $m = array();
        foreach ($middleware AS $mid) {
            $m[] = $mid;
        }
        self::createRoute('PATCH', $route, $Callback, $m);
    }

    public static function createRoute($method, $route, $Callback, $middleware = []) {
        if(!preg_match(ROUTE_REGEX, $route)) {
            send([
                "error_message" => "Route should be of format: /BaseRoute/:var1/:var2 ... ",
                "route" => $route,
                "method" => $method
            ]);
        }

        $route_arr = explode('/:', $route);

        $baseRoute = trim(array_slice($route_arr, 0 , 1)[0]);
        $params = array_slice($route_arr, 1, count($route_arr));

        if(sizeof(static::$all_middleware) > 0) {
            foreach (static::$all_middleware AS $m) {
                $middleware[] = $m;
            }
        }

        $GLOBALS[$method][$baseRoute] = [
            'BaseRoute' => $baseRoute,
            'Parameters' => $params,
            'Method' => $method,
            'Callback' => $Callback,
            'Middleware' => $middleware
        ];
    } 

    public static function execute($route) {
        $Method = $_SERVER['REQUEST_METHOD'];

        $expUrl = explode("/", trim($route));
        $baseRoute = array_slice($expUrl, 0 , 1);
        $baseRoute = '/'.$baseRoute[0];

        $params = array_slice($expUrl, 1, count($expUrl));

        if(empty($GLOBALS[$Method][$baseRoute])) { 
            abort(404);
        }

        $route = $GLOBALS[$Method][$baseRoute];

        // Check if the correct number of parameters is set
        if(count($route['Parameters']) != count($params)) {
            send(['error' => 'Incorrect number of required parameters'], 400);
        }

        self::validateCallback($route, $params);
    }

    private static function validateCallback($route, $params) {
        try {

            foreach ($route['Middleware'] AS $mid) {
                call_user_func($mid);
            }

            if(gettype($route['Callback']) == 'object') {
                $Data = self::parseData($route, $params);
                call_user_func($route['Callback'], $Data);
            } else if(gettype($route['Callback']) == 'array') {
                $controller =  $route['Callback'][0];
                $controllerMethod = $route['Callback'][1];
    
                $controller = new $controller();

                if(!method_exists($controller, $controllerMethod)) {
                    send(['error' => 'Method ' . $controllerMethod . ' does not exist inside class ' . $route['Callback'][0] . '!']);
                }
                $Data = self::parseData($route, $params);
                call_user_func(array($controller, $controllerMethod), $Data);
            } else {
                send(['error' => 'Unknown callback type declared for route '.$route['BaseRoute'].' of type '. $route['Method']], 404);
            }
        } catch(Exception $e) {
            send($e);
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