<?php

namespace contact\core;

use contact\helpers\Session;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

abstract class Controller
{
    protected $view;
    protected $model;

    function __construct()
    {
        Session::init();
    }


}

?>