<?php


spl_autoload_register(function($className){
    $className = str_replace("\\", "/", $className);
    $classPath = __DIR__. "/../".$className. ".php";
    if(file_exists($classPath)){
        require $classPath;
    }
});

