<?php

$di->setShared('access', function () {

    $access = new \Application\Common\Models\Access();

    return $access;
});
