<?php
namespace Application\Frontend\Controller;

use Application\Common\Controller\CommonController;
use Application\Frontend\Entity\Suggestion;
use Application\Frontend\Entity\SuggestionType;
use Application\Frontend\Form\SuggestionForm;
use Phalcon\Paginator\Pager;
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;

/**
 * @Secure(ROLE_USER)
 * @RoutePrefix("/test")
 */
class TestController extends CommonController {

    /**
     * @Secure(IS_AUTHENTICATED_ANONYMOUSLY)
     * @Route("/guest", name="test.guest")
     */
    public function guestAction() {
        return $this->response->setContent('Guest');
    }

    /**
     * @Secure(IS_AUTHENTICATED_ANONYMOUSLY)
     * @Route("/exception", name="test.exception")
     */
    public function exceptionAction() {
        throw new \Exception('Test Exception', 256);
    }

    /**
     * @Route("/user", name="test.user")
     */
    public function userAction() {
        return $this->response->setContent('User');
    }

    /**
     * @Secure(ROLE_ADMIN)
     * @Route("/admin", name="test.admin")
     */
    public function adminAction() {
        return $this->response->setContent('Admin');
    }
}