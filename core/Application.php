<?php

namespace contact\core;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

 class Application{

     public static $config;

     function __construct()
     {
     }

     public static function setConfig($config){
       self::$config = $config;
     }

     public static function getConfig(){
         return self::$config;
     }
 }