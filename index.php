<?php

/**
 * Bootstrap File
 * @author LUCHOWEB
 */

ini_set("session.cookie_lifetime","86400");
ini_set("session.gc_maxlifetime","86400");
session_start();

require_once "vendor/autoload.php";

function autoLoader ($class) {
    $classPath = str_replace("\\", "/", $class) .".php";

    if (file_exists($classPath)) {
        require_once $classPath;
    }
}

spl_autoload_register('autoLoader');

require_once "config.php";
require_once "routes.php";