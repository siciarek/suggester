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
    catch(\Application\Common\Exceptions\NotFoundException $e) {
        header_status(404);
        readfile('404.html');
    }
    catch(\Exception $e) {
//        // TODO: log errors.
//        echo get_class($e), ": ", $e->getMessage(), "\n";
//        echo " File=", $e->getFile(), "\n";
//        echo " Line=", $e->getLine(), "\n";
//        echo $e->getTraceAsString();

        header_status(500);
        readfile('500.html');
    }
}

function header_status($statusCode) {
    static $status_codes = null;

    if ($status_codes === null) {
        $status_codes = array (
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        );
    }

    if ($status_codes[$statusCode] !== null) {
        $status_string = $statusCode . ' ' . $status_codes[$statusCode];
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
    }
}


