<?php

namespace Application\Common;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Identical;

class CommonForm extends \Phalcon\Forms\Form
{
    /**
     * Form initializer
     *
     * @param Object $data
     * @param array $options
     */
    public function initialize($data, $options)
    {
        $token = $this->security->getSessionToken();

        if($token === null) {
            $this->security->getToken();
            $token = $this->security->getSessionToken();
        }

        $csrf = new Hidden('csrf', array(
             'value' => $token,
        ));

        $csrf->addValidator(new Identical(array(
            'value' => $token,
            'message' => 'form.csrf_validation_failed',
        )));

        $this->add($csrf);
    }
}