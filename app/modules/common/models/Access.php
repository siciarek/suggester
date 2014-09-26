<?php

namespace Application\Common;

/**
 * Class Access
 * @package Application\Common
 */
class Access {
    public $username;
    public $password;

    /**
     * @param null $username
     * @param null $password
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }
} 