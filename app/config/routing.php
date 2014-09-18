<?php

$di->set('url', function () {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri('/');
    return $url;
});

$di->setShared('router', function () use ($di) {
    $router = new \Phalcon\Mvc\Router\Annotations(false);

    $router->setDefaultModule('frontend');
    $router->setDefaultController('Application\Frontend\Controllers\Default');
    $router->setDefaultAction('home');

    $resources = array(
        'frontend' => array(
            'Application\Frontend\Controller\Default',
        ),
    );

    foreach ($resources as $module => $controllers) {
        foreach($controllers as $controller) {
            $router->addModuleResource($module, $controller);
        }
    }

    if ($di instanceof \Phalcon\DI\FactoryDefault\CLI) {
        $router = new \Phalcon\Cli\Router();
    }

    return $router;
});
