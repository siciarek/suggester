<?php

namespace Application\Common;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Identical;

class CommonForm extends \Phalcon\Forms\Form {
    /**
     * Form initializer
     *
     * @param Object $data
     * @param array $options
     */
    public function initialize($data, $options) {
        $prevToken = $this->security->getSessionToken() ? : $this->security->getSessionToken();
        $token = $this->security->getToken();

        $csrf = (new Hidden('csrf', array('value' => $token)))
            ->addValidator(new Identical(array('value' => $prevToken, 'message' => 'form.csrf_validation_failed')));

        $this->add($csrf);
    }
}