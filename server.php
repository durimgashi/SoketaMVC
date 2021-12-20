<?php

class Server {
    public function __construct() {

    }

    public static function getRoute(): string {
        return str_replace(self::getBaseUrl(), '' , self::remove_query_params(self::getCurrentURL()));
    }

    public static function getBaseUrl(): string {
        $currentPath = $_SERVER['PHP_SELF'];
        $pathInfo = pathinfo($currentPath);
        $hostName = $_SERVER['HTTP_HOST'];
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

        return $protocol.'://'.$hostName.$pathInfo['dirname']."/";
    }

    public static function getCurrentURL(): string {
        if ( (! empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') ||
            (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ||
            (! empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) {
            $server_request_scheme = 'https';
        } else {
            $server_request_scheme = 'http';
        }

        return $server_request_scheme . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    private static function remove_query_params( $src ): string {
        $parts = explode( '?', $src );
        return $parts[0];
    }
}

include __DIR__.'/public/index.php';