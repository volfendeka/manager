<?php

$config =array();
$config['db']['connect'] = true;
$config['db']['host'] = "localhost";
$config['db']['user'] = "root";
$config['db']['password'] = "1515";
$config['db']['name'] = "manager";
$config['db']['type'] = "mysql";

//$config['load']['helpers'] = array('QueryBuilder', 'Session', 'Cookies');


define(SORT_TABLE_LAST, 'last_name');
define(SORT_TABLE_FIRST, 'first_name');
define(SORTING_PARAM_LAST, 'ASC');
define(SORTING_PARAM_FIRST, 'ASC');
define(PER_PAGE, 5);
define(URL,  "http://manager.loc/");

error_reporting(E_ALL); // Sets which PHP errors are reported
ini_set('display_errors', 1);// Sets the value of a configuration option

//phpinfo();
//echo get_include_path();
//echo "<pre>";
//print_r(get_declared_classes());
?>
