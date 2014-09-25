<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

// Define path to application directory
defined('APPLICATION_DIR') || define('APPLICATION_DIR', 'app');
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../' . APPLICATION_DIR));

use Phalcon\DI;

// Create service container
$di = new \Phalcon\DI\FactoryDefault();
$application = new \Phalcon\Mvc\Application();

DI::reset();

require_once APPLICATION_PATH . '/autoload.php';

DI::setDefault($di);