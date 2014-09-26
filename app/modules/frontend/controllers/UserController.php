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
use Application\Common\Exceptions\InvalidAccessDataException;
use Application\Common\Exceptions\UserDisabledException;

class UserController extends CommonController
{

    /**
     * @Route("/sign-in", name="user.sign_in")
     */
    public function signInAction()
    {
        $data = $_POST;
        $session = $this->getDI()->getSession();

        $form = new UserSignInForm();

        if ($this->request->getMethod() === 'POST') {
            $accessData = $form->getEntity();
            $form->bind($data, $accessData);

            if ($form->isValid()) {

                try {
                    if ($this->getDi()->getUser()->authenticate($accessData)) {
                        $target = ['for' => 'home'];

                        if ($session->has('$PHALCON/REQUIRED_URL$')) {
                            $target = $session->get('$PHALCON/REQUIRED_URL$');
                            $session->remove('$PHALCON/REQUIRED_URL$');
                        }

                        $this->response->redirect($target, true);
                    }
                }
                catch (InvalidAccessDataException $e) {
                    $message = $e->getMessage();
                    $this->response->setStatusCode(403, 'Forbiden');
                }
                catch (UserDisabledException $e) {
                    $message = $e->getMessage();
                    $this->response->setStatusCode(403, 'Forbiden');
                }

                $form->get('csrf')->appendMessage(new \Phalcon\Validation\Message($message));
            }
        }

        if ($session->has('$PHALCON/REQUIRED_URL$')) {
            $this->response->setStatusCode(403, 'Forbiden');
        }

        $this->view->form = $form;
    }

    /**
     * @Route("/sign-out", name="user.sign_out")
     */
    public function signOutAction()
    {

        $this->getDi()->getUser()->logout();
        $this->response->redirect(['for' => 'home']);
    }
}