<?php
/**
 * @Author: Rostislav Kral(xkralr06)
 */

/*
 *
 * Used for class autoloading classes
 *
 * **/

spl_autoload_register(function ($class_name) {
    $parts = explode('\\', $class_name);
    include end($parts) . '.php';
});
