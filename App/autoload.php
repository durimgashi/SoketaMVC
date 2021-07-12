<?php 
 

spl_autoload_register(function ($class_name) {
//    $parts = explode('\\', $class_name);
//    array_shift($parts);
//    $parts = implode(DIRECTORY_SEPARATOR,$parts);
    $file =  '../'. $class_name . '.php';
//    die($file);
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
//    die($file);
    if (file_exists($file)) {
        include_once $file;
    }

}); 
