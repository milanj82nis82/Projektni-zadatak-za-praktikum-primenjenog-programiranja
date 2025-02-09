<?php
namespace Include;

spl_autoload_register(function($className) {

    $path = 'classes/';
    $extension = '.class.php';
    $fullPath = $className . $extension;
    require_once $fullPath;
    
    
});
