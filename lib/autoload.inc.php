<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 1/30/16
 * Time: 10:06 AM
 */

spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/cls/' . str_replace("\\", "/", $class_name) . '.php';
    if(is_file($file)) {
        include $file;
    }
});
?>