<?php

$di->setShared('locale', function () use ($di) {
    $locale = $di->getConfig()->application->locale;

    if($di->getCookies()->has('SUGGESTER_LOCALE')) {
        $locale = trim($di->getCookies()->get('SUGGESTER_LOCALE'));
        $di->getSession()->set('locale', $locale);
    }

    return $di->get('session')->get('locale');
});

$di->setShared('trans', function () use ($di) {

    $messages = array();

    $locale = $di->get('locale');
    $basedir = $di->getConfig()->dirs->translations;

    require file_exists($basedir . DIRECTORY_SEPARATOR . $locale  . '.php')
        ? $basedir . DIRECTORY_SEPARATOR . $locale  . '.php'
        : $basedir . '/en.php';

    $options = [ 'content' => $messages ];

    //Return a translation object
    return $di->getConfig()->application->env === 'dev'
        ? new \Application\Common\Translate\Adapter\NativeArray($options)
        : new \Phalcon\Translate\Adapter\NativeArray($options);
});