<?php

$di->setShared('config', function () {
    $config = new \Phalcon\Config\Adapter\Ini(APPLICATION_PATH . '/config/config.ini');
    foreach($config->dirs as $name => $value) {
        $dir = APPLICATION_PATH . $value;

        if (!is_dir($dir)) {
            $umask = umask(0000);
            mkdir($dir, 0777, true);
            umask($umask);
        }

        $config->dirs->$name = realpath($dir);
    }
    return $config;
});

$di->setShared('crypt', function() use ($di) {
    $crypt = new Phalcon\Crypt();
    $crypt->setKey($di->getConfig()->application->secret); //Use your own key!
    return $crypt;
});

$di->setShared('cookies', function() {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;
});
