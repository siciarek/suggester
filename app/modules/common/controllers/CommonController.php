<?php
namespace Application\Common\Controller;

abstract class CommonController extends \Phalcon\Mvc\Controller {

    protected function getReferer($default = null) {
        $default = $default ? : ['for' => 'frontend.list'];
        $url = $this->request->getHTTPReferer();
        $url = trim($url);
        $url = !empty($url) ? $url : $this->getDI()->getUrl()->get($default);

        return $url;
    }
}
