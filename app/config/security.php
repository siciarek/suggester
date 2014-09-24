<?php

$di->set('security', function () use ($di) {

    $security = new Application\Common\Security();

    //Set the password hashing factor to 12 rounds
    $security->setWorkFactor($di->get('config')->security->rounds);

    return $security;
}, true);

$di->set('user', function() use ($di) {
    $user = new \Application\Common\User();

    return $user;
});

$di->set('roles', function() use ($di) {
    $input = file_get_contents($di->getConfig()->dirs->config . DIRECTORY_SEPARATOR . 'security.yml');
    $roles = \Symfony\Component\Yaml\Yaml::parse($input)['security']['role_hierarchy'];

    return $roles;
});
