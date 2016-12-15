<?php

namespace contact\controllers;

use contact\core\Application;
use contact\core\Router;


define("PROJECT_ACCESS", true);

require_once("configs/config.php");
require_once("core/autoloader.php");

Application::setConfig($config);
new Router();

?>
