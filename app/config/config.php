<?php

$di->setShared('config', function () {
    $config = new \Phalcon\Config\Adapter\Ini(APPLICATION_PATH . '/config/config.ini');
    foreach($config->dirs as $name => $value) {
        $config->dirs->$name = realpath(APPLICATION_PATH . $value);
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

$di->set('forms', function() {
    $forms = new Phalcon\Forms\Manager();

    $forms->set('user', new \Application\Backend\Form\UserForm(new \Application\Backend\Entity\User()));

    return $forms;
});