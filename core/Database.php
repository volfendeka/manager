<?php
namespace contact\core;

if(!defined("PROJECT_ACCESS"))exit("ACCESS DENIED");

class Database{

    private static $host;
    private static $user;
    private static $password;
    private static $name;
    private static $type;
    protected static $dbconnection;
    
    private function __construct()
    {
    }
    
    public static function setConfigs($config){
        self::$host = $config['db']['host'];
        self::$user = $config['db']['user'];
        self::$password = $config['db']['password'];
        self::$name = $config['db']['name'];
        self::$type = $config['db']['type'];
    }

    public static function initDatabase($config){
        self::setConfigs($config);
        if(!static::$dbconnection) {
            self::$dbconnection = new \PDO(self::$type . ":dbname=" . self::$name . ";host=" . self::$host, self::$user, self::$password);
        }
        return self::$dbconnection;
    }
}
?>
