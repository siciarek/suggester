<?php

namespace Application\Common\Exceptions;


class InvalidAccessDataException extends \Exception {
    public function __construct($message = 'error.invalid_access_data', $code = 403, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
