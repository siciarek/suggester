<?php

namespace Application\Frontend\Form;


use Application\Common\CommonForm;
use Application\Common\Access;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;

class UserSignInForm extends CommonForm {
    /**
     * Form initializer
     *
     * @param Object $data
     * @param array $options
     */
    public function initialize($data, $options) {

        $this->setEntity(new Access());

        /**
         * @var \Phalcon\Translate\Adapter\NativeArray $trans
         */
        $trans = $this->getDI()->getTrans();

        $controls[] = (new Text('username', [
            'required' => true,
            'maxlength' => 64,
            'placeholder' => $trans->query('user.username'),
        ]))
            ->setLabel($trans->query('user.username'))
            ->addFilter('trim')
            ->addFilter('null')
            ->addValidators(array(
                new PresenceOf(array(
                    'message' => 'errors.username_is_required',
                )),
            ));

        $controls[] = (new Password('password', [
            'required' => true,
            'maxlength' => 64,
            'placeholder' => $trans->query('user.password'),
        ]))
            ->setLabel($trans->query('user.password'))
            ->addFilter('trim')
            ->addFilter('null')
            ->addValidators(array(
                new PresenceOf(array(
                    'message' => 'errors.password_is_required',
                )),
            ));

        $controls[] = (new Submit('submit', array(
            'value' => $trans->query('user.sign_in'),
        )));

        foreach ($controls as $control) {
            $this->add($control);
        }

        parent::initialize($data, $options);
    }
}