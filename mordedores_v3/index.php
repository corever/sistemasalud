<?php

set_include_path(
        '.' . PATH_SEPARATOR . realpath(dirname(__FILE__)) . '/app/libs'
        . PATH_SEPARATOR . get_include_path()
);
require 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();

//session_start();
Zend_Session::start();

define('DS', "/");
define('ROOT', realpath(dirname(__FILE__)) . DS);

define('APP_PATH', ROOT . 'app' . DS);
define('SYS_PATH', ROOT . 'sys' . DS);
define('BASE_DIR', __DIR__);

require_once SYS_PATH . 'Config.php';
require_once SYS_PATH . 'SeterPHP.php';
require_once SYS_PATH . 'Error.php';
require_once SYS_PATH . 'Bootstrap.php';
require_once SYS_PATH . 'Request.php';
require_once SYS_PATH . 'Loader.php';
require_once SYS_PATH . 'Controller.php';
require_once SYS_PATH . 'Model.php';
//require_once SYS_PATH . 'View.php';
require_once SYS_PATH . 'Database.php';
require_once APP_PATH . 'libs/FirePHPCore/fb.php';
require_once APP_PATH . 'libs/getData.php';
require_once APP_PATH . 'libs/encriptar.php';
require_once APP_PATH . 'libs/gPoint.php';
if (phpversion() < 5) {
    die("Su versión de PHP no esta actualizada. Debe ser php5 o superior");
}

try {
    Bootstrap::run(new Request);
} catch (Exception $e) {
    if (defined("ERROR_LOG_FILE")) {
        Error::errorLog($e->getMessage(), Error::SYSTEM_ERROR);
    } else {
        error_log($e->getMessage());
    }
    echo $e->getMessage();
}