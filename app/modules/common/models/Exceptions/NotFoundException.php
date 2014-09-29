<?php

namespace Application\Common\Exceptions;


class NotFoundException extends \Exception {
    public function __construct($message = 'error.not_found', $code = 404, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
