<?php

namespace Application\Frontend\Form;


use Application\Common\CommonForm;
use Application\Frontend\Entity\SuggestionType;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Application\Common\Select  as XSelect;

class SuggestionForm extends CommonForm {
    /**
     * Form initializer
     *
     * @param Object $data
     * @param array $options
     */
    public function initialize($data, $options) {

        $this->setEntity($data);

        $trans = $this->getDI()->getTrans();

        $author = array_key_exists('author', $options) ? $options['author'] : $trans->query('common.anonymous');
        $application = array_key_exists('application', $options) ? $options['application'] : null;

        $priorities = array();
        foreach (['C', 'M', 'S', 'W'] as $p) {
            $priorities[$p] = mb_convert_case($trans->query('priority.' . $p), MB_CASE_LOWER, 'UTF-8');
        }
        $controls = array();
        $controls[] = (new Select('priority', $priorities, ['required' => true]))
            ->setLabel($trans->query('suggestion.priority'))
            ->addFilter('trim')
            ->addValidators(
                array(
                    new InclusionIn(array(
                        'message' => 'errors.invalid_priority',
                        'domain' => array_keys($priorities),
                    )),
                )
            );

        $type_ids = (new XSelect('type_id',
            SuggestionType::find(),
            array(
                'using' => array('id', 'name'),
                'required' => true,
                'useEmpty' => true,
                'emptyText' => $trans->query('form.select_from_list'),
                'emptyValue' => ''
            ), 'suggestion.'))
            ->setLabel($trans->query('suggestion.type'))
            ->addFilter('trim')
            ->addFilter('int');

        $controls[] = $type_ids;

        $controls[] = (new TextArea('content', [
            'required' => true,
            'maxlength' => 512,
            'rows' => 6,
            'placeholder' => $trans->query('common.insert_description'),
        ]))
            ->setLabel($trans->query('suggestion.content'))
            ->addFilter('trim')
            ->addFilter('null')
            ->addValidators(array(
                new PresenceOf(array(
                    'message' => 'errors.content_is_required',
                )),
            ));

        $controls[] = (new Hidden('page_url', array(
            'value' => null,
        )))
            ->addFilter('trim')
            ->addFilter('null');

        $controls[] = (new Hidden('author', array(
            'value' => $author,
        )))
            ->addFilter('trim')
            ->addFilter('null');

        $controls[] = (new Hidden('application', array(
            'value' => $application,
        )))
            ->addFilter('trim')
            ->addFilter('null');

        $controls[] = (new Submit('submit', array(
            'value' => $trans->query('form.save'),
        )));

        foreach ($controls as $control) {
            $this->add($control);
        }

        parent::initialize($data, $options);
    }
}