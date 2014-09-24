<?php

use \Phalcon\Mvc\Dispatcher;

$di->set('dispatcher', function () use ($di) {

        $eventsManager = $di->getShared('eventsManager');

        $eventsManager
            ->attach('dispatch:beforeExecuteRoute', new \Application\Common\Plugin\SecurePlugin());

        $eventsManager
            ->attach(
                'dispatch:beforeException',
                function ($event, \Phalcon\Mvc\Dispatcher $dispatcher, \Exception $exception) {

                    switch ($exception->getCode()) {
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(
                                array(
                                    'controller' => 'Application\Common\Controller\Error',
                                    'action' => 'notFound',
                                )
                            );
                            return false;
                            break;
                        default:
                            $dispatcher->forward(
                                array(
                                    'controller' => 'Application\Common\Controller\Error',
                                    'action' => 'uncaughtException',
                                )
                            );
                            return true;
                            break;
                    }
                }
            );

        $dispatcher = new Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    },
    true
);