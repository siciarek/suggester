<?php

$di->set('common_dispatcher', function() use ($di) {
    $eventsManager = new Phalcon\Events\Manager();
//    $eventsManager->attach('dispatch', new \Application\Common\Plugin\SecurePlugin());
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);


    return $dispatcher;
});

