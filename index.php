<?php

/**
 * Bootstrap File
 * @author LUCHOWEB
 */

spl_autoload_register(function($class){
    $pathFile = str_replace("\\", "/", $class) . ".php";

    if ( is_readable($pathFile) ){
        require_once $pathFile;
    } else {
        print "Ha ocurrido un error.";
    }
});

require_once "config.php";
require_once "routes.php";
