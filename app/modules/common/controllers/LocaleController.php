<?php
namespace Application\Common\Controller;

class LocaleController extends CommonController {

    /**
     * @Get("/locale/{locale:pl|en}", name="common.locale")
     */
    public function changeAction($locale) {

        $this->getDI()->getSession()->set('locale', $locale);

        $url = $this->request->getHTTPReferer();
        $url = trim($url);
        $url = !empty($url) ? $url : '/';

        $this->response->redirect($url, true);
    }
}
