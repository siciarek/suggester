<?php

namespace Application\Backend\Form;


use Application\Common\CommonForm;
use Application\Frontend\Entity\User;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class UserForm extends CommonForm {
    /**
     * Form initializer
     *
     * @param Object $data
     * @param array $options
     */
    public function initialize($data, $options) {

        $this->setEntity($data);

        /**
         * @var \Phalcon\Translate\Adapter\NativeArray $trans
         */
        $trans = $this->getDI()->getTrans();


        $controls[] = (new Text('username', array(
            'required' => true,
        )))
            ->setLabel($trans->query('user.username'))
            ->addFilter('trim')
            ->addFilter('null')
        ;

        $controls[] = (new Email('email', array(
            'required' => true,
        )))
            ->setLabel($trans->query('user.email'))
            ->addFilter('email')
        ;

        $controls[] = (new Text('first_name', array(
            'required' => true,
        )))
            ->setLabel($trans->query('user.first_name'))
            ->addFilter('trim')
            ->addFilter('null')
            ->addFilter('title')
        ;

        $controls[] = (new Text('last_name', array(
            'required' => true,
        )))
            ->setLabel($trans->query('user.last_name'))
            ->addFilter('trim')
            ->addFilter('null')
            ->addFilter('title')
        ;

        $controls[] = (new TextArea('description', [
            'required' => true,
            'maxlength' => 512,
            'rows' => 6,
            'placeholder' => $trans->query('common.insert_description'),
        ]))
            ->setLabel($trans->query('user.description'))
            ->addFilter('trim')
            ->addFilter('null')
            ->addValidators(array(
                new PresenceOf(array(
                    'message' => 'errors.content_is_required',
                )),
                new StringLength(array(
                    'max' => 512,
                    'min' => 5,
                    'messageMaximum' => $trans->query('errors.value_is_too_long'),
                    'messageMinimum' => $trans->query('errors.value_is_too_short'),
                )),
            ));

        $controls[] = (new Submit('submit', array(
            'value' => $trans->query('form.save'),
        )));

        foreach ($controls as $control) {
            $this->add($control);
        }

        parent::initialize($data, $options);
    }
}