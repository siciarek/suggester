<?php
namespace Application\Common\Controller;

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

        $accessData = new \stdClass();
        $accessData->username = 'czesolak';
        $accessData->password = 'password';

        $this->getDI()->getUser()->authenticate($accessData);

        $roles = [
            'IS_AUTHENTICATED_ANONYMOUSLY',
            'ROLE_USER',
            'ROLE_ADMIN',
            'ROLE_SUPER_ADMIN',
            'ROLE_PRIVILEGED_ARTICLE_EDITOR',
        ];

        foreach($roles as $role) {
            $temp = [];
            $data = $this->getDI()->getUser()->expandRole($role);
            $temp = array_unique(array_merge($temp, $data), SORT_STRING);
            $output[$role] = $temp;
        }

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
