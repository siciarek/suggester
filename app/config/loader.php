<?php
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
        $di->getConfig()->dirs->libs,
        $di->getConfig()->dirs->tasks,

        $di->getConfig()->dirs->modules . '/frontend/controllers',
        $di->getConfig()->dirs->modules . '/frontend/entities',
        $di->getConfig()->dirs->modules . '/frontend/forms',
        $di->getConfig()->dirs->modules . '/common/controllers',
    )
);

$loader->registerNamespaces(
    array(
        'Application\Frontend\Controller' => $di->getConfig()->dirs->modules . '/frontend/controllers/',
        'Application\Frontend\Entity' => $di->getConfig()->dirs->modules . '/frontend/models/entities',
        'Application\Frontend\Form' => $di->getConfig()->dirs->modules . '/frontend/models/forms',

        'Application\Common\Controller' => $di->getConfig()->dirs->modules . '/common/controllers/',
        'Application\Common' => $di->getConfig()->dirs->modules . '/common/models',
    )
);

$loader->register();

$application->setDi($di);

$application->registerModules(
    array(
        'frontend' => array(
            'className' => 'Application\Frontend\Module',
            'path' => $di->getConfig()->dirs->modules . '/frontend/Module.php',
        ),
        'common' => array(
            'className' => 'Application\Common\Module',
            'path' => $di->getConfig()->dirs->modules . '/common/Module.php',
        ),
    )
);
