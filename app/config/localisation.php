<?php

$di->setShared('locale', function () use ($di) {
    $locale = $di->getConfig()->application->locale;

    $cookie = $di->getConfig()->session->name . '_LOCALE';

    if($di->getCookies()->has($cookie)) {
        $locale = trim($di->getCookies()->get($cookie));
    }
    else {
        $di->getCookies()->set($cookie, $locale);
    }

    $di->getSession()->set('locale', $locale);

    return $di->get('session')->get('locale');
});

$di->setShared('trans', function () use ($di) {

    $messages = array();

    $locale = $di->getLocale();
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