<?php

$di->setShared('cache', function () use ($di) {
    $frontCache = new Phalcon\Cache\Frontend\Data();

    $cacheDir = $di->getConfig()->dirs->cache . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR;

    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }

    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        'cacheDir' => $cacheDir,
    ));

    return $cache;
});
