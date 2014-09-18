<?php

$di->set('security', function () use ($di) {

    $security = new Application\Common\Security();

    //Set the password hashing factor to 12 rounds
    $security->setWorkFactor($di->get('config')->security->rounds);

    return $security;
}, true);

$di->set('user', function() use ($di) {
    $user = new \Application\Backend\Entity\User();

    $user->setFirstName('Jacek');
    $user->setLastName('Siciarek');

    return $user;
});