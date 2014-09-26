<?php

namespace Application\Common\Exceptions;


class UserDisabledException extends \Exception {
    public function __construct($message = 'error.user_disabled', $code = 403, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
