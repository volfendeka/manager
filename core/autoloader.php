<?php
spl_autoload_register('loadClass');

function loadClass($class){

    $namespace = explode("\\", $class);
    if(is_array($namespace)){
        array_shift($namespace);
        $classRoute = implode("/", $namespace).".php";
    }
    if(file_exists($classRoute)){
        require_once $classRoute;
    }

}
?>