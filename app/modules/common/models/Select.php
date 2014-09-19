<?php
/**
 * Created by JetBrains PhpStorm.
 * User: siciarek
 * Date: 19.09.14
 * Time: 16:13
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Common;


class Select extends \Phalcon\Forms\Element\Select {

    protected $transPrefix;

    /**
     * \Phalcon\Forms\Element constructor
     *
     * @param string $name
     * @param object|array $options
     * @param array $attributes
     * @param string $transPrefix translation table prefix
     */
    public function __construct($name, $options = null, $attributes = null, $transPrefix = '') {
        $this->transPrefix = $transPrefix;

        return parent::__construct($name, $options, $attributes);
    }

    /**
     * Renders the element widget returning html
     *
     * @param array $attributes
     * @return string
     */
    public function render($attributes = array()) {

        $trans = \Phalcon\DI::getDefault()->getTrans();
        $options = [];
        foreach ($this->getOptions()->toArray() as $s) {
            $options[$s['id']] = $trans->query($this->transPrefix . $s['name']);
        }
        $this->setOptions($options);

        return parent::render($attributes);
    }
}