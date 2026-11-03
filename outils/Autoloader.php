<?php

namespace touiteur\outils;

class Autoloader {

    public static function register() {
        spl_autoload_register([__CLASS__, 'loadClass']);
    }

    public static function loadClass(string $classname) {

        $path = str_replace('\\', '/', $classname); // on remplace les \ par des /

        $path = str_replace('touiteur/', '', $path);
        $filename = __DIR__ . '/../' . $path . '.php';

        if (is_file($filename)) {
            require_once $filename;
        }
    }
}