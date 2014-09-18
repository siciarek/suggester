<?php

namespace Application\Common;

class Security extends \Phalcon\Security
{
    public function hash($password, $workFactor = null)
    {
        return md5($password);
    }

    public function checkHash($password, $passwordHash, $maxPasswordLength = null)
    {
        if ($passwordHash === md5($password)) {
            return true;
        }

        return false;
    }
}