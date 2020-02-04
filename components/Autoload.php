<?php

function autoload($class){

    $dir = [
        '/components/',
        '/controllers/',
        '/models/'
    ];


    foreach($dir as $name){

        $path = ROOT . $name . $class . '.php';

        if(is_file($path)){
            include_once($path);
        }
    }
}

spl_autoload_register('autoload');