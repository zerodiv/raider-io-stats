<?php

function simpleAutoloader($class) {
    // convert the namespaced file into a directory path safe file.
    $fileName = 
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 
        str_replace("\\", DIRECTORY_SEPARATOR,  $class) . 
        '.php';
    // var_dump($fileName);
    require_once $fileName;    
}

spl_autoload_register('simpleAutoloader');

use RaiderIO\TmpDir;

TmpDir::set(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'tmp');
