<?php
namespace Application\Common\Controller;
use Application\Common\Access;

/**
 * @Secure(ROLE_USER)
 * @RoutePrefix("/test")
 */
class TestController extends CommonController {

    /**
     * @Secure(IS_AUTHENTICATED_ANONYMOUSLY)
     * @Route("/", name="test.index")
     */
    public function indexAction() {

        $output = [];

        $output[] = $this->request->getClientAddress();
        $output[] = $this->request->getClientAddress(true);

        return $this->response
            ->setContentType('application/json')
            ->setContent(json_encode($output));
    }

    /**
     * @Secure(IS_AUTHENTICATED_ANONYMOUSLY)
     * @Route("/exception", name="test.exception")
     */
    public function exceptionAction() {
        throw new \Exception('Test Exception', 256);
    }

    /**
     * @Secure(IS_AUTHENTICATED_ANONYMOUSLY)
     * @Route("/guest", name="test.guest")
     */
    public function guestAction() {
        return $this->response->setContent('Guest');
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
