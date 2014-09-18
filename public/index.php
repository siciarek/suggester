<?php

// Define path to application directory
defined('APPLICATION_DIR') || define('APPLICATION_DIR', 'app');
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../' . APPLICATION_DIR));

// Create service container
$di = new Phalcon\DI\FactoryDefault();
$application = new Phalcon\Mvc\Application();

require_once APPLICATION_PATH . '/autoload.php';


if($di->getConfig()->application->env === 'dev') {
    $debug = new Phalcon\Debug();
    $debug->listen();

    new \PDW\DebugWidget($di);

    echo $application->handle()->getContent();
}
elseif($di->getConfig()->application->env === 'test') {
    $debug = new \Phalcon\Debug();
    $debug->listen();

    echo $application->handle()->getContent();
}
else {
    try {
        echo $application->handle()->getContent();
    }
    catch(\Exception $e) {
        echo '<pre>';
        echo get_class($e), ": ", $e->getMessage(), "\n";
        echo " File=", $e->getFile(), "\n";
        echo " Line=", $e->getLine(), "\n";
        echo $e->getTraceAsString();
        echo '</pre>';
    }
}
