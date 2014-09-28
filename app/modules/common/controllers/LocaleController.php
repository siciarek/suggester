<?php
namespace Application\Common\Controller;

class LocaleController extends CommonController {

    /**
     * @Get("/locale/{locale:[a-z][a-z]}", name="common.locale")
     */
    public function changeAction($locale) {

        $locales = explode(',', $this->getDI()->getConfig()->application->locales);
        $locales = array_map('trim', $locales);

        if(!in_array($locale, $locales)) {
            $locale = 'en';
        }

        $this->getDI()->getSession()->set('locale', $locale);

        $expire = (new \DateTime())->add(new \DateInterval('P1Y'))->getTimestamp();
        $this->getDi()->getCookies()->set('SUGGESTER_LOCALE', $locale, $expire, '/', false, null, false);

        $url = $this->request->getHTTPReferer();
        $url = trim($url);
        $url = !empty($url) ? $url : '/';

        $this->response->redirect($url, true);
    }
}
