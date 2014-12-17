<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 6:52 PM
 */

function ygl_autoload($class) {
    if (preg_match('/^YGL\//', $class) !== FALSE) {
        $file = __DIR__.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, ltrim($class, 'YGL')).'.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

spl_autoload_register('ygl_autoload');