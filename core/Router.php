<?php

namespace contact\core;


use contact\helpers\InputClear;

class Router extends InputClear{

    function __construct()
    {
        $this->loadController($this->getSegments());
    }
        
    public function getSegments(){
        $segments = $this->clearGet($_SERVER['REQUEST_URI']);
        $segments = explode("/",  $segments);
        return $segments;
    }


    public function loadController($controllerData){
        $controllerName = !empty($controllerData[0])?$controllerData[0]."Controller":DEFAULT_CONTROLLER;
        $controllerTitle  = "contact\\controllers\\".$controllerName;
        $controllerMethod = isset($controllerData[1])?$controllerData[1]:DEFAULT_METHOD;
        unset ($controllerData[0]);
        unset ($controllerData[1]);

        $params = array_values($controllerData);
        if (class_exists($controllerTitle) && method_exists($controllerTitle, $controllerMethod)){
            $customController = new $controllerTitle();
            call_user_func_array(array($customController, $controllerMethod), $params);
            return true;
        }
        return false;
    }
}


?>