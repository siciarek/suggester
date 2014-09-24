<?php

/**
 * Fetch session data with human readable datetime values
 *
 * SELECT
 * session_id,
 * data,
 * FROM_UNIXTIME(created_at) AS created_at,
 * FROM_UNIXTIME(modified_at) AS modified_at
 * FROM `session`
 */

$di->setShared('session', function () use ($di) {

    $session = new Phalcon\Session\Adapter\Files();

    if($di->getConfig()->session->type === 'database' and $di->getConfig()->database->adapter === 'mysql') {
        $session = new Phalcon\Session\Adapter\Database(array(
            'db' => $di->getDb(),
            'table' => $di->getConfig()->session->table,
        ));
    }

    session_name($di->getConfig()->session->name);

    $session->start();

    return $session;
});
