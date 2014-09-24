<?php
namespace Application\Frontend\Controller;

use Application\Common\Controller\CommonController;
use Application\Frontend\Entity\Suggestion;
use Application\Frontend\Entity\SuggestionType;
use Application\Frontend\Entity\User;
use Application\Frontend\Form\SuggestionForm;
use Application\Frontend\Form\UserSignInForm;
use Phalcon\Paginator\Pager;
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;

class UserController extends CommonController {

    /**
     * @Route("/sign-in", name="user.sign_in")
     */
    public function signInAction() {

        $data = $_POST;

        $form = new UserSignInForm();

        if ($this->request->getMethod() === 'POST') {
            $accessData = $form->getEntity();
            $form->bind($data, $accessData);

            if ($form->isValid()) {

                if ($this->getDi()->getUser()->authenticate($accessData)) {
                    $session = $this->getDI()->getSession();
                    $target = ['for' => 'home'];

                    if($session->has('$TARGET$')) {
                        $target = $session->get('$TARGET$');
                        $session->remove('$TARGET$');
                    }

                    $this->response->redirect($target, true);
                }

                $form->get('csrf')->appendMessage(new \Phalcon\Validation\Message('error.invalid_access_data'));
            }
        }

        $this->view->form = $form;
    }

    /**
     * @Route("/sign-out", name="user.sign_out")
     */
    public function signOutAction() {

        $this->getDi()->getUser()->logout();
        $this->response->redirect(['for' => 'home']);
    }
}