<?php

$includes = array(
    '/config/config.php',
    '/../vendor/autoload.php',
    '/config/database.php',
    '/config/session.php',
    '/config/cache.php',
    '/config/flash.php',
    '/config/localisation.php',
    '/config/filters.php',
    '/config/events.php',
    '/config/loader.php',
    '/config/routing.php',
    '/config/view.php',
    '/config/security.php',
    '/config/access.php',
    '/config/logger.php',
);

foreach($includes as $e) {
    require_once APPLICATION_PATH . $e;
}