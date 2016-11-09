<?php

// Define this directory as a source of classes
define('CLASS_DIR', __DIR__);

// Add your class dir to include path
set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);

// Use default autoload implementation (written in C, so faster than PHP implementations
spl_autoload_register();
    
spl_autoload_register(function ($class_name) {
    //echo 'loading class '.$class_name . '\n';
    $path = explode('\\', $class_name);
    foreach($path AS $idx => $dirname){
        if($idx != count($path) - 1){
            $path[$idx] = strtolower($dirname); //lower all directory names
        }
    }
    $class_path = __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path) . '.php';
    //echo  $class_name .  'being autoloaded with path ' . $class_path .'\n';
    if( file_exists($class_path) ){
        //only include if the file exists to avoid warnings
        require_once $class_path ;
    }
});