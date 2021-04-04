<?php
session_start();

error_reporting(E_ALL); 
//error_reporting(1);
ini_set('display_errors', 1);

/**
 * cargar el autoload para librerias en vendor
 */

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/pan/kore/Autoloader.php';

$app = require_once __DIR__.'/pan/bootstrap/app.php';
require 'app/app_database_const.php';
require 'app/app_system_const.php';

$app->init();