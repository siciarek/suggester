<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 26.09.14
 * Time: 15:56
 */

namespace Application\Common\Exceptions;


class InvalidAccessDataException extends \Exception {
    public function __construct($message = 'error.invalid_access_data', $code = 403, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
