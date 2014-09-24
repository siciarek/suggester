<?php
/**
 * Created by JetBrains PhpStorm.
 * User: siciarek
 * Date: 23.09.14
 * Time: 18:17
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Common\Translate\Adapter;


class NativeArray extends \Phalcon\Translate\Adapter\NativeArray {
    /**
     * Returns the translation related to the given key
     *
     * @param string $index
     * @param array $placeholders
     * @return string
     */
    public function query($index, $placeholders = null) {

        if (!empty($index) and !array_key_exists($index, $this->_translate)) {

            $transdir = \Phalcon\DI::getDefault()->getConfig()->dirs->translations;
            $new = [ $index => $index . '*' ];
            $this->_translate = $new +  $this->_translate;

            $d = dir($transdir);

            while (($file = $d->read()) !== false){
                if(!preg_match('/^[a-z]{2}\.php$/', $file)) {
                    continue;
                }

                $messages = [];
                $dict = $transdir . DIRECTORY_SEPARATOR . $file;

                require $dict;

                $messages = $new + $messages;
                $content = sprintf("<?php\n\n// app/config/translations/%s\n\n\$messages = %s;", $file, var_export($messages, true));
                file_put_contents($dict, $content);
            }

            $d->close();
        }

        return parent::query($index, $placeholders);
    }
}