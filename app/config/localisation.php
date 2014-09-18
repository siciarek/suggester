<?php

$di->setShared('locale', function () use ($di) {
    return $di->get('session')->get('locale', $di->getConfig()->application->locale);
});

$di->setShared('trans', function () use ($di) {

    $messages = array();

    $language = $di->get('locale');
    $basedir = $di->getConfig()->dirs->translations;

    if (file_exists($basedir . '/' . $language . '.php')) {
        require $basedir .  '/' . $language . '.php';
    } else {
        require $basedir . '/en.php';
    }

    //Return a translation object
    return new \Phalcon\Translate\Adapter\NativeArray(array(
        'content' => $messages
    ));
});