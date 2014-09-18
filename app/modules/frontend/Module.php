<?php

namespace Application\Frontend;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface {
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders($di) {

    }

    /**
     * Register specific services for the module
     */
    public function registerServices($di) {
        $view = $di->getView();

        $di->setShared('view', function () use ($view) {
            $view->setViewsDir(dirname(__FILE__) . '/views/');
            return $view;
        });

        $di->set('dispatcher', function () use ($di) {
            return $di->get('common_dispatcher');
        });
    }
}
