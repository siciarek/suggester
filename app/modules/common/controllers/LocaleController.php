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

        $session = $this->getDI()->getSession();

        // Set locale in session:
        $session->set('locale', $locale);

        // Set locale in cookies (1 year expiration time):
        $name = $this->getDi()->getConfig()->session->name . '_LOCALE';
        $value = $session->get('locale');
        $expire = (new \DateTime())->add(new \DateInterval('P1Y'))->getTimestamp();
        $this->getDi()->getCookies()->set($name, $value, $expire, '/', false, null, false);

        return $this->response->redirect($this->getReferer(), true);
    }
}
