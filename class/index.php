<?php

if (!defined('_DIR_CLASS_')) {
    define('_DIR_CLASS_', 'utem');
}

if (function_exists('loadClass') == false) {

    function loadClass($class) {
        $arc = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . _DIR_CLASS_ . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, strtolower($class)) . '.php';
        if (is_readable($arc)) {
            include_once $arc;
        }
    }

    spl_autoload_register('loadClass');
}

if (function_exists('loadExceptions') == false) {

    function loadExceptions($class) {
        $arc = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . _DIR_CLASS_ . DIRECTORY_SEPARATOR . (implode(DIRECTORY_SEPARATOR, array_slice(explode("\\", $class), 0, -1))) . '.php';
        if (is_readable($arc)) {
            include_once $arc;
        }
    }

    spl_autoload_register('loadExceptions');
}
