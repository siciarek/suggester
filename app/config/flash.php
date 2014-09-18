<?php

$di->set('flash', function () {
    $flash = new \Phalcon\Flash\Session(
        array(
            'error' => 'flash alert alert-error',
            'notice' => 'flash alert alert-info',
            'success' => 'flash alert alert-success',
            'warning' => 'flash alert alert-warning',
        )
    );
    return $flash;
});
