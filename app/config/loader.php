<?php
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
        $di->getConfig()->dirs->libs,
        $di->getConfig()->dirs->tasks,
    )
);

$loader->registerNamespaces(
    array(
        'Application\Backend\Controller' => $di->getConfig()->dirs->modules . '/backend/controllers/',

        'Application\Frontend\Controller' => $di->getConfig()->dirs->modules . '/frontend/controllers/',
        'Application\Frontend\Entity' => $di->getConfig()->dirs->modules . '/frontend/models/entities',
        'Application\Frontend\Form' => $di->getConfig()->dirs->modules . '/frontend/models/forms',

        'Application\Common\Controller' => $di->getConfig()->dirs->modules . '/common/controllers/',
        'Application\Common\Plugin' => $di->getConfig()->dirs->modules . '/common/models/plugins/',
        'Application\Common' => $di->getConfig()->dirs->modules . '/common/models',

        'Application\Test' => $di->getConfig()->dirs->tests,
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
        'backend' => array(
            'className' => 'Application\Backend\Module',
            'path' => $di->getConfig()->dirs->modules . '/backend/Module.php',
        ),
        'common' => array(
            'className' => 'Application\Common\Module',
            'path' => $di->getConfig()->dirs->modules . '/common/Module.php',
        ),
    )
);
