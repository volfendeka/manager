<?php
namespace contact\helpers;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class Cookies{

 public static function destroy($cookie){
  setcookie($cookie, "", time()-3600, "/");
 }
 public static function set($cookie, $data){
  setcookie($cookie, serialize($data), time()+3600, "/");
 }
 public static function get($cookie){
  return unserialize($_COOKIE[$cookie]);
 }
}