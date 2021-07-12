<?php

// include_once __DIR__.'../../App/autoload.php';

class Dispacher {
 
    public static function dispach($route) {
        // var_dump($route);
        if($route != "") {
            $expUrl = explode("/", $route);

            $baseRoute = $expUrl[0];
    
            $params = explode('/', $route, 2);
            

            var_dump( $params);
        }
        
    }
}