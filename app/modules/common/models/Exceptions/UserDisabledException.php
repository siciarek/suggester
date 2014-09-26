<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 26.09.14
 * Time: 15:56
 */

namespace Application\Common\Exceptions;


class UserDisabledException extends \Exception {
    public function __construct($message = 'error.user_disabled', $code = 403, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
