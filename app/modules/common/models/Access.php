<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 26.09.14
 * Time: 09:29
 */

namespace Application\Common;


class Access {
    public $username;
    public $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
} 