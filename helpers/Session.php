<?php
namespace contact\helpers;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class Session{

    public static function init(){
        session_start();
    }
    public static function destroy(){
        session_unset();
        session_destroy();
        $_SESSION = array();
    }
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }
    public static function get($key){
        return $_SESSION[$key];
    }
}