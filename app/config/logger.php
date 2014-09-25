<?php

$di->setShared('logger', function() use ($di) {
    $logfile = $di->getConfig()->dirs->logs . DIRECTORY_SEPARATOR . sprintf('%s.%s.log', $di->getConfig()->application->shortname, date('Y-m-d'));

    $logger = new \Phalcon\Logger\Adapter\File($logfile);

    return $logger;
});