<?php

$di->set('security', function () use ($di) {
    $security = new Application\Common\Security();
    $security->setWorkFactor($di->get('config')->security->rounds);

    return $security;
}, true);

$di->set('user', function () use ($di) {
    $user = new \Application\Common\User();

    return $user;
});

$di->set('roles', function () use ($di) {
    $input = file_get_contents($di->getConfig()->dirs->config . DIRECTORY_SEPARATOR . 'security.yml');
    $hierarchy = \Symfony\Component\Yaml\Yaml::parse($input)['security']['role_hierarchy'];
    $hierarchy['IS_AUTHENTICATED_ANONYMOUSLY'] = null;

    $list = [];

    foreach ($hierarchy as $key => $values) {
        $list[] = $key;
        $list = array_merge($list, is_array($values) ? $values : []);
    }

    $list = array_unique($list, SORT_STRING);

    $roles = new \stdClass();
    $roles->list = $list;
    $roles->assoc = array_fill_keys($list, true);
    $roles->hierarchy = $hierarchy;

    return $roles;
});
